@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Quản lý kho</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">

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

                                            {{-- <li>
                                                <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <form action="" method="GET">
                                                        <input type="text" class="form-control" id="filter_search"
                                                            placeholder="Tìm kiếm theo tên " name="keyword">
                                                    </form>
                                                </div>
                                            </li> --}}


                                            {{-- <li>
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
                                                                    href="#" class="filter-status" data-status="4" ><span>Đã nhận hàng</span></a></li>
                                                            <li><a
                                                                href="#" class="filter-status" data-status="5" ><span>Tất cả</span></a></li>
                                                        </ul>
                                                    </div>
                                                </div>
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
                                        <table id="list_orders" class="table display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Số lượng nhập</th>
                                                    <th scope="col">Số lượng</th>
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
                url: '{{ route('warehouse.datatable') }}',
                data: function(d){
                    d._token = '{{ csrf_token() }}',
                    d.product  = $("#product_list").val()
                    // d.search = $("#filter_search").val()                    // d.search = $("#filter_search").val(),
                },
            },
            columns: [
                {data: 'DT_RowIndex', name: 'DT_RowIndex'},
                {data: 'product', name: 'product'},
                {data: 'sum_import', name: 'sum_import'},
                {data: 'quantity', name: 'quantity'},
            ]
        });

        $('#product_list').on('change', function() {
            listOrders.draw();
        })

        // $('#filter_search').on('keyup', function() {
        //     listOrders.draw();
        // })
    </script>
@endpush
