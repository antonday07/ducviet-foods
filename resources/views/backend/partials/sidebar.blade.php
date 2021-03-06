<div class="nk-sidebar nk-sidebar-fixed is-light " data-content="sidebarMenu">
    <div class="nk-sidebar-element nk-sidebar-head">
        <div class="nk-sidebar-brand">
            <a href="/admin" class="logo-link nk-sidebar-logo">
                <img class="logo-img" src="{{ asset('images/avatar/logo-ducviet.png')}}"  alt="logo">
                
            </a>
        </div>
        <div class="nk-menu-trigger mr-n2">
            <a href="#" class="nk-nav-toggle nk-quick-nav-icon d-xl-none" data-target="sidebarMenu"><i class="fas fa-chevron-left"></i></a>
            <a href="#" class="nk-nav-compact nk-quick-nav-icon d-none d-xl-inline-flex" data-target="sidebarMenu"><i class="fas fa-chevron-left"></i></a>
        </div>
    </div><!-- .nk-sidebar-element -->
    <div class="nk-sidebar-element">
        <div class="nk-sidebar-content">
            <div class="nk-sidebar-menu" data-simplebar>
                <ul class="nk-menu">
                    <li class="nk-menu-item">
                        <a href="{{ route('admin.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-tile-thumb-fill"></i></span>
                            <span class="nk-menu-text">Bảng điều khiển</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{route('order.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-bag"></i></span>
                            <span class="nk-menu-text">Đơn hàng</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><i class="icon ni ni-view-col"></i></span>
                            <span class="nk-menu-text">Dữ liệu sản phẩm</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('category.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-files-fill"></i></span>
                                    <span class="nk-menu-text">Danh mục</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('unit.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-external-alt"></i></span>
                                    <span class="nk-menu-text">Đơn vị tính</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('promotion.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-sign-mxn"></i></span>
                                    <span class="nk-menu-text">Khuyến mãi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
               
                    <li class="nk-menu-item">
                        <a href="{{ route('product.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-grid-alt-fill"></i></span>
                            <span class="nk-menu-text">Sản phẩm</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><i class="icon ni ni-file-docs"></i></span>
                            <span class="nk-menu-text">Dữ liệu nhập hàng</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('bill.import.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-package-fill"></i></span>
                                    <span class="nk-menu-text">Các đơn nhập hàng</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('bill.import.product.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-db-fill"></i></span>
                                    <span class="nk-menu-text">Sản phẩm đã nhập</span>
                                </a>
                            </li>
                         
                        </ul>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><i class="icon ni ni-files-fill"></i></span>
                            <span class="nk-menu-text">Báo cáo thống kê</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('report.index.income') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-cc-alt"></i></span>
                                    <span class="nk-menu-text">Thống kê doanh thu</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('report.index.product') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-package"></i></span>
                                    <span class="nk-menu-text">Thống kê sản phẩm tồn kho</span>
                                </a>
                            </li>        
                            {{-- <li class="nk-menu-item">
                                <a href="{{ route('report.index.order') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-edit"></i></span>
                                    <span class="nk-menu-text">Thống kê đơn hàng</span>
                                </a>
                            </li> --}}

                            {{-- <li class="nk-menu-item">
                                <a href="{{ route('report.index.warehouse') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="icon ni ni-folder"></em></i></span>
                                    <span class="nk-menu-text">Thống kê hàng tồn</span>
                                </a>
                            </li> --}}
                         
                        </ul>
                    </li>

                  
                    <li class="nk-menu-item">
                        <a href="{{ route('warehouse.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-view-x6"></i></span>
                            <span class="nk-menu-text">Kho hàng</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('supplier.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-activity-round-fill"></i></span>
                            <span class="nk-menu-text">Nhà cung cấp</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('shipping.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-archived"></i></span>
                            <span class="nk-menu-text">Vận chuyển</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('customer.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-users-fill"></i></span>
                            <span class="nk-menu-text">Khách hàng</span>
                        </a>
                    </li>

                    @if (\Auth::guard('admin')->user()->role == 1)
                        <li class="nk-menu-item">
                            <a href="{{ route('employee.index') }}" class="nk-menu-link">
                                <span class="nk-menu-icon"><i class="icon ni ni-user-list-fill"></i></span>
                                <span class="nk-menu-text">Nhân viên</span>
                            </a>
                        </li>
                    @endif

                    <li class="ml-4">
                        <a href="{{ route('product')}}" style="color: black;">Quay lại trang chủ Client</a>
                    </li>
                    
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>