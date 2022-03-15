<div class="col-lg-3 col-md-4 col-sm-6 col-12">
        <div class="product-wrap mb-35" data-aos="fade-up" data-aos-delay="200">
            <div class="product-img img-zoom mb-25">
                <a href="{{route('detail', $product->id)}}">
                    <img src="{{ $product->image  }}" alt="">
                </a>
                <div class="product-badge badge-top badge-right badge-pink">
                    @if (!empty($product->promotion))
                        @if ($product->promotion->type == 1)
                            <span>- {{ number_format($product->promotion->price,0,'', '.') }} vnđ</span>
                        @else
                            <span>-{{ $product->promotion->price }} %</span>
                        @endif
                    @endif
                </div>
                
                <div class="product-action-2-wrap">
                    @csrf
                    <a href="#" onclick="return false;" data-url_addcart="{{ route('addtocart') }}" id="{{ $product->id }}" class="product-action-btn-2 add-cart" title="Add To Cart" ><i class="pe-7s-cart"></i> Add to cart</a>

                </div>
            </div>
            <div class="product-content">
                <h3><a href="{{route('detail', $product->id)}}">{{ $product->name }}</a></h3>
                <div class="product-price"> 
                    @if (empty($product->promotion))
                        <span class="old-price-current"> {{ number_format($product->retail_price, 0, '', '.') }} vnđ </span>
                    @else
                        <span class="old-price"> {{ number_format($product->retail_price, 0, '', '.') }} vnđ </span>
                        <span class="new-price"> {{ number_format($product->price_discount, 0, '', '.') }} vnđ </span>
                    @endif                
                </div>
            </div>
        </div>
</div>
