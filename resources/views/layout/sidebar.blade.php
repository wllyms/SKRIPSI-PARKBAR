<!-- SIDEBAR -->
<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center bg-gradient-primary" href="#">
        <div class="sidebar-brand-icon">
            <img src="{{ asset('tempe1/img/logo/logo2.png') }}">
        </div>
        <div class="sidebar-brand-text mx-3">ParkBar</div>
    </a>
    <hr class="sidebar-divider my-0">
    <li class="nav-item active">
        <a class="nav-link" href="/beranda">
            <i class="fas fa-warehouse"></i>
            <span>Dashboard</span></a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Data Master
    </div>
    <li class="nav-item">
        <a class="nav-link" href="/kategori">
            <i class="fa fa-car"></i>
            <span>Kategori Kendaraan</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/staff">
            <i class="fa fa-user"></i>
            <span>Staff</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/jenispegawai">
            <i class="fa fa-users"></i>
            <span>Jenis Pegawai</span>
        </a>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        PARKING
    </div>
    <li class="nav-item">
        <a class="nav-link" href="/user">
            <i class="fas fa-user-alt"></i>
            <span>User</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/tarif">
            <i class="fas fa-money-bill-wave fa-chart-area"></i>
            <span>Tarif Parkir</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link" href="/pegawai">
            <i class="fas fa-users"></i>
            <span>Pegawai</span>
        </a>
    </li>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsParkir"
            aria-expanded="true" aria-controls="collapsParkir">
            <i class="fas fa-car"></i>
            <span>Manajemen Parkir</span>
        </a>
        <div id="collapsParkir" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/parkirbiasa">Parkir Biasa</a>
                <a class="collapse-item" href="/parkir-keluar">Scan Keluar</a>
                <a class="collapse-item" href="/scan-pegawai">Parkir Member</a>
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        REPORT
    </div>
    <li class="nav-item">
        <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapsLaporan"
            aria-expanded="true" aria-controls="collapsLaporan">
            <i class="fas fa-fw fa-columns"></i>
            <span>Manajemen Laporan</span>
        </a>
        <div id="collapsLaporan" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
            <div class="bg-white py-2 collapse-inner rounded">
                <a class="collapse-item" href="/laporanparkir">Parkir</a>
                <a class="collapse-item" href="/laporan/pegawai">Pegawai</a>
                <a class="collapse-item" href="/laporan/parkirpegawai">Parkir Pegawai</a>
                <a class="collapse-item" href="/laporan-pendapatan">Pendapatan</a>
                {{-- <a class="collapse-item" href="register.html">Laporan Pendapatan</a> --}}
            </div>
        </div>
    </li>
    <hr class="sidebar-divider">
    <div class="version" id="version-ruangadmin"></div>
</ul>
<!-- END SIDEBAR -->


<div id="content-wrapper" class="d-flex flex-column">
    <div id="content">

        <!-- NAVBAR -->

        <!-- Logout Modal-->
        <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="logoutModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="logoutModalLabel">Apakah Anda yakin ingin logout?</h5>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body">Klik logout untuk mengakhiri sesi Anda.</div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Batal</button>
                        <form action="{{ route('logout') }}" method="POST" class="d-inline">
                            @csrf
                            <button class="btn btn-primary" type="submit">Logout</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <nav class="navbar navbar-expand navbar-light bg-navbar topbar mb-4 static-top bg-gradient-primary">
            <button id="sidebarToggleTop" class="btn btn-link rounded-circle mr-3">
                <i class="fa fa-bars"></i>
            </button>
            <ul class="navbar-nav ml-auto">
                <li class="nav-item dropdown no-arrow">
                    <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button"
                        data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <img class="img-profile rounded-circle" src="{{ asset('tempe1/img/boy.png') }}"
                            style="max-width: 60px">
                        <span class="ml-2 d-none d-lg-inline text-white small">{{ Auth::user()->staff->nama }}</span>
                    </a>
                    <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in"
                        aria-labelledby="userDropdown">
                        <div class="dropdown-divider"></div>
                        <a class="dropdown-item" href="javascript:void(0);" data-toggle="modal"
                            data-target="#logoutModal">
                            <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                            Logout
                        </a>
                    </div>
                </li>
            </ul>
        </nav>
        <!-- END NAVBAR -->
