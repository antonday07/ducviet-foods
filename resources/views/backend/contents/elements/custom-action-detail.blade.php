<div class="d-flex justify-content-center">
    <button type="button" data-toggle="modal"
        data-target="#modalViewBill" class="btn btn-info btn-view-detail" 
            data-code-bill='{{ $item->code_bill }}'
            data-employee='{{ $item->employee->name }}'
            data-note='{{ $item->note }}'
            data-date='{{ $item->date_import }}'
            data-object='{{ $item->productBills }}'>
        <i class="fas fa-eye"></i>
    </button>
    {{-- <a href="{{route('tours.show', [$tour->id])}}" class="btn btn-primary "><i class="fa fa-eye"></i></a> --}}
    <button class="btn btn-danger btn-delete-item" data-url="{{ $routeDelete }}">
        <i class="fas fa-trash-alt "></i>
    </button>
    
</div>
