@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý đơn hàng</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">

                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            <li>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <form action="" method="GET">
                                                        <input type="text" class="form-control" id="filter_search"
                                                            placeholder="Tìm đơn theo sđt" name="keyword">
                                                    </form>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="drodown">
                                                    <a href="#" class="dropdown-toggle btn btn-outline-light btn-white"
                                                        data-toggle="dropdown">Trạng thái</a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li><a
                                                                    href="#" class="filter-status active" data-status="1" ><span>Đang
                                                                        xử lý</span></a></li>
                                                            <li><a
                                                                    href="#" class="filter-status" data-status="2" ><span>Đang vận chuyển
                                                                        công</span></a></li>
                                                            <li><a
                                                                    href="#" class="filter-status" data-status="3" ><span>Đã vận chuyển</span></a></li>
                                                            <li><a
                                                                    href="#" class="filter-status" data-status="4" ><span>Thất bại</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
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
                                        <table id="list_orders" class="table display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th scope="col">Khách hàng</th>
                                                    <th scope="col">Địa chỉ</th>
                                                    <th scope="col">Trạng thái</th>
                                                    <th scope="col">Thanh toán</th>
                                                    <th scope="col">Ngày tạo</th>
                                                    <th scope="col">Tổng tiền</th>
                                                    <th scope="col">Hành động</th>
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
@endsection
@push('after-scripts')
    <script>
        // JS script only for render datatable
        var listOrders = $('#list_orders').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "bLengthChange" : false,
            searching: false,
            "ordering": false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: '{{ route('order.datatable') }}',
                data: function(d){
                    d._token = '{{ csrf_token() }}',
                    d.search = $("#filter_search").val(),
                    d.status = $('.link-list-opt .filter-status.active').attr("data-status")
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
                {data: 'customer', name: 'customer'},
                {data: 'address', name: 'address'},
                {data: 'status', name: 'status'},
                {data: 'status_payment', name: 'status_payment'},
                {data: 'date_import', name: 'date_import'},
                {data: 'total', name: 'total'},
                {data: 'action', name:'action'}
            ]
        });

        $('#filter_search').on('keyup', function() {
            listOrders.draw();
        })

        $('.link-list-opt .filter-status').on('click', function(e) {
            e.preventDefault();         
            $(".link-list-opt .filter-status").removeClass("active");
            $(this).addClass("active");            
            listOrders.draw(); 
        })

        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
