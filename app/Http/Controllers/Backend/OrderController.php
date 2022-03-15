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
        // Carbon::setLocale('vi'); // hiển thị ngôn ngữ tiếng việt.
        // $now = Carbon::now();
        // $keyword = '';
        // if ($request->keyword) {
        //     $keyword = htmlspecialchars($request->keyword);
        // }
        // $bills = Bill::where('Phone', 'LIKE', '%' . $keyword . '%');
        // if ($request->status) {
        //     $status = $this->bindStatus($request->status);
        //     $bills = $bills->where('Status', $status);
        // }
        // $bills = $bills->orderBy('created_at', 'desc')->paginate(7);
                
        return view('backend.contents.order.index');
    }
    
    public function getDatatable(Request $request, Bill $bill)
    {
        if($request->ajax()){
            $bills = $bill->findAllBill($request);
        
            return DataTables::of($bills)
            ->addIndexColumn()
            ->addColumn('customer', function($item){
               return $item->user->name;                                
            })          
            ->addColumn('address', function($item){
                return $item->delivery_address;
            })
            ->addColumn('status', function($item){
                $badgeName = [
                    1 => 'badge-info',
                    2 => 'badge-secondary',
                    3 => 'badge-primary'
                ];
                return '<span class="badge ' . $badgeName[$item->status] . ' ">' . config('constants.status_order_label')[$item->status] . '</span>';
            })
            ->addColumn('status_payment', function($item){
                $badgeName = [
                    1 => 'badge-info',
                    2 => 'badge-secondary',
                    3 => 'badge-primary'
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
                    'routeEdit' => route('order.detail', [$item->id]),
                    'routeDelete' => route('order.cancel'),
                ]);
            })
            ->rawColumns(['action', 'status', 'status_payment'])
            ->make(true);
        }
    }
    public function detail($id)
    {
        $bill = Bill::find($id);
        $billdetail = $bill->billDetails;
        return view('backend.contents.order.detail', compact('bill', 'billdetail'));
    }
    public function changeStatus(Request $request)
    {
        $check = Bill::where('id', $request->id)->update(['Status' => $request->status]);
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
