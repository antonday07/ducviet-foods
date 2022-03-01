<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SupplierController extends Controller
{
    public function index() {
        return view('backend.contents.supplier.index');
    }

    public function getDatatable(Request $request)
    {
        if($request->ajax()){
            $suppliers = Supplier::all();
                return DataTables::of($suppliers)
                ->addIndexColumn()
                ->addColumn('name', function($item){
                    return $item->name;
                })
                ->addColumn('email', function($item){
                    return $item->email;
                })
                ->addColumn('phone', function($item){
                    return $item->phone;
                })
                ->addColumn('address', function($item){
                    return $item->address;
                })
                ->addColumn('action', function($item){
                    return view('backend.contents.elements.custom-action', [
                        'routeEdit' => route('supplier.edit', [$item->id]),
                        'routeDelete' => route('supplier.delete', [$item->id]),
                    ]);
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }
    public function create() {
        return view('backend.contents.supplier.create');
    }
    public function store(Request $request) {
        $request->validate([
            'name' => 'required|min:5|max:225|string',
            'email'=>'required|min:5|email|max:50',
            'phone' => 'required|regex:/^([0-9\s\-\+\(\)]*)$/|min:10|max:12',
            'address' => 'required|string|max:255'
        ]);

        $data = $request->all();
        $supplier = Supplier::create($data);

        if ($supplier) {
            flasher(__('web.action_success', ['action' => 'Thêm nhà cung cấp']), 'success');
            return redirect()->route('supplier.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Thêm nhà cung cấp']), 'error');
            return 'Error!!';
        }
    }
    public function edit($id) {
        $supplier = Supplier::find($id);
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
        $supplier = Supplier::where('id', $id)->update($data);

        if ($supplier) {
            flasher(__('web.action_success', ['action' => 'Cập nhập nhà cung cấp']), 'success');
            return redirect()->route('supplier.index');
        } else {
            flasher(__('web.action_failed', ['action' => 'Cập nhập nhà cung cấp']), 'error');
            return 'Error!!';
        }
    }
    public function delete($id) {
        $supplier = Supplier::findOrFail($id);
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
