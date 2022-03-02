<div class="col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
            <div class="product-img img-zoom mb-25">
                <a href="{{route('detail', $product->id)}}">
                    <img src="{{ $product->image  }}" alt="">
                </a>
                <div class="product-badge badge-top badge-right badge-pink">
                    <span>-{{  !empty($product->promotion) ? $product->promotion->price : '' }}%</span>
                </div>
                
                <div class="product-action-2-wrap">
                    @csrf
                    <a href="#" onclick="return false;" data-url_addcart="{{ route('addtocart') }}" id="{{ $product->id }}" class="product-action-btn-2 add-cart" title="Add To Cart" ><i class="pe-7s-cart"></i> Add to cart</a>

                </div>
            </div>
            <div class="product-content">
                <h3><a href="{{route('detail', $product->id)}}">{{ $product->name }}</a></h3>
                <div class="product-price">
                    @if ($product->promotion)
                        @if ($product->promotion->price == 0)
                            <span class="old-price-current"> {{ number_format($product->retail_price, 0, '', '.') }} đ </span>
                        @else
                            <span class="old-price"> {{ number_format($product->retail_price, 0, '', '.') }} đ </span>
                            <span class="new-price"> {{ number_format($product->retail_price - ($product->retail_price * $product->promotion->price) /100, 0, '', '.') }} đ </span>
                        @endif
                    @else 
                        <p>No price coupon</p>    
                    @endif
                </div>
            </div>
        </div>
</div>
