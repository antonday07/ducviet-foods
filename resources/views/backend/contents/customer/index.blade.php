@extends('backend.layouts.main')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Khách hàng</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="more-options"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="more-options">
                                    <ul class="nk-block-tools g-3">
                                        <li>
                                            <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                    <i class="fas fa-search"></i>
                                                </div>
                                                <input type="text" class="form-control" id="filter_search" placeholder="Tìm kiếm theo tên">
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
                                    <table id="list_employee" class="table display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th scope="col">Tên khách hàng</th>
                                                <th scope="col">Hình ảnh</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Điện thoại</th>
                                                <th scope="col">Địa chỉ</th>
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
        var listEmployees = $('#list_employee').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "bLengthChange" : false,
            searching: false,
            "ordering": false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: '{{ route('customer.datatable') }}',
                data: function(d){
                    d._token = '{{ csrf_token() }}',
                    d.search = $("#filter_search").val()
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
                {data: 'name', name: 'name'},
                {data: 'email', name: 'email'},
                {data: 'avatar', name: 'avatar' },
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
            ]
        });

        $('#filter_search').on('keyup', function() {
            listEmployees.draw();
        })

        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush