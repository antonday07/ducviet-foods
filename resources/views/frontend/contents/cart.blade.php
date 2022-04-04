@extends('frontend.layouts.main')
@section('content')
    <div class="cart-area pt-100 pb-100">
    <div class="container">
        <div class="row">
            <div class="col-12">
                <form action="#">
                    @if ( count((array) session('cart')) === 0)
                        <h4>Không có sản phẩm nào trong giỏ hàng</h4>                        
                            <a href="{{ route('product') }}">Tiếp tục mua sắm</a>                        
                    @else
                        <div class="cart-table-content">
                            <div class="table-content">
                                <table id="cart-table">
                                    <thead>
                                        <tr>
                                            <th class="width-thumbnail">Hình ảnh </th>
                                            <th class="width-name">Tên sản phẩm</th>
                                            
                                            <th class="width-price">Đơn giá</th>
                                            <th class="width-quantity">Số lượng</th>
                                            
                                            <th class="width-subtotal">Thành tiền</th>
                                            <th class="width-remove"></th>
                                        </tr>
                                    </thead>
                                    <tbody>    
                                        @php
                                            $t = 0;
                                            $total = 0;                                         
                                        @endphp
                                        @if(session('cart'))
                                            @foreach ((array) session('cart') as $id => $product)
                                            @php
                                                ++$t;
                                                $total += $product['price'] * $product['quantity'];
                                            @endphp
                                                <tr id="item-{{ $id }}">                                      
                                                    <td class="product-thumbnail">
                                                        <a href="{{route('detail', $id)}}"><img src="{{ $product['photo'] }}" alt=""></a>
                                                    </td>
                                                    <td class="product-name">
                                                        <h5><a href="{{route('detail', $id)}}" target="_blank"> {{ $product['name'] }}  </a></h5>
                                                    </td>
                            
                                                    <td class="product-cart-price"><span class="amount">{{ number_format($product['price']  , 0,'', '.') }} đ</span></td>
                                                        
                                                    <td class="cart-quality">
                                                        <div class="product-quality">   
                                                            @csrf                                                            
                                                            <input type="number" class="qty" id="{{ $id }}" data-url="{{ route('changeqty') }}" data-id="{{ $id }}" min="1" max="10" value="{{ $product['quantity'] }}">
                                                        </div>

                                                    </td>
                                                    {{-- <td class="product-total"><span class="{{ $x->rowId }}">{{ number_format($x->price - ($x->price * $x->options->discount)/100 , 0,'', '.') }} đ</span></td> --}}
                                                    <td class="product-total"><span class="subtotal-{{  $id }}">{{ number_format($product['price'] * $product['quantity'], 0,'', '.') }} đ</span></td>
                                                
                                                    <td class="product-remove"><span data-id="{{ $id }}" data-url_delete="{{ route('removefromcart') }}" id="{{ $id }}" class="remove-cart" ><i class=" ti-trash "></i></span></td>                                                    
                                                </tr>                                            
                                            @endforeach
                                        @endif
                                            
                                            <td colspan="5">
                                                <div class="grand-total" style="float: right;">
                                                    <h4>Tổng <span class="total">{{ number_format($total  , 0,'', '.') }} đ</span></h4>
                                                </div>
                                            </td>
                                        </tr>                                         
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-lg-12">
                                <div class="cart-shiping-update-wrapper">
                                    <div class="cart-shiping-update btn-hover">
                                        <a href="{{ route('product') }}">Tiếp tục mua sắm</a>
                                    </div>
                                    
                                    <div class="cart-clear-wrap">
                                        <div class="cart-clear btn-hover" >
                                            <a href="#" class="checkout"  onclick="checkout({{ count(session('cart')) }})">Thanh toán</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                </form>
            </div>
        </div>
        <div class="row">
            
            
        </div>
    </div>
</div>

@endsection

