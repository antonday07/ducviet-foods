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
                        <a href="/admin" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="icon ni ni-tile-thumb-fill"></i></span>
                            <span class="nk-menu-text">Bảng điều khiển</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{route('order.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="fas fa-shopping-bag"></i></span>
                            <span class="nk-menu-text">Đơn hàng</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                            <span class="nk-menu-text">Dữ liệu sản phẩm</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('category.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                                    <span class="nk-menu-text">Danh mục</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('unit.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                                    <span class="nk-menu-text">Đơn vị tính</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('promotion.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                                    <span class="nk-menu-text">Khuyến mãi</span>
                                </a>
                            </li>
                        </ul>
                    </li>
               
                    <li class="nk-menu-item">
                        <a href="{{ route('product.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="fas fa-cube"></i></span>
                            <span class="nk-menu-text">Sản phẩm</span>
                        </a>
                    </li>
                    <li class="nk-menu-item has-sub">
                        <a href="#" class="nk-menu-link nk-menu-toggle">
                            <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                            <span class="nk-menu-text">Dữ liệu nhập hàng</span>
                        </a>
                        <ul class="nk-menu-sub">
                            <li class="nk-menu-item">
                                <a href="{{ route('bill.import.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                                    <span class="nk-menu-text">Nhập hàng</span>
                                </a>
                            </li>
                            <li class="nk-menu-item">
                                <a href="{{ route('unit.index') }}" class="nk-menu-link">
                                    <span class="nk-menu-icon"><i class="fas fa-box-open"></i></span>
                                    <span class="nk-menu-text">Sản phẩm đã nhập</span>
                                </a>
                            </li>
                         
                        </ul>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('supplier.index')}}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="fas fa-cube"></i></span>
                            <span class="nk-menu-text">Nhà cung cấp</span>
                        </a>
                    </li>
                    <li class="nk-menu-item">
                        <a href="{{ route('customer.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="fas fa-user-friends"></i></span>
                            <span class="nk-menu-text">Khách hàng</span>
                        </a>
                    </li>

                    <li class="nk-menu-item">
                        <a href="{{ route('employee.index') }}" class="nk-menu-link">
                            <span class="nk-menu-icon"><i class="fas fa-user-tie"></i></span>
                            <span class="nk-menu-text">Nhân viên</span>
                        </a>
                    </li>

                    <li class="ml-4">
                        <a href="{{ route('product')}}" style="color: black;">Quay lại trang chủ Client</a>
                    </li>
                    
                </ul><!-- .nk-menu -->
            </div><!-- .nk-sidebar-menu -->
        </div><!-- .nk-sidebar-content -->
    </div><!-- .nk-sidebar-element -->
</div>