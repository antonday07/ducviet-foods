@extends('backend.layouts.main')

@section('content')
<div class="create-employ " style="margin-top: 100px;">
    <div class="container">
        <div class="nk-block">
            <a href="{{ route('shipping.index')}}" style="color: black;">
             
                <span><i class="fas fa-chevron-left"></i></span>
                <span>Back</span>
            </a>
        </div>
        <div class="nk-block-head d-flex justify-content-between">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Sửa đơn vị vận chuyển</h5>
                <div class="nk-block-des">
                    <p>Sửa thông tin đơn vị.</p>
                </div>
            </div>
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Tạo mã token</h5>
                <p>Với mã token được tạo, bạn có thể tương tác với api bên thứ 3</p>
                <div class="form-control-wrap box-create-token {{ !empty($shipping->token) ? $shipping->token : 'd-none' }} mb-3">
                    <input type="text" readonly class="form-control" id="token-field" value="{{ !empty($shipping->token) ? $shipping->token : '' }}">
                </div>
                <div class="nk-block-des">
                    <button class="btn btn-primary btn-generate-token" data-id="{{ $shipping->id }}" type="button"><i class="fas fa-plus"></i><span>Tạo mã</span></button>
                </div>
            </div>
        </div><!-- .nk-block-head -->
    <form action="{{ route('shipping.update', ['id' => $shipping->id]) }}" method="post"> 
        {{csrf_field()}}
        <div class="nk-block">
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title" >Tên đơn vị</label>
                       
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="product-title" name="name" value="{{ $shipping->name }}">
                        </div>
                        @error('name')
                            <span class="text-danger">{{$message}}</span>   
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title" >Email đơn vị</label>
                       
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="product-title" name="email"  value="{{ $shipping->email }}">
                        </div>
                        @error('email')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>        
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title" >Địa chỉ</label>
                       
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="product-title" name="address" value="{{ $shipping->address }}">
                        </div>
                        @error('address')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                {{-- <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title">Password</label>
                      
                        <div class="form-control-wrap">
                            <input type="password" class="form-control" id="product-title" name="password" value="">
                        </div>
                        @error('password')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title">RePassword</label>
                        <div class="form-control-wrap">
                            <input type="password" class="form-control" id="product-title">
                        </div>
                    </div>
                </div> --}}
            
                <div class="col-12">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i><span>Cập nhật</span></button>
                </div>
            </div>
        </form>
        </div><!-- .nk-block -->
    </div>
</div>

@endsection

@push('after-scripts')
    <script>

        
        $('.btn-generate-token').on('click', function() {
            var id = $(this).data("id");
            var csrf_token =  $('meta[name="csrf-token"]').attr('content');

            $.ajax({
                type: 'POST',
                url: '{{ route('create.token') }}',
                data: {
                    id: id,
                    _token: csrf_token
                },
                success: function(results) {
                    if(results.status === 'success') {
                        swal.fire("Thành công", results.message, "success");
                        $('#token-field').val(results.token);
                        $('.box-create-token').removeClass('d-none');
                    } else {
                        swal.fire("Có lỗi xảy ra!", results.message, "error");
                    }
                }
            });
        })
    </script>
@endpush