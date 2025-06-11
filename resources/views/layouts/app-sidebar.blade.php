<aside class="main-sidebar sidebar-dark-primary elevation-4">
    {{-- Brand --}}
    <a href="{{ route('dashboard') }}" class="brand-link">
        <img src="{{ asset('img/brand.png') }}" class="brand-image img-circle elevation-3 bg-white" style="opacity: .8">
        <span class="brand-text font-weight-bold">RAMS_Arung01</span>
    </a>

    <div class="sidebar">
        {{-- Profile --}}
        <div class="user-panel my-3 pb-3 d-flex">
            <div class="image">
                <img src="{{ asset('img/user.png') }}" class="img-circle elevation-2" alt="User Image">
            </div>
            <div class="info">
                <a href="#" class="d-block font-weight-bold">{{ Session::get('nama') }}</a>
            </div>
        </div>

        {{-- Menu --}}
        <nav class="mt-2">
            <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                <li class="nav-header">MENU UTAMA</li>
                <li class="nav-item">
                    <a href="{{ route('dashboard') }}" class="nav-link {{ Request::is('dashboard') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-home"></i>
                        <p>Dashboard</p>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="{{ route('admin.map') }}" class="nav-link {{ Request::is('map') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-globe"></i>
                        <p>Map</p>
                    </a>
                </li>

                <li class="nav-item has-treeview {{ Request::is('leger*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('leger*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-road"></i>
                        <p>
                            Leger
                        </p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('admin.leger.jalanUtama.view.select') }}"
                                class="nav-link {{ Request::is('leger') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Cetak Leger</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('admin.leger.jalanUtama.edit.select') }}"
                                class="nav-link {{ Request::is('leger/edit') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Detail Leger</p>
                            </a>
                        </li>
                    </ul>
                </li>


                <li class="nav-item has-treeview {{ Request::is('input*') ? 'menu-open' : '' }}">
                    <a href="#" class="nav-link {{ Request::is('input*') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-upload"></i>
                        <p>Input</p>
                    </a>
                    <ul class="nav nav-treeview">
                        <li class="nav-item">
                            <a href="{{ route('input.ruas') }}"
                                class="nav-link {{ Request::is('input/ruas') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Ruas</p>
                            </a>
                        </li>

                        {{-- <li class="nav-item">
                            <a href="{{ route('input.aset') }}"
                                class="nav-link {{ Request::is('input/aset') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Aset</p>
                            </a>
                        </li> --}}

                        <li class="nav-item">
                            <a href="{{ route('input.aset-temp') }}"
                                class="nav-link {{ Request::is('input/aset-temp') ? 'active' : '' }}">
                                <i class="far fa-circle nav-icon"></i>
                                <p>Tambah Aset</p>
                            </a>
                        </li>
                    </ul>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.maintenance') }}"
                        class="nav-link {{ Request::is('maintenance') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-code"></i>
                        <p>Maintenance</p>
                    </a>
                </li>

                <li class="nav-item">
                    <a href="{{ route('admin.manage_aset') }}"
                        class="nav-link {{ Request::is('manage-aset') ? 'active' : '' }}">
                        <i class="nav-icon fas fa-list"></i>
                        <p>Manage Aset</p>
                    </a>
                </li>
                
                <li class="nav-item">
                    <a href="{{ route('logout') }}" class="nav-link">
                        <i class="nav-icon fas fa-sign-out-alt"></i>
                        <p>Logout</p>
                    </a>
                </li>
            </ul>
        </nav>
    </div>
</aside>