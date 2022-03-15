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
                            <h2 class="nk-block-title">Thêm mới đơn nhập hàng</h2>
                            <div class="nk-block-des">
                                <p>Thêm thông tin đơn nhập hàng.</p>
                            </div>
                        </div>
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <form action="{{ route('bill.import.store') }}" method="POST" enctype="multipart/form-data">

                            {{ csrf_field() }}

                            <div class="row mb-3">                                            
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form-label" for="product-title">Nội dung nhập hàng</label>
                                        <div class="form-control-wrap">
                                            <input type="text" name="description" class="form-control" id="product-title" value="{{ old('description') }}">
                                        </div>
                                        @error('description')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-group">
                                        <label class="form-label" for="tags">Ghi chú</label>
                                        <div class="form-control-wrap">
                                            <textarea class="form-control" name="note"
                                                placeholder="Nhập thông tin chi tiết sản phẩm" id="detailarea-1"
                                                style="height: 100px">{{ old('note') }}</textarea>
                                        </div>
                                        @error('note')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                </div>
                                            
                            </div>
                            <div id="list_product_group">
                                <div class="box-product-group">
                                    <h5>Thêm sản phẩm</h5>

                                    <div class="row mb-3">
                                
                                        <div class="col-mb-3">
                                            <label class="form-label" for="category">Sản phẩm</label>
                                            <select class="form-select select2 form-custom-select list-product-item" id="product_item" name="product[0][product_id]">
                                                <option selected>Chọn sản phẩm</option>
                                                @foreach ($products as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->entry_price }}">{{ $item->name }}</option>
                                                @endforeach
        
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-label" for="tags">Nhà cung cấp</label>
                                                <select class="form-select  select2 form-custom-select" id="supplier" name="product[0][supplier_id]">
                                                    <option value="0" selected>Chọn nhà cung cấp</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>    
                                        <div class="col-mb-3 box-price-group">
                                            <label class="form-label" for="stock">Chọn giá bán</label>
                                            <div class="d-flex">
                                                <div class="form-check mr-3">
                                                    <input class="form-check-input" type="radio" name="radio_price" id="price-default" checked>
                                                    <label class="form-check-label" for="price-default">
                                                      Giá nhập
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="radio_price" id="price-other">
                                                    <label class="form-check-label" for="price-other">
                                                      Giá khác
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="group-price d-none">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">VNĐ</span>
                                                            </div>
                                                            <input type="number" name="retail_price" value="{{ old('retail_price') }}" class="form-control input-custom-price">
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
                                        <div class="col-sm-2 box-quantity-group">
                                            <div class="form-group">
                                                <input type="hidden" value="" class="price-product">
                                               
                                                <label class="form-label" for="product-title">Số lượng</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="product[0][amount]" class="form-control input-quantity" value="{{ old('amount') }}">
                                                </div>
                                                @error('amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="col-sm-1">
                                         
                                        </div>            
                                    </div>    
                                  
                                    <div class="row mb-3 box-total-price">
                                        <div class="col-mb-4">
                                            <div class="form-group group-date">
                                                <label class="form-label" for="date_from">Ngày bắt đầu</label>
                                                <input type="text" class="form-control date form-input ed-form-input date_from" name="product[0][entry_date]" placeholder="Ngày bắt đầu" value="{{ old('entry_date') }}">
                                                <div class="icon-calendar" id="icon_date_left">
                                                    <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                                </div>
        
                                            </div>
                                            @error('entry_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                           
                                        <div class="col-mb-4">
                                            <div class="form-group group-date">
                                                <label class="form-label" for="date_expiry">Ngày kết thúc</label>
                                                <input type="text" class="form-control date form-input ed-form-input date_expiry" name="product[0][expiry_date]" placeholder="Ngày kết thúc" value="{{ old('expiry_date') }}">
                                                <div class="icon-calendar" id="icon_date_left">
                                                    <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                                </div>
                                            </div>
                                            @error('expiry_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-mb-4">                                
                                            <div class="form-group">
                                                <label class="form-label" for="product-title">Tổng tiền</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="product[0][price]" class="form-control input-total-price" id="total_price" value="{{ old('total_price') }}" readonly>
                                                </div>
                                                @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>                            
                                        </div>
                                    </div>
                                </div>
                            </div>

                                      
                         
                            <div class="row mb-3">
                                <div class="col-12">
                                    <button type="button" id="add_product_group" class="btn btn-info"><i class="fas fa-plus"></i><span>Thêm sản phẩm</span></button>
                                    <button class="btn btn-primary"><i class="fas fa-plus"></i><span>Lưu thông tin</span></button>
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
    <script>
        showCustomInputPrice();
        updateQuantity();
        updatePriceForTotalPrice();
        setPriceForProduct();
        innitialDate();
    
        let index = 1;
        $('#add_product_group').on('click', function() {            
            let itemProduct = `<div class="box-product-group">
                                    <h5>Thêm sản phẩm</h5>
                                    <div class="row mb-3">
                                
                                        <div class="col-mb-3">
                                            <label class="form-label" for="category">Sản phẩm</label>
                                            <select class="form-select select2 form-custom-select list-product-item" id="product_item_${index}" name="product[${index}][product_id]">
                                                <option selected>Chọn sản phẩm</option>
                                                @foreach ($products as $item)
                                                    <option value="{{ $item->id }}" data-price="{{ $item->entry_price }}">{{ $item->name }}</option>
                                                @endforeach
        
                                            </select>
                                        </div>
                                        
                                        <div class="col-sm-3">
                                            <div class="form-group">
                                                <label class="form-label" for="tags">Nhà cung cấp</label>
                                                <select class="form-select select2 form-custom-select" id="supplier_${index}" name="product[${index}][supplier_id]">
                                                    <option value="0" selected>Chọn nhà cung cấp</option>
                                                    @foreach ($suppliers as $supplier)
                                                        <option value="{{ $supplier->id }}">{{ $supplier->name }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>    
                                        <div class="col-mb-3 box-price-group">
                                            <label class="form-label" for="stock">Chọn giá bán</label>
                                            <div class="d-flex">
                                                <div class="form-check mr-3">
                                                    <input class="form-check-input" type="radio" name="radio_price_${index}" id="price-default-${index}" checked>
                                                    <label class="form-check-label" for="price-default-${index}">
                                                      Giá nhập
                                                    </label>
                                                  </div>
                                                  <div class="form-check">
                                                    <input class="form-check-input" type="radio" name="radio_price_${index}" id="price-other-${index}">
                                                    <label class="form-check-label" for="price-other-${index}">
                                                      Giá khác
                                                    </label>
                                                </div>
                                            </div>
                                            <div class="group-price d-none">
                                                <div class="form-group">
                                                    <div class="form-control-wrap">
                                                        <div class="input-group mb-3">
                                                            <div class="input-group-prepend">
                                                              <span class="input-group-text">VNĐ</span>
                                                            </div>
                                                            <input type="number" name="retail_price" value="{{ old('retail_price') }}" class="form-control input-custom-price">
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
                                        <div class="col-sm-2 box-quantity-group">
                                            <div class="form-group">
                                                <input type="hidden" value="" class="price-product">
                                               
                                                <label class="form-label" for="product-title">Số lượng</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="product[${index}][amount]" class="form-control input-quantity" value="{{ old('amount') }}">
                                                </div>
                                                @error('amount')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>
                                        </div> 
                                        <div class="col-sm-1">
                                            <div class="group-action">                                        
                                                <button class="btn btn-danger btn-remove-item">
                                                    <i class="fas fa-trash-alt "></i>
                                                </button>                                             
                                            </div>
                                        </div>           
                                    </div>    
                                  
                                    <div class="row mb-3 box-total-price">
                                        <div class="col-mb-4">
                                            <div class="form-group group-date">
                                                <label class="form-label" for="date_from">Ngày bắt đầu</label>
                                                <input type="text" class="form-control date form-input ed-form-input date_from" name="product[${index}][entry_date]" placeholder="Ngày bắt đầu" value="{{ old('entry_date') }}">
                                                <div class="icon-calendar" id="icon_date_left">
                                                    <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                                </div>
        
                                            </div>
                                            @error('entry_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                           
                                        <div class="col-mb-4">
                                            <div class="form-group group-date">
                                                <label class="form-label" for="date_expiry">Ngày kết thúc</label>
                                                <input type="text" class="form-control date form-input ed-form-input date_expiry" name="product[${index}][expiry_date]" placeholder="Ngày kết thúc" value="{{ old('expiry_date') }}">
                                                <div class="icon-calendar" id="icon_date_left">
                                                    <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                                </div>
                                            </div>
                                            @error('expiry_date')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </div>
                                        <div class="col-mb-4">                                
                                            <div class="form-group">
                                                <label class="form-label" for="product-title">Tổng tiền</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="product[${index}][price]" class="form-control input-total-price" id="total_price-${index}" value="{{ old('total_price') }}" readonly>
                                                </div>
                                                @error('price')
                                                    <span class="text-danger">{{ $message }}</span>
                                                @enderror
                                            </div>                            
                                        </div>
                                    </div>
                                </div>`
        
            $('#list_product_group').append(itemProduct);
            selectRefresh();
            innitialDate();
            // showCustomInputPrice();
            // updateQuantity();
            // updatePriceForTotalPrice();
            // setPriceForProduct();
            index++;
        })
        
        function selectRefresh() {
            $(".form-custom-select").select2({
                placeholder: "",
                allowClear: true,
                width: '100%'
            });

        }
        function updateQuantity() {
            $('body').on('change', '.input-quantity', function() {
                let totalPriceInput = $(this).parent().parent().parent().parent().siblings('.box-total-price').find('.input-total-price');              
                let qty = $(this).val();    
                let priceProduct = $(this).parent().siblings('.price-product').val();   
                let priceRetail = $(this).parent().parent().parent().siblings('.box-price-group').find('.input-custom-price').val();                    
                if(priceRetail == '') {
                    totalPriceInput.val(qty * priceProduct)
                } else {
                    totalPriceInput.val(qty * priceRetail)
                }
            })
        }
        function updatePriceForTotalPrice() {          
            $('body').on('change', '.input-custom-price', function() {
                let qty = $(this).parent().parent().parent().parent().parent().siblings('.box-quantity-group').find('.input-quantity').val();
                let retailPrice = $(this).val();         
                $(this).parent().parent().parent().parent().parent().parent().siblings('.box-total-price').find('.input-total-price').val(qty * retailPrice)
            });
        };

        function setPriceForProduct() {

            $('body').on('change', '.list-product-item', function(e) {
                let price = $(this).find(':selected').data('price');      
                console.log(price);       
                $(this).parent().siblings('.box-quantity-group').find('.price-product').val(price)
            });

        }

        function showCustomInputPrice() {
            $('body').on('change', 'input[type="radio"]', function(e) {    
                let currrentRadio = e.target.id;
                if(currrentRadio.includes('price-other')) {
                    $(this).parent().parent().siblings('.group-price').removeClass('d-none');
                } else {
                    $(this).parent().parent().siblings('.group-price').addClass('d-none');
                }        
            });
        }
        $('body').on('click', '.btn-remove-item', function(){
            $(this).parent().parent().parent().parent().remove();        
        })
        
        function innitialDate() {
            var date = new Date();
                date.setDate(date.getDate());
            $('.date_from').datepicker({
                startDate: date,
                format: 'yyyy-mm-dd',
            }).on('changeDate', function (selected) {
                var minDate = new Date(selected.date.valueOf());
                $('.date_expiry').datepicker('setStartDate', minDate);
            });
            $(".date_expiry").datepicker({
                format: 'yyyy-mm-dd',
                startDate: date,
            }).on('changeDate', function (selected) {
                var maxDate = new Date(selected.date.valueOf());
                $('.date_from').datepicker('setEndDate', maxDate);
            });

        }
    </script>
@endpush