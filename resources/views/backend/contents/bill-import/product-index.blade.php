@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Danh sách sản phẩm đã nhập </h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li class="w-75">
                                            
                                                <select class="form-control" id="product_list" name="category_id">
                                                    <option value="" selected>Chọn sản phẩm</option>
                                                    @foreach ($products as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach
            
                                                </select>                                           
                                          
                                            </li>
                                            <li class="w-75">                                                
                                                <select class="form-control" id="supplier_list" name="category_id">
                                                    <option value="" selected>Chọn nhà cung cấp</option>
                                                    @foreach ($suppliers as $item)
                                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                                    @endforeach            
                                                </select>                                    
                                          
                                            </li>

                                            <li class="nk-block-tools-opt">

                                                <a href="{{ route('bill.import.index') }}"
                                                    class="btn btn-primary d-none d-md-inline-flex"><span>Đơn nhập hàng</span></a>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div><!-- .nk-block-head-content -->
                        </div><!-- .nk-block-between -->
                    </div><!-- .nk-block-head -->
                    <div class="nk-block">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="list-products">
                                    <div class="table-custom">
                                        <table id="list_bill" class="table display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Nhà cung cấp</th>
                                                    <th scope="col">Số lượng</th>
                                                    <th scope="col">Đơn vị</th>
                                                    <th scope="col">Đơn giá</th>
                                                    <th scope="col">Ngày sản xuất</th>
                                                    <th scope="col">Ngày hết hạn</th>
                                                    <th scope="col">Tổng tiền</th>
                                                    <th scope="col">Ngày nhập</th>
                                                </tr>   
                                            </thead>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-block -->

                </div>
            </div>
        </div>
    </div>
    <script>
        function areyou() {
            swal({
                    title: "Are you sure?",
                    text: "Once deleted, you will not be able to recover this imaginary file!",
                    icon: "warning",
                    buttons: true,
                    dangerMode: true,
                })
                .then((willDelete) => {
                    if (willDelete) {
                        swal("Poof! Your imaginary file has been deleted!", {
                            icon: "success",
                        });
                    } else {
                        swal("Your imaginary file is safe!");
                    }
                });
        }

    </script>
@endsection
@push('after-scripts')
    <script>
        
        // JS script only for render datatable
        var listBills = $('#list_bill').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "bLengthChange" : false,
            searching: false,
            "ordering": false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: '{{ route('bill.import.product.datatable') }}',
                data: function(d){
                    d._token = '{{ csrf_token() }}',
                    d.product  = $("#product_list").val(),
                    d.supplier = $("#supplier_list").val()
                    // d.type = $('.group-appointment .nav-link.active').attr('data-type'),
                    // d.search = $("#filter_search").val(),
                    // d.start_time = $('#appointment_start_time').val(),
                    // d.end_time = $('#appointment_end_time').val()
                    // d.type_section = arrTypeSection,
                    // d.gender = $("#gender_filter option:selected" ).val(),
                    // d.charge_start = $('#charge_start').val(),
                    // d.charge_end = $('#charge_end').val()
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'product_id', name: 'product_id'},
                {data: 'supplier_id', name: 'supplier_id'},
                {data: 'amount', name: 'amount'},
                {data: 'unit', name: 'unit'},
                {data: 'price', name: 'price'},
                { data: 'entry_date', name: 'entry_date'},
                { data: 'expiry_date', name: 'expiry_date'},
                {data: 'total_price', name: 'total_price'},
                { data: 'created_at', name: 'created_at'},
            ]
        });

        $('#product_list').on('change', function() {
            listBills.draw();
        })  
        $('#supplier_list').on('change', function() {
            listBills.draw();
        })

        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
