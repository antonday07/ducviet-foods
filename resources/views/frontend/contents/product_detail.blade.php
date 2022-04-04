@extends('frontend.layouts.main')
@section('content')
    <div class="product-details-area pb-100 pt-100">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <div class="product-details-img-wrap product-details-vertical-wrap" data-aos="fade-up"
                        data-aos-delay="200">


                        <div class="swiper-container product-details-big-img-slider-1 pd-big-img-style">
                            <div class="swiper-wrapper">
                                <div class="swiper-slide">
                                    <div class="easyzoom-style">
                                        <div class="easyzoom easyzoom--overlay">
                                            <a href="{{ $product->image }}">
                                                <img src="{{ $product->image }}" alt="" />
                                            </a>
                                        </div>

                                    </div>
                                </div>
                                {{-- @foreach ($images as $image)

                                    <div class="swiper-slide">

                                        <div class="easyzoom-style">
                                            <div class="easyzoom easyzoom--overlay">
                                                <a href="{{ $image->path }}">
                                                    <img src="{{ $image->path }}" alt="" />
                                                </a>
                                            </div>
                                            <a class="easyzoom-pop-up img-popup" href="{{ $image->path }}">
                                                <i class="pe-7s-search"></i>
                                            </a>
                                        </div>

                                    </div>

                                @endforeach --}}
                            </div>

                        </div>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="product-details-content" data-aos="fade-up" data-aos-delay="400">
                        <h2>{{ $product->name }}</h2>
                        <div class="product-details-price">
                            @if (empty($product->promotion))
                                <span class="old-price-current"> {{ number_format($product->retail_price, 0, '', '.') }} vnđ
                                </span>
                            @else
                                <span class="old-price"> {{ number_format($product->retail_price, 0, '', '.') }} vnđ </span>
                                <span class="new-price">
                                    {{ number_format($product->price_discount, 0, '', '.') }} vnđ                            
                                </span>
                            @endif
                        </div>

                        <div class="product-details-action-wrap">
                            
                            <div class="single-product-cart btn-hover">
                                @csrf
                                @if ($product->is_out_of_stock == 'in')                                     
                                    <a href="#" onclick="return false;" data-url_addcart="{{ route('addtocart') }}" id="{{ $id }}" class="product-action-btn-2 add-cart" title="Thêm vào giỏ" ><i class="pe-7s-cart"></i>Thêm vào giỏ</a>
                                @else
                                    <a href="#" onclick="return false;" class="product-action-btn-2 add-cart" title="Thêm vào giỏ" ><i class="fas fa-shopping-cart"></i> Hết hàng</a>
                                @endif
                            </div>
                            {{-- <div class="single-product-wishlist">
                                <a title="Wishlist" href="wishlist.html"><i class="pe-7s-like"></i></a>
                            </div> --}}
                        </div>
                        <div class="product-details-meta">
                            <ul>
                                <li>
                                    <span class="title">Danh mục: </span> {{ $product->product_category->name }}
                                </li>
                                {{-- <li><span class="title">Lượng hàng trong kho: </span>{{ $product->qty }}</li> --}}
                                <li>
                                    Tình trạng sản phẩm:  <span class="title {{ $product->is_out_of_stock == 'in' ? 'in-order' : 'out-of-stock' }}"> {{ $product->is_out_of_stock == 'in' ? ' Còn hàng' : ' Hết hàng' }} </span> 
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="description-review-area pb-85">
        <div class="container">
            <div class="description-review-topbar nav" data-aos="fade-up" data-aos-delay="200">

                <a data-bs-toggle="tab" href="#des-details2" class="">
                    Thông tin sản phẩm
                </a>
                {{-- <a data-bs-toggle="tab" href="#des-details3" class=""> Cách sử dụng </a> --}}
            </div>
            <div class="tab-content">

                <div id="des-details2" class="tab-pane active">
                    <div class="product-description-content text-center">
                        <p data-aos="fade-up" data-aos-delay="200">
                            {!! $product->description !!}
                        </p>

                    </div>
                </div>
                {{-- <div id="des-details3" class="tab-pane">
                    <div class="product-description-content text-center">
                        <p data-aos="fade-up" data-aos-delay="200">
                            {{ $product->usage }}
                        </p>
                    </div>
                </div> --}}
            </div>
        </div>
    </div>
    <div class="related-product-area pb-95">
        <div class="container">
            <div class="section-title-2 st-border-center text-center mb-75" data-aos="fade-up" data-aos-delay="200">
                <h2>Các sản phẩm cùng danh mục</h2>
            </div>
            <div class="related-product-active swiper-container">
                <div class="swiper-wrapper">
                    @foreach ($relatedProduct as $relatedItem)
                    <div class="col-lg-3 col-md-4 col-sm-6 col-12">
                        <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
                            <div class="product-img img-zoom mb-25">
                                <a href="{{route('detail', $relatedItem->id)}}">
                                    <img src="{{ $relatedItem->image  }}" alt="">
                                </a>
                                <div class="product-badge badge-top badge-right badge-pink">
                                    @if (!empty($relatedItem->promotion))
                                        @if ($relatedItem->promotion->type == 1)
                                            <span>- {{ number_format($relatedItem->promotion->price,0,'', '.') }} vnđ</span>
                                        @else
                                            <span>-{{ $relatedItem->promotion->price }} %</span>
                                        @endif
                                    @endif
                                </div>
                                
                                <div class="product-action-2-wrap">
                                    @csrf
                                    <a href="#" onclick="return false;" data-url_addcart="{{ route('addtocart') }}" id="{{ $relatedItem->id }}" class="product-action-btn-2 add-cart" title="Add To Cart" ><i class="pe-7s-cart"></i> Add to cart</a>

                                </div>
                            </div>
                            <div class="product-content">
                                <h3><a href="product-details.html">{{ $relatedItem->name }}</a></h3>
                                <div class="product-price"> 
                                    @if (empty($relatedItem->promotion))
                                        <span class="old-price-current"> {{ number_format($relatedItem->retail_price, 0, '', '.') }} vnđ </span>
                                    @else
                                        <span class="old-price"> {{ number_format($relatedItem->retail_price, 0, '', '.') }} vnđ </span>
                                        <span class="new-price"> {{ number_format($relatedItem->price_discount, 0, '', '.') }} vnđ </span>
                                    @endif                
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach

                </div>
            </div>
        </div>
    </div>
@endsection
