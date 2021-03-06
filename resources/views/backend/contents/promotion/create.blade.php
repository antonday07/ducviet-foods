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
                            <h2 class="nk-block-title">Thêm mới khuyến mãi</h2>
                            <div class="nk-block-des">
                                <p>Thêm thông tin khuyến mãi.</p>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <form action="{{ route('promotion.store') }}" method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Tên khuyến mãi</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="name" class="form-control" id="product-title" value="{{ old('name') }}">
                                        </div>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Thông tin khuyến mãi</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="description" class="form-control" id="product-description" value="{{ old('description') }}">
                                        </div>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-mb-6">
                                    <div class="form-group">
                                        <label class="form-label" for="regular-price">Giảm giá</label>
                                        <div class="form-control-wrap box-price">
                                            <div class="input-group mb-3">
                                                <input type="text" name="price"
                                                class="form-control" id="regular-price" value="{{ old('price') }}">                                                <div class="input-group-append">
                                                  <span class="input-group-text span-price">VNĐ</span>
                                                  <span class="input-group-text span-percent d-none">%</span>
                                                </div>
                                            </div>
                                        </div>
                                        {{-- <div class="form-control-wrap box-percent d-none">
                                            <div class="input-group mb-3">
                                                <input type="text" name="price" value="{{ old('price') }}" class="form-control" id="stock">
                                                <div class="input-group-append">
                                                  <span class="input-group-text">%</span>
                                                </div>
                                            </div>
                                        </div> --}}
                                        @error('price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-mb-6">
                                    <div class="col-mb-6">
                                        <label class="form-label" for="category">Loại khuyến mãi</label>
                                        <select class="form-select" id="type_promotion" name="type">
                                            <option selected>Chọn loại</option>
                                            <option value="1" >Giá tiền</option>
                                            <option value="2" >Phần trăm</option>
                                        </select>
                                        @error('type')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-mb-6">
                                    <div class="form-group group-date">
                                        <label class="form-label" for="date_from">Ngày bắt đầu</label>
                                        <input type="text" class="form-control date form-input ed-form-input" id="date_from" name="date_from" placeholder="Ngày bắt đầu" value="">
                                        <div class="icon-calendar" id="icon_date_left">
                                            <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                        </div>

                                    </div>
                                </div>
                                   
                                <div class="col-mb-6">
                                    <div class="form-group group-date">
                                        <label class="form-label" for="date_expiry">Ngày kết thúc</label>
                                        <input type="text" class="form-control date form-input ed-form-input" id="date_expiry" name="date_expiry" placeholder="Ngày kết thúc" value="">
                                        <div class="icon-calendar" id="icon_date_left">
                                            <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                                
                            </div>

                            <div class="row mb-3">
                                <div class="col-12">
                                    <button class="btn btn-primary"><i class="fas fa-plus"></i><span>Thêm mới </span></button>
                                </div>
                            </div>
                        </form>
                      
                    </div><!-- .nk-block -->

                </div>
            </div>
        </div>
    </div>
@endsection
@push('after-scripts')
    <script src="{{ asset('backend/js/moment.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.47/js/bootstrap-datetimepicker.min.js"></script>

    <script>
      
        var date = new Date();
        date.setDate(date.getDate());
        $('#date_from').datepicker({
            startDate: date,
            format: 'yyyy-mm-dd',
        }).on('changeDate', function (selected) {
            var minDate = new Date(selected.date.valueOf());
            $('#date_expiry').datepicker('setStartDate', minDate);
        });
        $("#date_expiry").datepicker({
            format: 'yyyy-mm-dd',
            startDate: date,
        }).on('changeDate', function (selected) {
            var maxDate = new Date(selected.date.valueOf());
            $('#date_from').datepicker('setEndDate', maxDate);
        });

        $('#type_promotion').on('change', function() {
            let value = $(this).val();
            if(value == 2) {
                $('.span-price').addClass('d-none');
                $('.span-percent').removeClass('d-none');
            } else {
                $('.span-percent').addClass('d-none');
                $('.span-price').removeClass('d-none');
            }
        })
    </script>
@endpush
