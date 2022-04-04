@extends('frontend.layouts.main')
@section('content')
@include('frontend.partials.banner')   

<div class="group-product-discount mt-5">
    <div class="container">
        <h4 class="custom-heading">Sản phẩm khuyến mãi</h4>
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

<div class="group-product-category">

    @foreach ($categories as $item)
        <div class="category-item mb-3">
            <div class="container">
                <h4 class="custom-heading">{{ $item->name }}</h4>
                <div class="row render-product">        
                    @foreach ($item->products as $product)
                        @livewire('list-products', ['product' => $product])
                    @endforeach      
                    <div class="d-flex justify-content-center">
                        {{ $products->links() }}        
                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>



<div id="myModal" class="modal fade"  tabindex="-1">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <img src="https://cdn.brvn.vn/topics/400px/2018/11633_Vinmart.png" alt="">
        </div>
    </div>
</div>
<script src="{{ asset('urdan/js/vendor/jquery-3.6.0.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $("#myModal").modal('show');
    });
</script>
@endsection