<div class="d-flex justify-content-center">
    <a href="{{route('product.edit', [$product->id])}}" class="btn btn-info "><i class="fas fa-pencil-alt"></i></a>
    {{-- <a href="{{route('tours.show', [$tour->id])}}" class="btn btn-primary "><i class="fa fa-eye"></i></a> --}}
    <button type="button" data-toggle="modal"
        data-target="#modalViewBill" class="btn btn-secondary btn-view-detail"             
            data-object='{{ $product->billProductsDetail }}'>
        <i class="fas fa-eye"></i>
    </button>

    <button class="btn btn-danger btn-delete-item" data-url="{{ route('product.delete', ['id' => $product->id]) }}">
        <i class="fas fa-trash-alt "></i>
    </button>
    
</div>