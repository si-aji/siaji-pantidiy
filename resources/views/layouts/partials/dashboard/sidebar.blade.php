<aside class="main-sidebar sidebar-dark-primary elevation-4">
    <!-- Brand Logo -->
    <a href="{{ route('dashboard.index') }}" class="brand-link">
        <img src="{{ !empty($wlogo) ? asset('settings'.'/'.$wlogo) : asset('adminlte/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3" style="opacity: .8">
        <span class="brand-text font-weight-light">{{ $wtitle ?? 'SIAJI' }}</span>
    </a>
    
    <!-- Sidebar -->
    <div class="sidebar">
        @if(auth()->user())
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel mt-3 pb-3 mb-3 d-flex">
            <div class="info">
                <a href="{{ route('dashboard.index') }}" class="d-block">{{ auth()->user()->name ?? '' }}</a>
            </div>
        </div>
        @endif
    
        <!-- Sidebar Menu -->
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <!-- Add icons to the links using the .nav-icon class with font-awesome or any other icon font library -->
                <li class="nav-item">
                    <a href="{{ route('dashboard.index') }}" class="nav-link {{ !empty($menu) ? ($menu == 'dashboard' ? 'active' : '') : '' }}">
                        <i class="nav-icon fas fa-chalkboard"></i>
                        <p class="text">Dashboard</p>
                    </a>
                </li>

                <li class="nav-header">Content</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.page.index') }}" class="nav-link {{ !empty($menu) ? ($menu == 'page' ? 'active' : '') : '' }}">
                        <i class="nav-icon fas fa-file"></i>
                        <p class="text">Pages</p>
                    </a>
                </li>
                <li class="nav-item has-treeview {{ !empty($menu) ? ($menu == 'post' ? 'menu-open' : '') : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-book"></i>
                        <p>
                            Posts
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.category.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'category' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Category</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.keyword.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'keyword' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Keyword</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.post.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'post_list' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>All Post</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">Social Care</li>
                <li class="nav-item has-treeview {{ !empty($menu) ? ($menu == 'panti' ? 'menu-open' : '') : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-home"></i>
                        <p>
                            Panti
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.panti.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'list' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>List</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.panti.liputan.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'liputan' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Liputan</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.donation.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'donation' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Donation</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-header">SETTINGS</li>
                <li class="nav-item has-treeview {{ !empty($menu) ? ($menu == 'location' ? 'menu-open' : '') : '' }}">
                    <a href="#" class="nav-link">
                        <i class="nav-icon fas fa-search-location"></i>
                        <p>
                            Location Setting
                            <i class="right fas fa-angle-left"></i>
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('dashboard.provinsi.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'provinsi' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Provinsi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.kabupaten.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'kabupaten' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kabupaten</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('dashboard.kecamatan.index') }}" class="nav-link {{ !empty($sub_menu) ? ($sub_menu == 'kecamatan' ? 'active' : '') : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Kecamatan</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('dashboard.profile.index') }}" class="nav-link {{ !empty($menu) ? ($menu == 'profile' ? 'active' : '') : '' }}">
                        <i class="nav-icon fas fa-user-cog"></i>
                        <p class="text">Profile</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.setting.index') }}" class="nav-link {{ !empty($menu) ? ($menu == 'setting' ? 'active' : '') : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p class="text">Settings</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('dashboard.roles-setting.index') }}" class="nav-link {{ !empty($menu) ? ($menu == 'roles' ? 'active' : '') : '' }}">
                        <i class="nav-icon fas fa-cog"></i>
                        <p class="text">Roles Settings</p>
                    </a>
                </li>

                @if(auth()->user())
                <li class="nav-item">
                    <form id="logout-form" action="{{ route('public.logout') }}" method="POST" style="display: none;">
                        @csrf
                    </form>

                    <a href="#" class="nav-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="nav-icon fas fa-sign-out-alt text-danger"></i>
                        <p class="text">Logout</p>
                    </a>
                </li>
                @endif
            </ul>
        </nav>
        <!-- /.sidebar-menu -->
    </div>
    <!-- /.sidebar -->
</aside>