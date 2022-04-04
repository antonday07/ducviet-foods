@extends('backend.layouts.main')

@section('content')
    <!-- content @s -->
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between g-3">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Chi tiết đơn hàng / <strong
                                        class="text-primary small">Mã đơn hàng: #{{ $bill->code_bill }}</strong></h3>
                            </div>
                            <div class="nk-block-head-content">

                                <a href="{{ route('order.index') }}"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><span>Back</span></a>
                                {{-- <a href="html/ecommerce/customers.html"
                                    class="btn btn-icon btn-outline-light bg-white d-inline-flex d-sm-none"><em
                                        class="icon ni ni-arrow-left"></em></a> --}}
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="card">
                            <div class="card-aside-wrap">
                                <div class="card-content">
                                    <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#"><i
                                                    class="fas fa-user-tag mr-1"></i><span>Thông tin đơn hàng</span></a>
                                        </li>

                                        {{-- <li class="nav-item">
                                            <a class="nav-link" href="#"><em class="icon ni ni-repeat"></em><span>Đơn
                                                    hàng</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><em
                                                    class="icon ni ni-bell"></em><span>Notifications</span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#"><em
                                                    class="icon ni ni-activity"></em><span>Activities</span></a>
                                        </li>
                                        <li class="nav-item nav-item-trigger d-xxl-none">
                                            <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em
                                                    class="icon ni ni-user-list-fill"></em></a>
                                        </li> --}}
                                    </ul><!-- .nav-tabs -->
                                    <div class="card-inner">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <div class="row">
                                                    <div class="col-7">
                                                        @php
                                                             $badgeName = [
                                                                1 => 'badge-light',
                                                                2 => 'badge-info',
                                                                3 => 'badge-primary',
                                                                4 => 'badge-warning',
                                                                5 => 'badge-success',
                                                                6 => 'badge-danger',
                                                            ];

                                                            $badgeNamePayment = [
                                                                1 => 'badge-success',
                                                                2 => 'badge-primary',
                                                                3 => 'badge-secondary'
                                                            ];
                                                        @endphp 
                                                        <h5 class="title">Thông tin đơn hàng 
                                                            <span class="badge {{ $badgeName[$bill->status] }}">{{ config('constants.status_order_label')[$bill->status] }}</span>
                                                            <span class="badge {{ $badgeNamePayment[$bill->status_payment] }}">{{ config('constants.status_order_payment_label')[$bill->status_payment] }}</span>
                                                        </h5>
                                                        {{-- <p>Thông tin cơ bản, như tên và địa chỉ giao hàng</p> --}}
                                                    </div>
                                                    <div class="col-5 d-flex justify-content-end">
                                                        @if ($bill->status != 6)                                                            
                                                            <form action="" method="POST" class="mr-2" id="form-cancel-order">
                                                                @csrf
                                                                <button type="button" data-id="{{ $bill->id }}"
                                                                    data-url="{{ route('order.change') }}"
                                                                    data-status="6"
                                                                    id="cancelOrder" class="btn btn-danger">Hủy đơn
                                                                    hàng</button>
                                                            </form>
                                                        @endif

                                                        @if ($bill->status == 1) 
                                                            <form action="" method="POST" id="form-confirm-order">
                                                                @csrf
                                                                <button type="button" data-id="{{ $bill->id }}"
                                                                    data-url="{{ route('order.change') }}"
                                                                    data-status="2"
                                                                    
                                                                    id="confirmOrder" class="btn btn-info">Xác nhận đơn hàng</button>
                                                            </form>                                                        
                                                        @endif
                                                    </div>
                                                  
                                                </div>

                                            </div><!-- .nk-block-head -->
                                            <div class="profile-ud-list">
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Địa chỉ email</span>
                                                        <span class="profile-ud-value">{{ $bill->bill_email }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Số điện thoại</span>
                                                        <span class="profile-ud-value">{{ $bill->bill_phone }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Địa chỉ nhận hàng</span>
                                                        <span class="profile-ud-value">{{ $bill->delivery_address }}</span>
                                                    </div>
                                                </div>

                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Ghi chú</span>
                                                        <span class="profile-ud-value">{{ $bill->note }}</span>
                                                    </div>
                                                </div>


                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Ngày đặt hàng</span>
                                                        <span
                                                            class="profile-ud-value">{{ date('d/m/Y', strtotime($bill->date)) }}</span>
                                                    </div>
                                                </div>
                                                <div class="profile-ud-item">
                                                    <div class="profile-ud wider">
                                                        <span class="profile-ud-label">Tên khách hàng</span>
                                                        <span class="profile-ud-value">{{ $bill->bill_name }}</span>
                                                    </div>
                                                </div>
                                                {{-- <div class="profile-ud-item">                                                 
                                                        <div class="profile-ud wider">

                                                            <span class="profile-ud-label">Cập nhật trạng thái đơn hàng</span>

                                                            @if ($bill->status == 6)    
                                                                Đã hủy đơn
                                                            @else
                                                                <select class="form-select" data-id="{{ $bill->id }}"                                                                     
                                                                    data-type="status"
                                                                    data-url="{{ route('order.change') }}"
                                                                    id="order-status">
                                                                    <option selected>Chọn trạng thái</option>                                                         
                                                                    <option value="3"
                                                                        {{ $bill->status == 3 ? 'selected' : '' }}>Đang vận chuyển</option>
                                                                    <option value="4"
                                                                        {{ $bill->status == 4 ? 'selected' : '' }}>Đã vận chuyển</option>
                                                                    <option value="5"
                                                                        {{ $bill->status == 5 ? 'selected' : '' }}>Đã nhận hàng</option>
                                                                
                                                                </select>
                                                            @endif
                                                        </div>
                                                </div> --}}

                                                {{-- <div class="profile-ud-item">
                                                        <div class="profile-ud wider">

                                                            <span class="profile-ud-label">Trạng thái thanh toán</span>

                                                            <select class="form-select" data-id="{{ $bill->id }}"
                                                                     data-type="status_payment" 
                                                                     data-url="{{ route('order.change') }}"
                                                                     id="order-status-payment">
                                                                <option selected>Chọn trạng thái</option>
                                                                <option value="1" {{ $bill->status_payment ==  1 ? 'selected' : '' }}>Đã thanh toán</option>
                                                                <option value="2" {{ $bill->status_payment == 2 ? 'selected' : '' }}>Chưa thanh toán</option>
                                                            </select>

                                                        </div>
                                                </div> --}}

                                            </div><!-- .profile-ud-list -->
                                        </div><!-- .nk-block -->


                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="nk-block">
                                            <div class="nk-block-head">
                                                <h5 class="title">Chi tiết hóa đơn</h5>
                                                <p>Thông tin chi tiết đơn hàng, các sản phẩm trong đơn hàng</p>
                                            </div><!-- .nk-block-head -->
                                            <div class="table-order">
                                                <table class="table">
                                                    <thead>
                                                        <tr>

                                                            <th scope="col">Tên sản phẩm</th>
                                                            <th scope="col">Đơn giá</th>
                                                            <th scope="col">Số lượng</th>
                                                            <th scope="col">Thành tiền</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody>

                                                        @foreach ($bill->billDetails as $item)
                                                           
                                                            <tr>
                                                                <td>{{ $item->product->name }}</td>
                                                                <td>{{ number_format($item->price , 0, '', '.') }} đ</td>
                                                                <td>{{ $item->amount  }}</td>
                                                                <td>{{ number_format($item->price * $item->amount, 0, '', '.') }} đ</td>
                                                            </tr>

                                                        @endforeach
                                                        <tr>

                                                            <td colspan="5">
                                                                <div
                                                                    style="float: right; margin-right:105px; font-size: 25px; font-weight: bold;">
                                                                    Tổng tiền:
                                                                    {{ number_format($bill->total_price, 0, '', '.') }} đ
                                                                </div>
                                                            </td>

                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div><!-- .nk-block -->


                                    </div><!-- .card-inner -->
                                </div><!-- .card-content -->

                            </div><!-- .card-aside-wrap -->
                        </div><!-- .card -->
                    </div><!-- .nk-block -->
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
@endsection
@push('after-scripts')
    <script>
      
    </script>
@endpush


