@extends('frontend.layouts.main')
@section('css')
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.css">
@endsection
@section('content')

    <div class="my-account-wrapper pb-100 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <!-- My Account Page Start -->
                    <div class="myaccount-page-wrapper">
                        <!-- My Account Tab Menu Start -->
                        <div class="row">
                            <div class="col-lg-3 col-md-4">
                                <div class="myaccount-tab-menu nav" role="tablist">
                                    <a href="#order-info" class="active" data-bs-toggle="tab">Chi tiết đơn hàng</a>
                                    {{-- <a href="#account-info" class="active" data-bs-toggle="tab">Thông tin tài khoản</a> --}}                                
                                </div>
                            </div>
                            <!-- My Account Tab Menu End -->
                            <!-- My Account Tab Content Start -->
                            <div class="col-lg-9 col-md-8">
                                <div class="tab-content" id="myaccountContent">

                                    <!-- Single Tab Content Start -->
                                    <div class="tab-pane fade show active" id="order-info" role="tabpanel">
                                        <div class="container padding-bottom-3x mb-1">
                                            <div class="card mb-3">
                                                  <div class="p-4 text-center text-white text-lg bg-dark rounded-top"><span class="text-uppercase">Theo dõi đơn hàng - </span><span class="text-medium">#{{ $order->code_bill }}</span></div>
                                                  <div class="d-flex flex-wrap flex-sm-nowrap justify-content-between py-3 px-2 bg-secondary">
                                                    <div class="w-100 text-left py-1 px-2">
                                                        <p><span class="text-medium">Tên người nhận:</span> {{ $order->bill_name }}</p>
                                                        <p><span class="text-medium">Số điện thoại:</span> {{ $order->bill_phone }}</p>                                                                                                    
                                                        <p><span class="text-medium">Địa chỉ:</span> {{ $order->delivery_address }}</p>
                                                    </div>
                                                    <div class="w-100 text-left py-1 px-2">
                                                        <p class="text-medium">Sản phẩm</p>
                                                        <ul>
                                                            @foreach ($order->billDetails as $item)
                                                                <li>{{ $item->product->name }} - giá: {{ number_format($item->price , 0, '', '.') }} đ  - số lượng: {{ $item->amount }} - tổng tiền: {{ number_format($item->price * $item->amount, 0, '', '.') }} đ</li>
                                                            @endforeach
                                                            <li></li>
                                                        </ul>
 
                                                    </div>
                                                    <div class="w-100 text-left py-1 px-2"><span class="text-medium">Ngày đặt:</span> {{ $order->date }}</div>
                                                  </div>
                                                  <div class="card-body">
                                                    <div class="steps d-flex flex-wrap flex-sm-nowrap justify-content-between padding-top-2x padding-bottom-1x">
                                                      <div class="step {{ $order->status >= 1 ? 'completed' : '' }}">
                                                        <div class="step-icon-wrap">
                                                          <div class="step-icon"><i class="pe-7s-config"></i></div>
                                                        </div>
                                                        <h4 class="step-title">Chờ xác nhận</h4>
                                                      </div>
                                                      <div class="step {{ $order->status >= 2 ? 'completed' : '' }}">
                                                        <div class="step-icon-wrap">
                                                          <div class="step-icon"><i class="pe-7s-check"></i></div>
                                                        </div>
                                                        <h4 class="step-title">Đã xác nhận</h4>
                                                      </div>
                                                      <div class="step {{ $order->status >= 3 ? 'completed' : '' }}">
                                                        <div class="step-icon-wrap">
                                                          <div class="step-icon"><i class="pe-7s-box1"></i></div>
                                                        </div>
                                                        <h4 class="step-title">Đang vận chuyển</h4>
                                                      </div>
                                                      <div class="step {{ $order->status >= 4 ? 'completed' : '' }}">
                                                        <div class="step-icon-wrap">
                                                          <div class="step-icon"><i class="pe-7s-home"></i></div>
                                                        </div>
                                                        <h4 class="step-title">Đã vận chuyển</h4>
                                                      </div>
                                                      <div class="step {{ $order->status >= 5 ? 'completed' : '' }}">
                                                        <div class="step-icon-wrap">
                                                          <div class="step-icon"><i class="pe-7s-like2"></i></div>
                                                        </div>
                                                        <h4 class="step-title">Đã nhận hàng</h4>
                                                      </div>
                                                    </div>
                                                  </div>
                                                </div>
                                                <div class="d-flex flex-wrap flex-md-nowrap justify-content-center justify-content-sm-end align-items-center">
                                                  {{-- <div class="custom-control custom-checkbox mr-3">
                                                    <input class="custom-control-input" type="checkbox" id="notify_me" checked="">
                                                    <label class="custom-control-label" for="notify_me">Notify me when order is delivered</label>
                                                  </div> --}}
                                                  <div class="text-left text-sm-right"><a class="btn btn-secondary btn-rounded btn-sm" id="btnCancelOrder" href="{{ route('profile') }}">Quay lại </a></div>
                                                  <div class="text-left text-sm-right"><a class="btn btn-danger btn-rounded btn-sm" id="btnCancelOrder" href="#">Hủy đơn hàng</a></div>
                                                </div>
                                        </div>
                                    </div>
                                    <!-- Single Tab Content End -->

                                    
                                  
                                </div>
                            </div> <!-- My Account Tab Content End -->
                        </div>
                    </div> <!-- My Account Page End -->
                </div>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/notyf@3/notyf.min.js"></script>
    <!-- my account wrapper end -->
    @if (session('success'))
        <script>
            var notyf = new Notyf();
            notyf.success('Thay đổi thành công!');

        </script>
    @endif
    @if (session('error'))
        <script>
            var notyf = new Notyf();
            notyf.error('Vui lòng thử lại!');

        </script>
    @endif

@endsection
@section('js')
@endsection
