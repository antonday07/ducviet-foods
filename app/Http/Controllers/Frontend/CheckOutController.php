<?php

namespace App\Http\Controllers\Frontend;

use App\Events\NewOrderComing;
use App\Events\notification;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use App\Http\Requests\CheckingInfoRequest;
use App\Models\Bill;
use App\Models\BillDetail;
use App\Models\User;
use App\Models\Warehouse;
use Exception;
use Illuminate\Support\Facades\DB;

class CheckOutController extends Controller
{
    public function Checkout()
    {       
        return view('frontend.contents.checkout');
    }
    public function FinishShopping(CheckingInfoRequest $request, Bill $bill, BillDetail $billDetail, User $user)
    {
        try {
            DB::beginTransaction();
                $dataBill = [
                    'code_bill' => mt_rand(100000000,999999999),
                    'user_id' => auth()->user()->id,
                    'note' => $request->message,
                    'date' => now(),
                    'delivery_address' => $request->address,
                    "bill_phone" => $request->phone,
                    "bill_name" => $request->name,
                    "bill_email" => $request->email,
                    'status' => Bill::WAIT_CONFIRM_STATUS,
                    'status_payment' => Bill::UNPAID_STATUS
                ];
                $dataUser = [
                    'phone' => $request->phone,
                    'address' => $request->address
                ];          
              
                $new_bill = $bill->createBill($dataBill);

                $user->updateInfoUser($dataUser, auth()->user()->id);
            
                $totalPrice = $billDetail->insertBillDetail(session('cart'), $new_bill->id);
                Bill::where('id', $new_bill->id)->update(['total_price' => $totalPrice]);
            DB::commit();
            // push notification
            event(new NewOrderComing($new_bill));

            session()->forget('cart');
            flasher(__('web.action_success', ['action' => 'Đặt hàng']), 'success');
            return redirect()->route('product');

        } catch(Exception $ex) {
            DB::rollBack();
            flasher(__('web.action_failed', ['action' => 'Đặt hàng']), 'error');
            return back();
        }      
    }
}
