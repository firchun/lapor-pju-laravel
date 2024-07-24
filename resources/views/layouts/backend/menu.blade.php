<div class="right-sidebar">
    <div class="sidebar-title">
        <h3 class="weight-600 font-16 text-blue">
            Pengaturan letak
            {{-- <span class="btn-block font-weight-400 font-12">User Interface Settings</span> --}}
        </h3>
        <div class="close-sidebar" data-toggle="right-sidebar-close">
            <i class="icon-copy ion-close-round"></i>
        </div>
    </div>
    <div class="right-sidebar-body customscroll">
        <div class="right-sidebar-body-content">
            <h4 class="weight-600 font-18 pb-10">Header Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary header-white active">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary header-dark">Dark</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Sidebar Background</h4>
            <div class="sidebar-btn-group pb-30 mb-10">
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-light">White</a>
                <a href="javascript:void(0);" class="btn btn-outline-primary sidebar-dark active">Dark</a>
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu Dropdown Icon</h4>
            <div class="sidebar-radio-group pb-10 mb-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebaricon-1" name="menu-dropdown-icon" class="custom-control-input"
                        value="icon-style-1" checked="" />
                    <label class="custom-control-label" for="sidebaricon-1"><i class="fa fa-angle-down"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebaricon-2" name="menu-dropdown-icon" class="custom-control-input"
                        value="icon-style-2" />
                    <label class="custom-control-label" for="sidebaricon-2"><i class="ion-plus-round"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebaricon-3" name="menu-dropdown-icon" class="custom-control-input"
                        value="icon-style-3" />
                    <label class="custom-control-label" for="sidebaricon-3"><i
                            class="fa fa-angle-double-right"></i></label>
                </div>
            </div>

            <h4 class="weight-600 font-18 pb-10">Menu List Icon</h4>
            <div class="sidebar-radio-group pb-30 mb-10">
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-1" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-1" checked="" />
                    <label class="custom-control-label" for="sidebariconlist-1"><i class="ion-minus-round"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-2" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-2" />
                    <label class="custom-control-label" for="sidebariconlist-2"><i class="fa fa-circle-o"
                            aria-hidden="true"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-3" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-3" />
                    <label class="custom-control-label" for="sidebariconlist-3"><i class="dw dw-check"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-4" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-4" checked="" />
                    <label class="custom-control-label" for="sidebariconlist-4"><i
                            class="icon-copy dw dw-next-2"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-5" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-5" />
                    <label class="custom-control-label" for="sidebariconlist-5"><i
                            class="dw dw-fast-forward-1"></i></label>
                </div>
                <div class="custom-control custom-radio custom-control-inline">
                    <input type="radio" id="sidebariconlist-6" name="menu-list-icon" class="custom-control-input"
                        value="icon-list-style-6" />
                    <label class="custom-control-label" for="sidebariconlist-6"><i class="dw dw-next"></i></label>
                </div>
            </div>

            <div class="reset-options pt-30 text-center">
                <button class="btn btn-danger" id="reset-settings">
                    Reset Settings
                </button>
            </div>
        </div>
    </div>
</div>
<div class="left-side-bar">
    <div class="brand-logo">
        <a href="{{ route('home') }}">
            <img src="{{ asset('img/logo.png') }}" alt="" class="dark-logo" style="height: 50px;" />
            <img src="{{ asset('img/logo.png') }}" alt="" class="light-logo" style="height: 50px;" />
        </a>
        <div class="close-sidebar" data-toggle="left-sidebar-close">
            <i class="ion-close-round"></i>
        </div>
    </div>
    <div class="menu-block customscroll">
        <div class="sidebar-menu">
            <ul id="accordion-menu">
                <li>
                    <a href="{{ route('home') }}"
                        class="dropdown-toggle no-arrow {{ request()->is('home') ? 'active' : '' }}">
                        <span class="micon bi bi-house"></span><span class="mtext">Dashboard</span>
                    </a>
                </li>
                @if (Auth::user()->role == 'Admin')
                    <li>
                        <a href="{{ route('mitra') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('mitra*') ? 'active' : '' }}">
                            <span class="micon bi bi-building"></span><span class="mtext">Mitra</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('fasilitas') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('fasilitas*') ? 'active' : '' }}">
                            <span class="micon bi bi-lightbulb"></span><span class="mtext">Fasilitas PJU</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-people"></span><span class="mtext">Pengguna</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('users.admin') }}"
                                    class="{{ request()->is('users/admin') ? 'active' : '' }}">Admin</a>
                            </li>
                            <li>
                                <a href="{{ route('users.teknisi') }}"
                                    class="{{ request()->is('users/teknisi') ? 'active' : '' }}">Teknisi</a>
                            </li>
                        </ul>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-folder"></span><span class="mtext">Laporan</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('laporan.perbaikan') }}"
                                    class="{{ request()->is('laporan/perbaikan*') ? 'active' : '' }}">Laporan
                                    perbaikan</a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.teknisi') }}"
                                    class="{{ request()->is('laporan/teknisi*') ? 'active' : '' }}">Laporan
                                    teknisi</a>
                            </li>


                        </ul>
                    </li>
                @else
                    <li>
                        <a href="{{ route('kerusakan.input') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('kerusakan/input') ? 'active' : '' }}">
                            <span class="micon bi bi-plus"></span><span class="mtext">Input Pekerjaan</span>
                        </a>
                        <a href="{{ route('kerusakan') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('kerusakan') ? 'active' : '' }}">
                            <span class="micon bi bi-lightbulb-off"></span><span class="mtext">Laporan
                                Kerusakan</span>
                        </a>
                        <a href="{{ route('kerusakan.update-status') }}"
                            class="dropdown-toggle no-arrow {{ request()->is('kerusakan/update-status*') ? 'active' : '' }}">
                            <span class="micon bi bi-pencil-square"></span><span class="mtext">Update
                                Pekerjaan</span>
                        </a>
                    </li>
                    <li class="dropdown">
                        <a href="javascript:;" class="dropdown-toggle">
                            <span class="micon bi bi-folder"></span><span class="mtext">Laporan</span>
                        </a>
                        <ul class="submenu">
                            <li>
                                <a href="{{ route('laporan.perbaikan-teknisi') }}"
                                    class="{{ request()->is('laporan/perbaikan-teknisi') ? 'active' : '' }}">Laporan
                                    Perbaikan</a>
                            </li>
                            <li>
                                <a href="{{ route('laporan.akhir-teknisi') }}"
                                    class="{{ request()->is('laporan/akhir-teknisi') ? 'active' : '' }}">Laporan
                                    Akhir</a>
                            </li>


                        </ul>
                    </li>
                @endif

                <li>
                    <a href="{{ url('/profile') }}"
                        class="dropdown-toggle no-arrow {{ request()->is('profile*') ? 'active' : '' }}">
                        <span class="micon bi bi-person-circle"></span><span class="mtext">Update Akun</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>
</div>
