@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Danh sách đơn nhập hàng</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            
                                            <li class="nk-block-tools-opt">

                                                <a href="{{ route('bill.import.create') }}"
                                                    class="btn btn-primary d-none d-md-inline-flex"><i
                                                        class="fas fa-plus"></i><span>Thêm đơn nhập hàng</span></a>
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
                                                    <th scope="col">Mã đơn hàng</th>
                                                    <th scope="col">Nội dung nhập hàng</th>
                                                    <th scope="col">Người nhập</th>
                                                    <th scope="col">Ghi chú</th>
                                                    <th scope="col">Ngày tạo</th>
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
                url: '{{ route('bill.import.datatable') }}',
                data: function(d){
                    d._token = '{{ csrf_token() }}'
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
                {data: 'bill_id', name: 'bill_id'},
                {data: 'description', name: 'description'},
                {data: 'employee', name: 'employee'},
                {data: 'note', name: 'note'},
                { data: 'created_at', name: 'created_at'},
                { data: 'action', name:'action'}
            ]
        });

        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
