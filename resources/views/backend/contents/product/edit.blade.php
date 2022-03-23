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
                            <h2 class="nk-block-title">Sửa sản phẩm</h2>
                            <div class="nk-block-des">
                                <p>Sửa thông tin sản phẩm.</p>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <form action="{{ route('product.update', $product->id) }}" method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}
                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Tên sản phẩm</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="name" class="form-control" id="product-title" value="{{ $product->name }}">
                                        </div>
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Đường dẫn sản phẩm</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="slug" class="form-control" id="product-slug" value="{{ $product->slug }}" readonly>
                                        </div>
                                        @error('slug')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-mb-6">
                                    <div class="form-group">
                                        <label class="form-label" for="regular-price">Giá nhập</label>
                                        <div class="form-control-wrap">
                                            
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">VNĐ</span>
                                                </div>
                                                <input type="text" name="entry_price"
                                                class="form-control" id="regular-price" value="{{ $product->entry_price }}">                                                <div class="input-group-append">
                                                  <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        @error('entry_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="col-mb-6">
                                    <div class="form-group">
                                        <label class="form-label" for="stock">Giá bán lẻ</label>
                                        <div class="form-control-wrap">
                                            <div class="input-group mb-3">
                                                <div class="input-group-prepend">
                                                  <span class="input-group-text">VNĐ</span>
                                                </div>
                                                <input type="text" name="retail_price" value="{{ $product->retail_price }}" class="form-control" id="stock">
                                                <div class="input-group-append">
                                                  <span class="input-group-text">.00</span>
                                                </div>
                                            </div>
                                        </div>
                                        @error('retail_price')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>

                            <div class="row mb-3">
                        
                                <div class="col-mb-6">
                                    <label class="form-label" for="category">Danh mục sản phẩm</label>
                                    <select class="form-select" id="product_category" name="category_id">
                                        <option selected>Chọn danh mục</option>
                                        @foreach ($categories as $category)
                                            <option value="{{ $category->id }}" {{ $category->id == $product->product_category->id ? 'selected' : '' }}>{{ $category->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                                
                                <div class="col-mb-6">
                                    <label class="form-label" for="category">Đơn vị</label>
                                    <select class="form-select" id="unit" name="unit_id">
                                        <option selected>Chọn đơn vị</option>
                                        @foreach ($units as $unit)
                                            <option value="{{ $unit->id }}" {{ $unit->id == $product->unit->id ? 'selected' : '' }}>{{ $unit->name }}</option>
                                        @endforeach

                                    </select>
                                </div>
                            </div>

                            <div class="row mb-3">
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tags">Khuyến mãi</label>
                                        <select class="form-select" id="promotions" name="promotion_id">
                                            <option value="0" selected>Chọn chương trình khuyến mãi</option>
                                            @foreach ($promotions as $promotion)
                                                <option value="{{ $promotion->id }}" {{ $promotion->id == $product->promotion->id ? 'selected' : '' }}>{{ $promotion->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="tags">Nhà cung cấp</label>
                                        <select class="form-select" id="supplier" name="supplier_id">
                                            <option value="0" selected>Chọn nhà cung cấp</option>
                                            @foreach ($suppliers as $supplier)
                                                <option value="{{ $supplier->id }}" {{ $supplier->id == $product->supplier->id ? 'selected' : '' }}>{{ $supplier->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-mb-6">
                                    <label class="form-label" for="tags">Trạng thái sản phẩm</label>
                                    <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="selling" {{ $product->status == 1 ? 'checked' : '' }} value="1">
                                        <label class="form-check-label" for="selling">
                                          Đang bán
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="pause-selling"  {{ $product->status == 2 ? 'checked' : '' }} value="2">
                                        <label class="form-check-label" for="pause-selling">
                                            Tạm dừng bán
                                        </label>
                                      </div>
                                      <div class="form-check">
                                        <input class="form-check-input" type="radio" name="status" id="out-of-stock"  {{ $product->status == 3 ? 'checked' : '' }} value="3">
                                        <label class="form-check-label" for="out-of-stock">
                                           Hết hàng
                                        </label>
                                      </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-mb-6">
                                    <div class="form-group">
                                        <label class="form-label mr-3">Thumbnail</label>

                                        <input type="file" class="mt-3" id="inputGroupFile01"
                                            accept="image/png, image/gif, image/jpeg" name="image">
                                    </div>
                                    @error('image')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-mb-6">
                                    <div class="thumbnail-product w-75">
                                        <img src="{{ $product->image }}" alt="" class="img-fluid">
                                    </div>
                                </div>
                            </div>             
                            <div class="row mb-3">
                          
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="tags">Thông tin chi tiết</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control" name="description"
                                                placeholder="Nhập thông tin chi tiết sản phẩm" id="detailarea"
                                                style="height: 100px">{{ $product->description }}</textarea>
                                        </div>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>

                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button class="btn btn-primary"><i class="fas fa-plus"></i><span>Cập nhật</span></button>
                                </div>
                            </div>
                        </form>

                      
                    </div><!-- .nk-block -->

                </div>
            </div>
        </div>
    </div>
    <script>
        
    </script>
@endsection
@push('after-scripts')
    <script>
        // In your Javascript (external .js resource or <script> tag)
         $(document).ready(function() {
            $('.form-select').select2();
        });

        $("#product-title").keyup(function() {
            var text = $(this).val();
            let slug = convertToSlug(text)     
            $("#product-slug").val(slug);  
        });

        function convertToSlug(Text) {
            const a = 'àáäâãåăæąçćčđďèéěėëêęğǵḧìíïîįłḿǹńňñòóöôœøṕŕřßşśšșťțùúüûǘůűūųẃẍÿýźžż·/_,:;';
            const b = 'aaaaaaaaacccddeeeeeeegghiiiiilmnnnnooooooprrsssssttuuuuuuuuuwxyyzzz------';
            const p = new RegExp(a.split('').join('|'), 'g');
             return Text.toLowerCase()
                    .replace(/ /g, '-')
                    .replace(/á|à|ả|ạ|ã|ă|ắ|ằ|ẳ|ẵ|ặ|â|ấ|ầ|ẩ|ẫ|ậ/gi, 'a')
                    .replace(/é|è|ẻ|ẽ|ẹ|ê|ế|ề|ể|ễ|ệ/gi, 'e')
                    .replace(/i|í|ì|ỉ|ĩ|ị/gi, 'i')
                    .replace(/ó|ò|ỏ|õ|ọ|ô|ố|ồ|ổ|ỗ|ộ|ơ|ớ|ờ|ở|ỡ|ợ/gi, 'o')
                    .replace(/ú|ù|ủ|ũ|ụ|ư|ứ|ừ|ử|ữ|ự/gi, 'u')
                    .replace(/ý|ỳ|ỷ|ỹ|ỵ/gi, 'y')
                    .replace(/đ/gi, 'd')
                    .replace(/\s+/g, '-') 
                    .replace(p, c => b.charAt(a.indexOf(c)))
                    .replace(/&/g, '-and-')
                    .replace(/[^\w\-]+/g, '')
                    .replace(/\-\-+/g, '-')
                    .replace(/^-+/, '')
                    .replace(/-+$/, '');
                    // .replace(/[^\w-]+/g, '');
        }
    </script>
@endpush