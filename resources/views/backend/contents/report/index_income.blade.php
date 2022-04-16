@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Báo cáo doanh thu </h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <form action="" method="GET">
                                                        <input type="text" class="form-control" id="filter_search"
                                                            placeholder="Nhập tên sản phẩm" name="keyword">
                                                    </form>
                                                </div>
                                            </li>
{{-- 
                                            <li>
                                                <div class="form-group group-date">
                                                    <input type="text" class="form-control date form-input ed-form-input" id="date_from" name="date_from" placeholder="Từ ngày" value="">
                                                    <div class="icon-calendar no-label" id="icon_date_left">
                                                        <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                                    </div>
            
                                                </div>
                                            </li>
    
                                            <li>
                                                <div class="form-group group-date">
                                                    <input type="text" class="form-control date form-input ed-form-input" id="date_to" name="date_to" placeholder="Đến ngày" value="">
                                                    <div class="icon-calendar no-label" id="icon_date_left">
                                                        <img src="{{ asset('images/avatar/calendar.svg') }}" alt="">
                                                    </div>
            
                                                </div>
                                            </li>

                                            <li>

                                                <div class="form-group group-date">
                                                   <button class="btn btn-primary btn-find-product">Tìm</button>

                                                </div>
                                            </li> --}}

                                            {{-- <li class="nk-block-tools-opt">

                                                <a href="{{ route('bill.import.index') }}"
                                                    class="btn btn-primary d-none d-md-inline-flex"><span>Đơn nhập hàng</span></a>
                                            </li> --}}
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
                                                    <th scope="col">Ảnh</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Đơn vị</th>
                                                    <th scope="col">Tổng tiền nhập</th>
                                                    <th scope="col">Tổng tiền bán</th>
                                                    <th scope="col">Lợi nhuận</th>
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
                url: '{{ route('report.datatable.income') }}',
                data: function(d){
                    d._token = '{{ csrf_token() }}',
                    d.search = $("#filter_search").val(),
                    d.date_from = $('#date_from').val(),
                    d.date_to = $('#date_to').val()
                    // d.product  = $("#product_list").val(),
                    // d.supplier = $("#supplier_list").val()
                    // d.type = $('.group-appointment .nav-link.active').attr('data-type'),
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
                {data: 'thumbnail', name: 'thumbnail'},
                {data: 'name', name: 'name'},
                {data: 'unit', name: 'unit'},
                { data: 'amount_entry', name: 'amount_entry'},
                { data: 'amount_sell', name: 'amount_sell'},
                {data: 'total', name: 'total'},
            ]
        });

        
        $('.date').datepicker({
            format: 'yyyy-mm-dd'
        });

        $('#filter_search').on('keyup', function() {
            listBills.draw();
        }) 
    

        $('.btn-find-product').on('click', function() {
            listBills.draw();

        })
        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
