<?php

namespace App\Http\Controllers\Backend;

use App\Events\TrackingOrderStatus;
use App\Http\Controllers\Controller;
use App\Models\BillDetail;
use Illuminate\Http\Request;
use App\Models\Bill;
use App\Models\BillImportDetail;
use App\Models\Product;
use App\Models\Warehouse;
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
                    1 => 'badge-light',
                    2 => 'badge-info',
                    3 => 'badge-primary',
                    4 => 'badge-warning',
                    5 => 'badge-success',
                    6 => 'badge-danger'
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
    public function changeStatus(Request $request, Warehouse $warehouse)
    {
        $productId = [];
        $check = Bill::where('id', $request->id)->update(["$request->type" => $request->status]);
        $bill = Bill::with('billDetails')->where('id', $request->id)->first();

        if($request->status == Bill::CONFIRMED_STATUS) {
            foreach($bill->billDetails as $item) {
                $productId[] = $item->product_id;
                $product = $warehouse->findByProductId($item->product_id);
                
                if(!empty($product) && $product->quantity <= 0) {
                    return [
                        'status' => 'error',
                        'message' => 'Sản phẩm này đã hết số lượng trong kho'
                    ];
                }
                $quantity = !empty($product) ? $product->quantity - $item->amount : 0;
        
                $warehouse->updateWarehouse($item->product_id, $quantity);

                // tăng số lượng của lô hàng đã bán lên 
            }  
            // $bills = BillImportDetail::whereIn('product_id', $productId)->where('expiry_date', '<=' Carbon::now())
            // dd($bills);

        }
        if ($check == '1') {
            return [
                'status' => 'success',
                'message' => 'Xác nhận thành công'
            ];
        } else {
            return [
                'status' => 'error',
                'message' => 'Xác nhận thất bại'
            ];
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


    public function updateStatusOrder(Request $request)
    {
        $request->validate([
            'order_id' => 'required|exists:bills,id',
            'status' => 'required|numeric|in:3,4'
        ]);

        Bill::where('id', $request->order_id)->update([
            'status' => $request->status
        ]);

        $bill = Bill::where('id', $request->order_id)->first();

        $message = $request->status == Bill::SHIPPING_STATUS ? 'Đơn hàng đang được vận chuyển' : 'Đơn hàng đã vận chuyển thành công';

        // push notification
        event(new TrackingOrderStatus($bill, $message));

        return response()->json([
            'message' => $message, 
            'status' => 'success'
        ]);
    }
}
