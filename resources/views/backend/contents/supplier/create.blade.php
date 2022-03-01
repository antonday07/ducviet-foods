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
                            <h2 class="nk-block-title">Thêm mới nhà cung cấp </h2>
                            <div class="nk-block-des">
                                <p>Thêm thông tin nhà cung cấp.</p>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <form action="{{ route('supplier.store') }}" method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Tên nhà cung cấp</label>
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
                                        <label class="form-label" for="product-title">Email</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="email" class="form-control" id="product-description" value="{{ old('email') }}">
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
                                        <label class="form-label" for="regular-price">Số điện thoại</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="phone" class="form-control" id="product-description" value="{{ old('phone') }}">
                                        </div>
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                           
                                <div class="col-mb-6">
                                    <div class="form-group">
                                        <label class="form-label" for="address">Địa chỉ</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="address" class="form-control" id="product-description" value="{{ old('address') }}">
                                        </div>
                                        @error('address')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button class="btn btn-primary"><i class="fas fa-plus"></i><span>Add
                                            New</span></button>
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
                $('.box-price').addClass('d-none');
                $('.box-percent').removeClass('d-none');
            } else {
                $('.box-percent').addClass('d-none');
                $('.box-price').removeClass('d-none');
            }
        })
    </script>
@endpush
