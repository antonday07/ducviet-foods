<?php

namespace App\Http\Controllers\Backend;

use App\Http\Controllers\Controller;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class OrderController extends Controller
{
    public function index(Request $request)
    {                  
        return view('backend.contents.order.index');
    }
    
    public function getDatatable(Request $request, Bill $bill)
    {
        if($request->ajax()){
            $bills = $bill->findAllBill($request);
        
            return DataTables::of($bills)
            ->addIndexColumn()
            ->addColumn('code', function($item){
                return  '#' . $item->code_bill;                                
             })  
            ->addColumn('customer', function($item){
               return $item->bill_name;                                
            })          
            ->addColumn('address', function($item){
                return $item->delivery_address;
            })
            ->addColumn('status', function($item){
                $badgeName = [
                    1 => 'badge-info',
                    2 => 'badge-secondary',
                    3 => 'badge-primary',
                    4 => 'badge-success'
                ];
                return '<span class="badge ' . $badgeName[$item->status] . ' ">' . config('constants.status_order_label')[$item->status] . '</span>';
            })
            ->addColumn('status_payment', function($item){
                $badgeName = [
                    1 => 'badge-info',
                    2 => 'badge-primary',
                    3 => 'badge-secondary'
                ];
                return '<span class="badge ' . $badgeName[$item->status_payment] . ' ">' . config('constants.status_order_payment_label')[$item->status_payment] . '</span>';
            })
            ->addColumn('date_import', function($item){
                return $item->date;
            })
            ->addColumn('total', function($item){
                return  number_format($item->total_price, 0,'', '.') . ' đ';
            })
            ->addColumn('action', function($item){
                return view('backend.contents.elements.custom-action-order', [
                    'routeShow' => route('order.detail', [$item->id]),
                    'routeEdit' => route('order.edit', [$item->id]),
                ]);
            })
            ->rawColumns(['action', 'status', 'status_payment'])
            ->make(true);
        }
    }
    public function detail($id)
    {
        $bill = Bill::with('billDetails')->where('id', $id)->first();
        return view('backend.contents.order.detail', compact('bill'));
    }
    public function changeStatus(Request $request)
    {
      
        $check = Bill::where('id', $request->id)->update(["$request->type" => $request->status]);
        if ($check == '1') {
            return 'success';
        } else {
            return 'error';
        }
    }
    public function cancelOrder(Request $request)
    {
        $status = $request->status;
        $update = Bill::where('id', $request->id);

        if ($status == '2') {
            $update->update(['Status' => $request->status]);
            return 'success';
        } else {
            return 'error';
        }
    }
    public function bindStatus($status)
    {
        if ($status == 'dang-xu-ly') {
            return '0';
        } else if ($status == 'thanh-cong') {
            return '1';
        } else if ($status == 'that-bai') {
            return '2';
        }
    }
}
