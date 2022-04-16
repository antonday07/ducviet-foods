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

    // /**
    //  * Checkout by vnpay online
    //  *
    //  * @return void
    //  */
    // private function checkoutOnline()
    // {
    //     session(['cost_id' => $request->id]);
    //     session(['url_prev' => url()->previous()]);
    //     $vnp_TmnCode = "V7ERK2V3"; //Mã website tại VNPAY 
    //     $vnp_HashSecret = str_random(10); //Chuỗi bí mật
    //     $vnp_Url = "http://sandbox.vnpayment.vn/paymentv2/vpcpay.html";
    //     $vnp_Returnurl = "http://localhost:8000/return-vnpay";
    //     $vnp_TxnRef = date("YmdHis"); //Mã đơn hàng. Trong thực tế Merchant cần insert đơn hàng vào DB và gửi mã này sang VNPAY
    //     $vnp_OrderInfo = "Thanh toán hóa đơn phí dich vụ";
    //     $vnp_OrderType = 'billpayment';
    //     $vnp_Amount = $request->input('amount') * 100;
    //     $vnp_Locale = 'vn';
    //     $vnp_IpAddr = request()->ip();

    //     $inputData = array(
    //         "vnp_Version" => "2.0.0",
    //         "vnp_TmnCode" => $vnp_TmnCode,
    //         "vnp_Amount" => $vnp_Amount,
    //         "vnp_Command" => "pay",
    //         "vnp_CreateDate" => date('YmdHis'),
    //         "vnp_CurrCode" => "VND",
    //         "vnp_IpAddr" => $vnp_IpAddr,
    //         "vnp_Locale" => $vnp_Locale,
    //         "vnp_OrderInfo" => $vnp_OrderInfo,
    //         "vnp_OrderType" => $vnp_OrderType,
    //         "vnp_ReturnUrl" => $vnp_Returnurl,
    //         "vnp_TxnRef" => $vnp_TxnRef,
    //     );

    //     if (isset($vnp_BankCode) && $vnp_BankCode != "") {
    //         $inputData['vnp_BankCode'] = $vnp_BankCode;
    //     }
    //     ksort($inputData);
    //     $query = "";
    //     $i = 0;
    //     $hashdata = "";
    //     foreach ($inputData as $key => $value) {
    //         if ($i == 1) {
    //             $hashdata .= '&' . $key . "=" . $value;
    //         } else {
    //             $hashdata .= $key . "=" . $value;
    //             $i = 1;
    //         }
    //         $query .= urlencode($key) . "=" . urlencode($value) . '&';
    //     }

    //     $vnp_Url = $vnp_Url . "?" . $query;
    //     if (isset($vnp_HashSecret)) {
    //        // $vnpSecureHash = md5($vnp_HashSecret . $hashdata);
    //         $vnpSecureHash = hash('sha256', $vnp_HashSecret . $hashdata);
    //         $vnp_Url .= 'vnp_SecureHashType=SHA256&vnp_SecureHash=' . $vnpSecureHash;
    //     }
    //     return redirect($vnp_Url);
    // }

    // public function return(Request $request)
    // {
    //     $url = session('url_prev','/');
    //     if($request->vnp_ResponseCode == "00") {
    //         $this->apSer->thanhtoanonline(session('cost_id'));
    //         return redirect($url)->with('success' ,'Đã thanh toán phí dịch vụ');
    //     }
    //     session()->forget('url_prev');
    //     return redirect($url)->with('errors' ,'Lỗi trong quá trình thanh toán phí dịch vụ');
    // }
}
