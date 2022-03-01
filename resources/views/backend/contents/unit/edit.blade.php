@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">

                    <div class="nk-block">

                    </div><!-- .nk-block -->

                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h2 class="nk-block-title">Sửa đơn vị</h2>
                            <div class="nk-block-des">
                                <p>Sửa thông tin đơn vị.</p>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <form action="{{ route('unit.update', $unit->id) }}" method="POST" enctype="multipart/form-data">
                            
                            {{ csrf_field() }}
                            <div class="row g-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Tên đơn vị</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="name" value="{{ $unit->name }}" class="form-control" id="product-title">
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Thông tin đơn vị</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="description" value="{{ $unit->description }}" class="form-control" id="product-title">
                                        </div>
                                    </div>
                                </div>   
                                <div class="col-12">
                                    <button class="btn btn-primary"><i class="fas fa-plus"></i><span>Edit
                                            Unit</span></button>
                                </div>
                            </div>
                        </form>
                    </div><!-- .nk-block -->

                </div>
            </div>
        </div>
    </div>
@endsection
