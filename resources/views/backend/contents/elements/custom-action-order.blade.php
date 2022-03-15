<div class="d-flex justify-content-center">
    <a href="{{ $routeEdit }}" class="btn btn-info "><i class="fas fa-pencil-alt"></i></a>
    {{-- <a href="{{route('tours.show', [$tour->id])}}" class="btn btn-primary "><i class="fa fa-eye"></i></a> --}}
    
    <button class="btn btn-danger btn-delete-item" data-url="{{ $routeDelete }}">
        <i class="fas fa-trash-alt "></i>
    </button>
    
</div>