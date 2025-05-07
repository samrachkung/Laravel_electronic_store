<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- <!-- Brand Logo -->
    <a href="{{url('/dashboard')}}" class="brand-link">
    <img src="{{asset('backend/dist/img/AdminLTELogo.png')}}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
    <span class="brand-text font-weight-light">Admin Dashboard <sup>1.0.0</sup></span>
    </a> --}}

    <!-- Sidebar -->
    <div class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="image">
                <img src="{{asset('backend/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="{{url('/dashboard')}}" class="d-block">{{ Auth::check() ? Auth::user()->name : 'Samrach' }}</a>

            </div>
        </div>

        {{-- <!-- SidebarSearch Form -->
      <div class="form-inline">
        <div class="input-group" data-widget="sidebar-search">
          <input class="form-control form-control-sidebar" type="search" placeholder="Search" aria-label="Search">
          <div class="input-group-append">
            <button class="btn btn-sidebar">
              <i class="fas fa-search fa-fw"></i>
            </button>
          </div>
        </div>
      </div> --}}

        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class
               with font-awesome or any other icon font library -->
                <li class="nav-item @yield('d_menu-open')">
                    <a href="{{url('/dashboard')}}" class="nav-link @yield('d_active')">
                        <i class="nav-icon fas fa-tachometer-alt"></i>
                        <p>
                            Dashboard
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/dashboard')}}" class="nav-link @yield('d_active')">
                                <i class="fas fa-tachometer-alt nav-icon"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @yield('o_menu-open')">
                    <a href="{{url('/order')}}" class="nav-link @yield('o_active')">
                        <i class="nav-icon fas fa-shopping-cart"></i>
                        <p>
                            Order
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/order')}}" class="nav-link @yield('o_active')">
                                <i class="fas fa-shopping-cart nav-icon"></i>
                                <p>Order</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item @yield('pro_menu-open')">
                    <a href="{{url('/product')}}" class="nav-link @yield('pro_active')">
                        <i class="nav-icon fab fa-product-hunt"></i>
                        <p>
                            Product
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/product')}}" class="nav-link @yield('pro_active')">
                                <i class="fab fa-product-hunt nav-icon"></i>
                                <p>Product</p>
                            </a>
                        </li>
                    </ul>
                </li>



                <li class="nav-item @yield('ware_menu-open')">
                    <a href="{{url('/warehouse')}}" class="nav-link @yield('ware_active')">

                        <i class="nav-icon fas fa-warehouse"></i>
                        <p>
                            Warehouse
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/warehouse')}}" class="nav-link @yield('ware_active')">

                                <i class="nav-icon fas fa-warehouse"></i>
                                <p>Warehouse</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @yield('in_menu-open')">
                    <a href="{{url('/income')}}" class="nav-link @yield('in_active')">

                        <i class="nav-icon fas fa-wallet"></i>
                        <p>
                            Income
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/income')}}" class="nav-link @yield('in_active')">

                                <i class="fas fa-wallet nav-icon"></i>
                                <p>Income</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @yield('sale_menu-open')">
                    <a href="{{url('/sales')}}" class="nav-link @yield('sale_active')">
                        <i class="nav-icon fas fa-dollar-sign"></i>
                        <p>
                            Sale
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/sales')}}" class="nav-link @yield('sale_active')">
                                <i class="fas fa-dollar-sign nav-icon"></i>
                                <p>Sale</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @yield('user_menu-open')">
                    <a href="{{url('/users')}}" class="nav-link @yield('user_active')">
                        <i class="nav-icon fas fa-user"></i>
                        <p>
                            User
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/users')}}" class="nav-link @yield('user_active')">
                                <i class="nav-icon fas fa-user"></i>
                                <p>User</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item @yield('menu-open')">
                    <a href="{{url('/product')}}" class="nav-link @yield('active')">
                        <i class="nav-icon fas fa-address-card"></i>
                        <p>
                            Service
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item ">
                            <a href="{{url('/product')}}" class="nav-link @yield('active')">
                                <i class="fas fa-address-card nav-icon"></i>
                                <p>Service</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">SETTING</li>

                <li class="nav-item @yield('p_menu-open')">
                    <a href="#" class="nav-link @yield('p_active')">
                        <i class="nav-icon fas fa-cog"></i>
                        <p>
                            Setting
                            <i class="fas fa-angle-left right"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{url('/category')}}" class="nav-link @yield('p_active')">
                                <i class="fas fa-copyright nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{url('/brand')}}" class="nav-link @yield('b_active')">
                                <i class="fas fa-bold nav-icon"></i>
                                <p>Brand</p>
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>
