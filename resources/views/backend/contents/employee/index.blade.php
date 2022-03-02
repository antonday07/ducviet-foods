@extends('backend.layouts.main')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Nhân viên</h3>
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
                                                <input type="text" class="form-control" id="filter_search" placeholder="Search by name">
                                            </div>
                                        </li>
                                        <li>
                                            <div class="drodown">
                                                <a href="#" class="  btn btn-outline-light btn-white" data-toggle="dropdown">Status</a>
                                                <div class="dropdown-menu dropdown-menu-right">
                                                    <ul class="link-list-opt no-bdr">
                                                        <li><a href="#"><span>Actived</span></a></li>
                                                        <li><a href="#"><span>Inactived</span></a></li>
                                                        <li><a href="#"><span>Blocked</span></a></li>
                                                    </ul>
                                                </div>
                                            </div>
                                        </li>
                                        <li class="nk-block-tools-opt">
                                            
                                            <a href="{{ route('employee.create')}}" class="btn btn-primary d-none d-md-inline-flex"><i class="fas fa-plus"></i><span>Add</span></a>
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
                                                <th scope="col">Tên nhân viên</th>
                                                <th scope="col">Email</th>
                                                <th scope="col">Điện thoại</th>
                                                <th scope="col">Địa chỉ</th>
                                                <th scope="col">Quyền</th>
                                                <th scope="col" class="text-center">Hành động</th>
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
                url: '{{ route('employee.datatable') }}',
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
                {data: 'phone', name: 'phone'},
                {data: 'address', name: 'address'},
                {data: 'role', name: 'role'},
                { data: 'action', name:'action'}
            ]
        });

        $('#filter_search').on('keyup', function() {
            listEmployees.draw();
        })

        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
