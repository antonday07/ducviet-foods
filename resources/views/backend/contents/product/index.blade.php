@extends('backend.layouts.main')

@section('content')
    <div class="nk-content ">
        <div class="container-fluid">
            <div class="nk-content-inner">
                <div class="nk-content-body">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-between">
                            <div class="nk-block-head-content">
                                <h3 class="nk-block-title page-title">Sản phẩm</h3>
                            </div><!-- .nk-block-head-content -->
                            <div class="nk-block-head-content">
                                <div class="toggle-wrap nk-block-tools-toggle">
                                    <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1"
                                        data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                    <div class="toggle-expand-content" data-content="pageMenu">
                                        <ul class="nk-block-tools g-3">
                                            
                                            <li class="nk-block-tools-opt">

                                                <a href="{{ route('product.create') }}"
                                                    class="btn btn-primary d-none d-md-inline-flex"><i
                                                        class="fas fa-plus"></i><span>Thêm sản phẩm</span></a>
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
                                        <table id="list_products" class="table display" style="width:100%">
                                            <thead>
                                                <tr>
                                                    <th>No</th>
                                                    <th scope="col">Thumbnail</th>
                                                    <th scope="col">Tên sản phẩm</th>
                                                    <th scope="col">Giá nhập</th>
                                                    <th scope="col">Giá bán lẻ</th>
                                                    <th scope="col">Trạng thái</th>
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
                                 <h4 class="title text-center">Các lô hàng của sản phẩm</h4>
                                 <div class="box-note d-flex justify-content-center">
                                    <div class="box-note-circle circle-yellow">Màu vàng: là lô sắp hết hạn</div>
                                    <div class="box-note-circle circle-red">Màu đỏ: là lô đã hết hạn</div>
                                 </div> 
                             </div>
                             <div class="box-empty-product d-none">
                                 <p class="text-center">Sản phẩm này chưa có lô hàng nào</p>
                             </div>
                             {{-- <div class="box-bill-detail mb-3">
                                 <p>Mã đơn hàng: <span class="bill-code"></span></p>
                                 <p>Nhân vien nhập: <span class="bill-employee"></span></p>
                                 <p>Ghi chú: <span class="bill-note"></span></p>
                                 <p>Ngày nhập: <span class="bill-date"></span></p>
                             </div> --}}
                             <div class="box-bill-product box-list-product-detail">
                                 <div class="myaccount-table table-responsive text-center">
                                     <table class="table table-bordered">
                                         <thead class="thead-light">
                                             <tr>
                                                 <th>Mã</th>
                                                 <th>Tên sản phẩm</th>
                                                 <th>Nhà cung cấp</th>
                                                 <th>Số lượng</th>
                                                 <th>Số lượng đã bán</th>
                                                 <th>Đơn giá</th>
                                                 <th>Đơn vị</th>
                                                 <th>Ngày sản xuất</th>
                                                 <th>Ngày hết hạn</th>
                                                 <th>Tổng tiền</th>
                                                 <th>Hành động</th>
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
        var listProducts = $('#list_products').DataTable({
            responsive: true,
            processing: true,
            serverSide: true,
            "bLengthChange" : false,
            searching: false,
            "ordering": false,
            pageLength: 5,
            ajax: {
                type: "GET",
                url: '{{ route('product.datatable') }}',
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
                {data: 'thumbnail', name: 'thumbnail'},
                {data: 'name', name: 'name'},
                {data: 'entry_price', name: 'entry_price'},
                {data: 'retail_price', name: 'retail_price'},
                { data: 'status', name: 'status'},
                { data: 'action', name:'action'}
            ]
        });

        
        // show modal view detail
        $('body').on('click', '.btn-view-detail', function() {
            let listProduct = '';           
            let products = $(this).data('object'); 

            if(products.length > 0 ) {

                $('.box-bill-product').removeClass('d-none');
                $('.box-empty-product').addClass('d-none');

                products.forEach(ele => {
                    let today = new Date();
                    let expiryDate = new Date(ele.expiry_date);
                    let diffTime = expiryDate.getTime() - today.getTime();    
                    let diffDay = parseInt(diffTime / (1000 * 3600 * 24));
                    let className = (diffDay <= 2 && diffDay > 0 ) ? 'row-yellow' : (diffDay <= 0 ? 'row-red' : ''); 

                    console.log(today, expiryDate, diffDay);
                    listProduct += `
                        <tr class="${className}">
                            <td>#${ele.bill_import.code_bill}</td>
                            <td>#${ele.product.name}</td>
                            <td>${ele.supplier.name}</td>
                            <td>${ele.amount}</td>
                            <td>${ele.sold_quantity}</td>
                            <td>${numberWithCommas(ele.price)} đ</td>
                            <td>${ele.product.unit.name}</td>
                            <td>${ele.entry_date}</td>
                            <td>${ele.expiry_date}</td>
                            <td>${numberWithCommas(ele.total_price)} đ</td>
                            <td>
                                <button class="btn btn-danger" title="Thanh lý lô hàng">
                                    <i class="fas fa-trash-alt "></i> 
                                </button>
                            </td>
                        </tr>                                                            
                    ` ;
                });
    
                $('.product-bills').html(listProduct);
            } else {
                $('.box-bill-product').addClass('d-none');
                $('.box-empty-product').removeClass('d-none');
            }
            console.log(products);

                                             
         //   $('#modalViewBill').show();          
        });


        // delete item product
        $('body').on('click', '.btn-delete-item', deleteConfirmation);


    </script>
@endpush
