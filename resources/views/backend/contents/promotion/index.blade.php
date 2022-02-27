@extends('backend.layouts.main')

@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Khuyến mãi</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                    data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="nk-block-tools g-3">
                                        
                                        <li class="nk-block-tools-opt">

                                            <a href="{{ route('promotion.create') }}"
                                                class="btn btn-primary d-none d-md-inline-flex"><i
                                                    class="fas fa-plus"></i><span>Add Promotion</span></a>
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
                                    <table id="list_promotion" class="table display" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>No</th>
                                                <th scope="col">Tên khuyến mãi</th>
                                                <th scope="col">Mô tả</th>
                                                <th scope="col">Loại khuyến mãi</th>
                                                <th scope="col">Giảm giá</th>
                                                <th scope="col">Ngày bắt đầu</th>
                                                <th scope="col">Ngày hết hạn</th>
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
        var listPromotion = $('#list_promotion').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "bLengthChange" : false,
            searching: false,
            "ordering": false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: '{{ route('promotion.datatable') }}',
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
                {data: 'name', name: 'name'},
                {data: 'description', name: 'description'},
                {data: 'type', name: 'type'},
                {data: 'price', name: 'price'},
                {data: 'date_from', name: 'date_from'},
                {data: 'date_expiry', name: 'date_expiry'},
                { data: 'action', name:'action'}
            ]
        });

        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
