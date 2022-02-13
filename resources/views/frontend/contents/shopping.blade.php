@extends('frontend.layouts.main')
@section('content')
<style>
    span.old-price-current {
        color: black;
    }
    .nutdanhmuc {
        background-color: #d63031;
        border: none;
    }
    .nutdanhmuc:hover {
        background-color: #e17055;
    }
</style>

<div class="shop-area pt-100 pb-100">
    <div class="container">
        <div class="row flex-row-reverse">
            <div class="col-12">
                <div class="shop-topbar-wrapper mb-40">
                    <div class="shop-topbar-right" data-aos="fade-up" data-aos-delay="400">
                        <div class="shop-sorting-area">
                            <select class="nice-select nice-select-style-1 category">                           
                                <option value="all">Tất cả sản phẩm</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>                                  
                                @endforeach                               
                            </select>
                        </div>
                        
                    </div>
                    {{-- <div class="shop-topbar-left">
                        <div class="search-product">
                            <input type="text" name="search-pd" id="search-pd" class="form-control" placeholder="Tìm kiếm sản phẩm">
                        </div>
                    </div> --}}
                </div>
                <div class="shop-bottom-area">
                    <div class="tab-content jump">
                        <div id="shop-1" class="tab-pane active">
                            <div class="row render-product">
                                @foreach ($products as $product)
                                    @livewire('list-products', ['product' => $product])
                                @endforeach      
                                <div class="d-flex justify-content-center">
                                    {{ $products->links() }}        
                                </div>
                            </div>                        
                        </div>                       
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
