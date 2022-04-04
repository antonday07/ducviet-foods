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
                                            <li>
                                                <div class="form-control-wrap">
                                                <div class="form-icon form-icon-right">
                                                        <i class="fas fa-search"></i>
                                                    </div>
                                                    <form action="" method="GET">
                                                        <input type="text" class="form-control" id="filter_search"
                                                            placeholder="Nhập mã đơn" name="keyword">
                                                    </form>
                                                </div>
                                            </li>
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
            
                    <!-- Modal -->
                    <div class="modal fade" id="modalViewBill" tabindex="-1" role="dialog"
                        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered" role="document">
                            <div class="modal-content" style="min-width: 500px; padding: 20px">
                                <div class="mb-3">
                                    <h4 class="title text-center">Chi tiết đơn nhập hàng</h4>
                                </div>
                                <div class="box-bill-detail mb-3">
                                    <p>Mã đơn hàng: <span class="bill-code"></span></p>
                                    <p>Nhân vien nhập: <span class="bill-employee"></span></p>
                                    <p>Ghi chú: <span class="bill-note"></span></p>
                                    <p>Ngày nhập: <span class="bill-date"></span></p>
                                </div>
                                <div class="box-bill-product">
                                    <div class="myaccount-table table-responsive text-center">
                                        <table class="table table-bordered">
                                            <thead class="thead-light">
                                                <tr>
                                                    <th>Mã</th>
                                                    <th>Tên sản phẩm</th>
                                                    <th>Nhà cung cấp</th>
                                                    <th>Số lượng</th>
                                                    <th>Đơn giá</th>
                                                    <th>Đơn vị</th>
                                                    <th>Ngày sản xuất</th>
                                                    <th>Ngày hết hạn</th>
                                                    <th>Tổng tiền</th>
                                                </tr>
                                            </thead>
                                            <tbody class="product-bills">
                                                
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

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

        function numberWithCommas(x) {
            return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ".");
        }
        
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
                    d._token = '{{ csrf_token() }}',
                    d.search = $("#filter_search").val()
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

        $('#filter_search').on('keyup', function() {
            listBills.draw();
        })

        // show modal view detail
        $('body').on('click', '.btn-view-detail', function() {
            let listProduct = '';
            let codeBill = $(this).data('code-bill');
            let employee = $(this).data('employee');
            let note = $(this).data('note'); 
            let date = $(this).data('date'); 
            let products = $(this).data('object'); 
            

            $('.bill-code').text(codeBill);
            $('.bill-employee').text(employee);
            $('.bill-note').text(note);
            $('.bill-date').text(date);

            products.forEach(ele => {
                listProduct += `
                    <tr>
                        <td>#${codeBill}</td>
                        <td>#${ele.product.name}</td>
                        <td>${ele.supplier.name}</td>
                        <td>${ele.amount}</td>
                        <td>${numberWithCommas(ele.price)} đ</td>
                        <td>${ele.product.unit.name}</td>
                        <td>${ele.entry_date}</td>
                        <td>${ele.expiry_date}</td>
                        <td>${numberWithCommas(ele.total_price)} đ</td>
                    </tr>                                                            
                ` ;
            });

            $('.product-bills').html(listProduct);
                                             
         //   $('#modalViewBill').show();
            console.log(codeBill);
            console.log(employee, note);
            console.log(date);
            console.log(products);
        });


        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
