<nav class="page-sidebar" id="sidebar">
    <div id="sidebar-collapse">
        <div class="admin-block d-flex">
            <div>
                <img src="{{asset('assets/img/admin-avatar.png')}}" width="45px" />
            </div>
            <div class="admin-info">
                <div class="font-strong"></div><small class="text-capitalize"></small></div>
        </div>
        <ul class="side-menu metismenu">
            <li>
                <a class="{{url()->current() == route('dashboard') ? 'active' : ''}}" href="{{route('dashboard')}}"><i class="sidebar-item-icon fa fa-th-large"></i>
                    <span class="nav-label">Dashboard</span>
                </a>
            </li>
            <li class="heading">FEATURES</li>
            @canany(['create category', 'read category'])
                <li class="{{$activeNav == 'categories' ? 'active' : ''}}">
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-tags"></i>
                        <span class="nav-label">Categories</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        @can('create category')
                            <li>
                                <a class="{{url()->current() == route('categories.create') ? 'active' : ''}}" href="{{route('categories.create')}}">Create New</a>
                            </li>
                        @endcan
                        @can('read category')
                            <li>
                                <a class="{{url()->current() == route('categories.index') ? 'active' : ''}}" href="{{route('categories.index')}}">Manage Categories</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
            @canany(['create product', 'read product'])
                <li class="{{$activeNav == 'products' ? 'active' : ''}}">
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-cubes"></i>
                        <span class="nav-label">Products</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        <li>
                            <a class="{{url()->current() == route('products.create') ? 'active' : ''}}" href="{{route('products.create')}}">Create New</a>
                        </li>
                        <li>
                            <a class="{{url()->current() == route('products.index') ? 'active' : ''}}" href="{{route('products.index')}}">Manage Products</a>
                        </li>
                    </ul>
                </li>
            @endcanany
            @canany(['create purchase', 'read purchase'])
                <li class="{{$activeNav == 'purchases' ? 'active' : ''}}">
                    <a href="javascript:;"><i class="sidebar-item-icon fa fa-briefcase"></i>
                        <span class="nav-label">Purchases</span><i class="fa fa-angle-left arrow"></i></a>
                    <ul class="nav-2-level collapse">
                        @can('create purchase')
                            <li>
                                <a class="{{url()->current() == route('purchases.create') ? 'active' : ''}}" href="{{route('purchases.create')}}">Create New</a>
                            </li>
                        @endcan
                        @can('read purchase')
                            <li>
                                <a class="{{url()->current() == route('purchases.index') ? 'active' : ''}}" href="{{route('purchases.index')}}">Manage Purchases</a>
                            </li>
                        @endcan
                    </ul>
                </li>
            @endcanany
     
        </ul>
    </div>
</nav>