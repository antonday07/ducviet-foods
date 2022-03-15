<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\BillImport;
use App\Models\BillImportDetail;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\Promotion;
use App\Models\Supplier;
use App\Models\Unit;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

class BillImportController extends Controller
{
    
    public function index() {
        return view('backend.contents.bill-import.index');
    }

    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $bills = BillImport::all();
                return DataTables::of($bills)
                ->addIndexColumn()
                ->addColumn('bill_id', function($item){
                    return $item->code_bill;
                })
                ->addColumn('description', function($item){
                    return $item->description ;
                })
                ->addColumn('employee', function($item){
                    return $item->employee->name;
                })
                ->addColumn('note', function($item){
                    return $item->note;
                })
                ->addColumn('created_at', function($item){
                    return $item->date_import;
                })
                ->addColumn('action', function($item){
                    return view('backend.contents.elements.custom-action', [
                        'routeEdit' => route('bill.import.edit', [$item->id]),
                        'routeDelete' => route('bill.import.delete', [$item->id]),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function create() {
        return view('backend.contents.bill-import.create', [
            'products' => Product::select('id', 'name', 'entry_price')->get(),
            'suppliers' => Supplier::select('id', 'name')->get()
        ]);
    }
    public function store(Request $request, BillImport $billImport, BillImportDetail $billImportDetail) {
        $request->validate([
            'product' => 'required|array',
            'product.*.product_id' => 'required|exists:products,id',
            'product.*.supplier_id'=> 'required|exists:suppliers,id',
            'product.*.entry_date' => 'required|date',
            'product.*.expiry_date' => 'required|date', 
            'product.*.price' => 'required|numeric', 
            'product.*.amount' => 'required|numeric|max:100',
            'description' => 'required|string|max:255',
            'note' => 'required|string|max:555',
        ]);
        // dd($totalPrice, $request->all());
        try {
            DB::beginTransaction();
            
            $totalPrice = $billImport->calTotalPrice($request->product);
            $data = [
                'employee_id' => auth()->user()->id,
                'code_bill' => 'b-' . Str::random(10),
                'description' => $request->description,
                'note' => $request->note,              
                'total_price' => $totalPrice,
                'date_import' => now()
            ];            
            $bill = $billImport->insertBillImport($data);            
            $billImportDetail->insertProductBill($request, $bill->id);           
            DB::commit();
            flasher(__('web.action_success', ['action' => 'Thêm đơn nhâp hàng']), 'success');
            return redirect()->route('bill.import.index');
        } catch(Exception $ex) {    
            DB::rollBack();
            flasher(__('web.action_failed', ['action' => 'Thêm đơn nhâp hàng']), 'error');
            return 'Error!!';
        }
    }
    public function edit($id) {
        $supplier = BillImport::find($id);
        return view('backend.contents.supplier.edit', compact('supplier'));
    }
    public function update($id, Request $request) {
        $request->validate([
            'name' => 'required|min:5|max:225|string',
            'email'=>'required|min:5|email|max:50',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:12',
            'address' => 'required|string|max:255'
        ]);
        $data = $request->all();
        unset($data['_token']);
        $supplier = BillImport::where('id', $id)->update($data);

        if ($supplier) {
            flasher(__('web.action_success', ['action' => 'Cập nhật đơn nhập hàng']), 'success');
            return redirect()->route('supplier.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập đơn nhập hàng']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $supplier = BillImport::findOrFail($id);
        $status = $supplier->delete();
        if( $status ) {
            $success = true;
            $message = "Xóa nhà cung cấp thành công!";
        } else {
            $success = false;
            $message = "Xóa nhà cung cấp thất bại!";
        }
        return response()->json([
            'success' => $success,
            'message' => $message,
        ]);
    }
}
