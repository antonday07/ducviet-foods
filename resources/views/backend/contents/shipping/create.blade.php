@extends('backend.layouts.main')

@section('content')
<div class="create-employ " style="margin-top: 100px;">
    <div class="container">
        <div class="nk-block">
            <a href="{{ route('employee.index')}}" style="color: black;">
             
                <span><i class="fas fa-chevron-left"></i></span>
                <span>Back</span>
            </a>
        </div>
        <div class="nk-block-head">
            <div class="nk-block-head-content">
                <h5 class="nk-block-title">Thêm đơn vị vận chuyển</h5>
                <div class="nk-block-des">
                    <p>Thêm đơn vị vận chuyển.</p>
                </div>
            </div>
        </div><!-- .nk-block-head -->
    <form action="{{ route('shipping.store')}}" method="post"> 
        {{csrf_field()}}
        <div class="nk-block">
            <div class="row g-3">
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title" >Tên đơn vị</label>
                       
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="product-title" name="name" value="{{ old('name') }}">
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
                            <input type="text" class="form-control" id="product-title" name="email"  value="{{ old('email') }}">
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
                            <input type="text" class="form-control" id="product-title" name="address" value="{{ old('address') }}">
                        </div>
                        @error('address')
                            <span class="text-danger">{{$message}}</span>
                        @enderror
                    </div>
                </div>
                <div class="col-6">
                    <div class="form-group">
                        <label class="form-label" for="product-title">Password</label>
                      
                        <div class="form-control-wrap">
                            <input type="password" class="form-control" id="product-title" name="password">
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
                </div>
            
                <div class="col-12">
                    <button class="btn btn-primary" type="submit"><i class="fas fa-plus"></i><span>Thêm mới</span></button>
                </div>
            </div>
        </form>
        </div><!-- .nk-block -->
    </div>
</div>

@endsection