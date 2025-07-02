<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SIPETA - Sistem Pariwisata Kabupaten Madiun</title>

    <!-- Google Font: Source Sans Pro -->
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-responsive/css/responsive.bootstrap4.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/datatables-buttons/css/buttons.bootstrap4.min.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- Leaflet Maps -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css" />
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>
    
    <style>
        /* SIPETA Custom Green Theme */
        :root {
            --primary-green: #28a745;
            --secondary-green: #20c997;
            --dark-green: #1e7e34;
            --light-green: #d4edda;
            --accent-green: #198754;
        }

        /* Sidebar Styling */
        .main-sidebar {
            background: linear-gradient(180deg, var(--primary-green) 0%, var(--dark-green) 100%) !important;
            box-shadow: 2px 0 10px rgba(0,0,0,0.1);
        }

        .brand-link {
            background: rgba(255,255,255,0.1) !important;
            border-bottom: 1px solid rgba(255,255,255,0.2) !important;
            transition: all 0.3s ease;
        }

        .brand-link:hover {
            background: rgba(255,255,255,0.2) !important;
        }

        .brand-text {
            color: white !important;
            font-weight: bold !important;
            font-size: 1.2rem !important;
        }

        .brand-image {
            border: 2px solid rgba(255,255,255,0.3);
        }

        /* Header/Navbar with Hamburger Menu */
        .main-header {
            background: white !important;
            border-bottom: 3px solid var(--primary-green) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
            z-index: 1050 !important;
        }

        .navbar {
            padding: 0.5rem 1rem;
        }

        .navbar-nav .nav-link {
            color: var(--primary-green) !important;
            font-weight: 500;
        }

        .navbar-nav .nav-link:hover {
            color: var(--dark-green) !important;
        }

        /* Hamburger Menu Button */
        .navbar-toggler {
            border: 2px solid var(--primary-green) !important;
            padding: 0.25rem 0.5rem !important;
            border-radius: 6px !important;
            background: transparent !important;
            color: var(--primary-green) !important;
        }

        .navbar-toggler:focus {
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .navbar-toggler-icon {
            background-image: none !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }

        .navbar-toggler-icon::before {
            content: '\f0c9';
            font-family: 'Font Awesome 5 Free';
            font-weight: 900;
            color: var(--primary-green);
            font-size: 1.2rem;
        }

        .navbar-toggler[aria-expanded="true"] .navbar-toggler-icon::before {
            content: '\f00d';
        }

        /* Mobile Sidebar */
        .sidebar-mini.sidebar-collapse .main-sidebar {
            width: 0 !important;
        }

        .sidebar-mini.sidebar-collapse .content-wrapper {
            margin-left: 0 !important;
        }

        /* Sidebar Menu */
        .nav-sidebar .nav-link {
            color: rgba(255,255,255,0.9) !important;
            border-radius: 8px !important;
            margin: 2px 4px !important;
            padding: 0.5rem 0.75rem !important;
            transition: all 0.3s ease !important;
        }

        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.2) !important;
            color: white !important;
            transform: translateX(3px);
        }

        .nav-sidebar .nav-link.active {
            background: var(--secondary-green) !important;
            color: white !important;
            box-shadow: 0 2px 10px rgba(32, 201, 151, 0.3);
        }

        .nav-sidebar .nav-icon {
            color: rgba(255,255,255,0.8) !important;
            margin-right: 8px !important;
            width: 16px !important;
            text-align: center !important;
            transition: color 0.3s ease !important;
        }

        .nav-sidebar .nav-link:hover .nav-icon {
            color: white !important;
        }

        /* Content Wrapper */
        .content-wrapper {
            background: #f8f9fa !important;
            min-height: calc(100vh - 57px);
            transition: margin-left 0.3s ease;
        }

        /* Content Area */
        .content {
            padding: 2rem 1rem !important;
        }

        /* Cards */
        .card {
            border: none !important;
            border-radius: 12px !important;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08) !important;
            margin-bottom: 1.5rem;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)) !important;
            color: white !important;
            border-radius: 12px 12px 0 0 !important;
            border: none !important;
            padding: 1rem 1.5rem !important;
        }

        .card-title {
            color: white !important;
            font-weight: 600 !important;
            margin: 0 !important;
        }

        /* Buttons */
        .btn-primary {
            background: linear-gradient(135deg, var(--primary-green), var(--secondary-green)) !important;
            border: none !important;
            border-radius: 8px !important;
            padding: 0.5rem 1.5rem !important;
            font-weight: 500 !important;
            transition: all 0.3s ease !important;
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--dark-green), var(--accent-green)) !important;
            transform: translateY(-2px) !important;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3) !important;
        }

        .btn-success {
            background: var(--secondary-green) !important;
            border: none !important;
            border-radius: 8px !important;
        }

        /* DataTable Styling */
        .dataTables_wrapper .dataTables_filter input {
            border-radius: 8px !important;
            border: 2px solid #e9ecef !important;
            padding: 0.5rem 1rem !important;
        }

        .dataTables_wrapper .dataTables_filter input:focus {
            border-color: var(--primary-green) !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .table th {
            background: var(--light-green) !important;
            color: var(--dark-green) !important;
            font-weight: 600 !important;
            border: none !important;
        }

        /* Footer */
        .main-footer {
            background: white !important;
            border-top: 2px solid var(--primary-green) !important;
            color: #6c757d !important;
            padding: 1rem !important;
        }

        .main-footer a {
            color: var(--primary-green) !important;
            font-weight: 600 !important;
        }

        /* User Panel (if needed) */
        .user-panel {
            border-bottom: 1px solid rgba(255,255,255,0.2) !important;
        }

        .user-panel .info a {
            color: white !important;
        }

        /* Custom animations */
        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .content {
            animation: slideIn 0.5s ease-out;
        }

        /* Professional hover effects */
        .nav-sidebar .nav-link:hover {
            background: rgba(255,255,255,0.15) !important;
            border-left: 3px solid var(--secondary-green);
            padding-left: calc(0.75rem - 3px);
        }

        .nav-sidebar .nav-link.active {
            border-left: 3px solid white;
            padding-left: calc(0.75rem - 3px);
        }

        /* Alert styling */
        .alert-success {
            background: var(--light-green) !important;
            border: 1px solid var(--secondary-green) !important;
            color: var(--dark-green) !important;
        }

        /* Form controls */
        .form-control:focus {
            border-color: var(--primary-green) !important;
            box-shadow: 0 0 0 0.2rem rgba(40, 167, 69, 0.25) !important;
        }

        .sidebar {
            padding: 0 !important;
        }

        .sidebar .nav {
            padding: 0 !important;
        }

        /* Professional navigation styling */
        .nav-sidebar .nav-item .nav-link p {
            font-weight: 500;
            letter-spacing: 0.025em;
        }

        /* Mobile Navigation Dropdown */
        .mobile-nav {
            display: none;
            background: var(--primary-green);
            padding: 1rem;
            border-radius: 8px;
            margin-top: 1rem;
        }

        .mobile-nav .nav-link {
            color: white !important;
            padding: 0.75rem 1rem !important;
            border-radius: 6px !important;
            margin-bottom: 0.25rem !important;
            display: flex !important;
            align-items: center !important;
            transition: all 0.3s ease !important;
        }

        .mobile-nav .nav-link:hover {
            background: rgba(255,255,255,0.2) !important;
            text-decoration: none !important;
        }

        .mobile-nav .nav-link.active {
            background: var(--secondary-green) !important;
        }

        .mobile-nav .nav-icon {
            margin-right: 0.75rem !important;
            width: 20px !important;
            text-align: center !important;
        }

        /* Breadcrumb in header */
        .navbar-breadcrumb {
            margin-left: auto;
            margin-right: 1rem;
        }

        .navbar-breadcrumb .breadcrumb {
            background: transparent !important;
            padding: 0 !important;
            margin: 0 !important;
        }

        .navbar-breadcrumb .breadcrumb-item {
            color: var(--primary-green) !important;
        }

        .navbar-breadcrumb .breadcrumb-item.active {
            color: var(--dark-green) !important;
            font-weight: 600 !important;
        }

        /* Responsive Layout Fixes */
        @media (max-width: 991.98px) {
            .main-sidebar {
                position: fixed !important;
                top: 0 !important;
                left: -250px !important;
                width: 250px !important;
                height: 100vh !important;
                z-index: 1060 !important;
                transition: left 0.3s ease !important;
            }

            .main-sidebar.sidebar-open {
                left: 0 !important;
            }

            .content-wrapper {
                margin-left: 0 !important;
            }

            .main-header {
                margin-left: 0 !important;
            }

            .main-footer {
                margin-left: 0 !important;
            }

            .content {
                padding: 1rem 0.5rem !important;
            }

            .navbar-brand {
                font-size: 1rem !important;
            }

            .card-header {
                padding: 0.75rem 1rem !important;
            }

            .card-title {
                font-size: 1.1rem !important;
            }

            /* Mobile navigation becomes visible */
            .mobile-nav {
                display: block;
            }

            /* Hide desktop sidebar controls on mobile */
            .sidebar-toggle {
                display: inline-block !important;
            }
        }

        @media (max-width: 576px) {
            .content {
                padding: 0.75rem 0.25rem !important;
            }
            
            .nav-sidebar .nav-link {
                margin: 2px 4px !important;
                padding: 0.4rem 0.6rem !important;
                font-size: 0.9rem !important;
            }

            .card {
                margin-bottom: 1rem !important;
            }

            .btn {
                padding: 0.375rem 1rem !important;
                font-size: 0.875rem !important;
            }

            .navbar {
                padding: 0.25rem 0.5rem !important;
            }

            .navbar-brand {
                font-size: 0.9rem !important;
            }

            .mobile-nav .nav-link {
                font-size: 0.9rem !important;
                padding: 0.6rem 0.8rem !important;
            }
        }

        /* Sidebar overlay for mobile */
        .sidebar-overlay {
            display: none;
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            z-index: 1055;
        }

        @media (max-width: 991.98px) {
            .sidebar-overlay.show {
                display: block;
            }
        }

        /* Enhanced mobile sidebar */
        @media (max-width: 991.98px) {
            .main-sidebar {
                box-shadow: 5px 0 15px rgba(0,0,0,0.3) !important;
            }

            .brand-link {
                padding: 1rem !important;
            }

            .brand-text {
                font-size: 1.1rem !important;
            }

            .nav-sidebar .nav-link {
                padding: 0.75rem 1rem !important;
                font-size: 0.95rem !important;
            }

            .nav-sidebar .nav-icon {
                width: 20px !important;
                margin-right: 12px !important;
            }
        }

        /* User info in navbar for mobile */
        .navbar-user-info {
            display: none;
            color: var(--primary-green) !important;
            font-weight: 500;
            margin-right: 1rem;
        }

        @media (max-width: 991.98px) {
            .navbar-user-info {
                display: inline-block;
            }
        }
    </style>
    
    @yield('script_top')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Sidebar Overlay for Mobile -->
        <div class="sidebar-overlay" id="sidebarOverlay"></div>

        <!-- Main Header/Navbar -->
        <nav class="main-header navbar navbar-expand-lg navbar-light">
            <div class="container-fluid">
                <!-- Sidebar Toggle for Mobile -->
                <button class="navbar-toggler sidebar-toggle d-lg-none" type="button" id="sidebarToggle">
                    <span class="navbar-toggler-icon"></span>
                </button>

                <!-- Brand -->
                <a class="navbar-brand d-lg-none" href="{{ route('dashboard.index') }}">
                    <img src="{{ asset('dist/img/logo_KabMadiun.gif') }}" alt="Logo" width="30" height="30" class="d-inline-block align-top mr-2">
                    <strong>SIPETA</strong>
                </a>

                <!-- User info for mobile -->
                <span class="navbar-user-info d-lg-none">
                    <i class="fas fa-user-circle mr-1"></i>
                    {{ auth()->user()->nama ?? 'User' }}
                </span>

                <!-- Breadcrumb for desktop -->
                <div class="navbar-breadcrumb d-none d-lg-block">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item">
                                <a href="{{ route('dashboard.index') }}">
                                    <i class="fas fa-home"></i> Dashboard
                                </a>
                            </li>
                            @if(!request()->routeIs('dashboard.*'))
                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ ucwords(str_replace('_', ' ', request()->route()->getName() ?? 'Page')) }}
                                </li>
                            @endif
                        </ol>
                    </nav>
                </div>

                <!-- Right navbar links -->
                <ul class="navbar-nav ml-auto">
                    <li class="nav-item d-none d-lg-block">
                        <span class="nav-link">
                            <i class="fas fa-user-circle mr-1"></i>
                            {{ auth()->user()->nama ?? 'User' }}
                        </span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{ route('logout') }}" title="Keluar">
                            <i class="fas fa-sign-out-alt"></i>
                            <span class="d-none d-sm-inline ml-1">Keluar</span>
                        </a>
                    </li>
                </ul>
            </div>
        </nav>

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4" id="mainSidebar">
            <!-- Brand Logo -->
            <a href="{{ route('dashboard.index') }}" class="brand-link">
                <img src="{{ asset('dist/img/logo_KabMadiun.gif') }}" alt="Logo SIPETA" class="brand-image img-circle elevation-2">
                <span class="brand-text">SIPETA</span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <!-- Sidebar Menu -->
                <nav class="mt-3">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                        @if (auth()->user()->tipeuser->id == 1)
                        <li class="nav-item">
                            <a href="{{ route('dashboard.index') }}" class="nav-link {{ request()->routeIs('dashboard.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link {{ request()->routeIs('user.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-users"></i> 
                                <p>Kelola Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tenant.index') }}" class="nav-link {{ request()->routeIs('tenant.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-map-marked-alt"></i> 
                                <p>Kelola Destinasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tenant_report.index') }}" class="nav-link {{ request()->routeIs('tenant_report.*') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-chart-bar"></i>  
                                <p>Laporan Booking</p>
                            </a>
                        </li>
                        @endif
                        
                        @if (auth()->user()->tipeuser->id == 2)
                        <li class="nav-item">
                            <a href="{{ route('user_tenant_booking.index') }}" class="nav-link {{ request()->routeIs('user_tenant_booking.index') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-calendar-check"></i> 
                                <p>Kelola Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user_tenant_booking.scan') }}" class="nav-link {{ request()->routeIs('user_tenant_booking.scan') ? 'active' : '' }}">
                                <i class="nav-icon fas fa-qrcode"></i>  
                                <p>Scan QR Code</p>
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item mt-3">
                            <a href="{{ route('user.edit', auth()->user()->id) }}" class="nav-link {{ request()->routeIs('user.edit') && request()->route('user') == auth()->user()->id ? 'active' : '' }}">
                                <i class="nav-icon fas fa-user-cog"></i> 
                                <p>Pengaturan Akun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('logout') }}" class="nav-link">
                                <i class="nav-icon fas fa-sign-out-alt"></i> 
                                <p>Keluar</p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
        </aside>

        <!-- Content Wrapper -->
        <div class="content-wrapper">
            <!-- Main content -->
            <div class="content">
                <div class="container-fluid">
                    @yield('content')
                </div>
            </div>
        </div>

        <!-- Main Footer -->
        <footer class="main-footer">
            <div class="row">
                <div class="col-md-6">
                    <strong>Copyright &copy; 2025 <a href="{{ route('dashboard.index') }}">SIPETA</a>.</strong> 
                    <span class="d-none d-sm-inline">Sistem Pariwisata Kabupaten Madiun.</span>
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">
                        <i class="fas fa-leaf mr-1"></i>
                        <span class="d-none d-sm-inline">Dinas Pariwisata</span>
                        <span class="d-sm-none">Disparta</span>
                        Kabupaten Madiun
                    </small>
                </div>
            </div>
        </footer>
    </div>

    <!-- REQUIRED SCRIPTS -->
    <!-- jQuery -->
    <script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
    <!-- Bootstrap 4 -->
    <script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
    <!-- DataTables & Plugins -->
    <script src="{{ asset('plugins/datatables/jquery.dataTables.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/dataTables.responsive.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-responsive/js/responsive.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/dataTables.buttons.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.bootstrap4.min.js') }}"></script>
    <script src="{{ asset('plugins/jszip/jszip.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/pdfmake.min.js') }}"></script>
    <script src="{{ asset('plugins/pdfmake/vfs_fonts.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.html5.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.print.min.js') }}"></script>
    <script src="{{ asset('plugins/datatables-buttons/js/buttons.colVis.min.js') }}"></script>
    <!-- AdminLTE App -->
    <script src="{{ asset('dist/js/adminlte.min.js') }}"></script>
    
    <script>
        $(function() {
            // DataTables initialization with custom styling
            $("#example1").DataTable({
                "responsive": true,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": true,
                "pageLength": 25,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });
            
            $('#example2').DataTable({
                "paging": true,
                "lengthChange": false,
                "searching": true,
                "ordering": true,
                "info": true,
                "autoWidth": false,
                "responsive": true,
                "pageLength": 15,
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Selanjutnya",
                        "previous": "Sebelumnya"
                    }
                }
            });

            // Professional hover effects (no spinning icons)
            $('.nav-sidebar .nav-link').hover(
                function() {
                    // Subtle scale effect on icon instead of spinning
                    $(this).find('.nav-icon').css('transform', 'scale(1.1)');
                },
                function() {
                    $(this).find('.nav-icon').css('transform', 'scale(1)');
                }
            );

            // Mobile Sidebar Toggle
            $('#sidebarToggle').on('click', function(e) {
                e.preventDefault();
                $('#mainSidebar').toggleClass('sidebar-open');
                $('#sidebarOverlay').toggleClass('show');
                $('body').toggleClass('sidebar-open');
            });

            // Close sidebar when clicking overlay
            $('#sidebarOverlay').on('click', function() {
                $('#mainSidebar').removeClass('sidebar-open');
                $('#sidebarOverlay').removeClass('show');
                $('body').removeClass('sidebar-open');
            });

            // Close sidebar when clicking any nav link on mobile
            $('.nav-sidebar .nav-link').on('click', function() {
                if ($(window).width() <= 991.98) {
                    $('#mainSidebar').removeClass('sidebar-open');
                    $('#sidebarOverlay').removeClass('show');
                    $('body').removeClass('sidebar-open');
                }
            });

            // Handle window resize
            $(window).on('resize', function() {
                if ($(window).width() > 991.98) {
                    $('#mainSidebar').removeClass('sidebar-open');
                    $('#sidebarOverlay').removeClass('show');
                    $('body').removeClass('sidebar-open');
                }
            });

            // Auto-hide alerts after 5 seconds
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // Smooth scroll for anchor links
            $('a[href^="#"]').on('click', function(event) {
                var target = $(this.getAttribute('href'));
                if( target.length ) {
                    event.preventDefault();
                    $('html, body').stop().animate({
                        scrollTop: target.offset().top - 70
                    }, 500);
                }
            });

            // Enhanced table responsiveness
            $('.table-responsive').on('shown.bs.modal', function () {
                $($.fn.dataTable.tables(true)).DataTable().columns.adjust();
            });

            // Toast notifications for better UX
            if (typeof toastr !== 'undefined') {
                toastr.options = {
                    "closeButton": true,
                    "debug": false,
                    "newestOnTop": true,
                    "progressBar": true,
                    "positionClass": "toast-top-right",
                    "preventDuplicates": false,
                    "onclick": null,
                    "showDuration": "300",
                    "hideDuration": "1000",
                    "timeOut": "5000",
                    "extendedTimeOut": "1000",
                    "showEasing": "swing",
                    "hideEasing": "linear",
                    "showMethod": "fadeIn",
                    "hideMethod": "fadeOut"
                };
            }

            // Loading state for buttons
            $('form').on('submit', function() {
                var $submitBtn = $(this).find('button[type="submit"]');
                var originalText = $submitBtn.html();
                $submitBtn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);
                
                // Reset button after 10 seconds (failsafe)
                setTimeout(function() {
                    $submitBtn.html(originalText).prop('disabled', false);
                }, 10000);
            });

            // Confirm dialogs for delete actions
            $('button[onclick*="delete"], a[onclick*="delete"]').on('click', function(e) {
                e.preventDefault();
                var action = $(this).attr('onclick');
                if (confirm('Apakah Anda yakin ingin menghapus data ini? Aksi ini tidak dapat dibatalkan.')) {
                    eval(action);
                }
            });

            // Enhanced dropdown menus
            $('.dropdown-toggle').dropdown();

            // Auto-focus on modal inputs
            $('.modal').on('shown.bs.modal', function () {
                $(this).find('input[type="text"], input[type="email"], textarea').first().focus();
            });

            // Form validation enhancement
            $('form').on('submit', function(e) {
                var hasError = false;
                $(this).find('input[required], select[required], textarea[required]').each(function() {
                    if (!$(this).val()) {
                        hasError = true;
                        $(this).addClass('is-invalid');
                    } else {
                        $(this).removeClass('is-invalid');
                    }
                });
                
                if (hasError) {
                    e.preventDefault();
                    var firstError = $(this).find('.is-invalid').first();
                    $('html, body').animate({
                        scrollTop: firstError.offset().top - 100
                    }, 500);
                    firstError.focus();
                }
            });

            // Clear validation errors on input
            $('input, select, textarea').on('input change', function() {
                $(this).removeClass('is-invalid');
            });

            // Back to top button
            var backToTop = $('<button type="button" class="btn btn-primary btn-back-to-top" title="Kembali ke atas"><i class="fas fa-chevron-up"></i></button>');
            $('body').append(backToTop);
            
            $(window).scroll(function () {
                if ($(this).scrollTop() > 100) {
                    $('.btn-back-to-top').fadeIn();
                } else {
                    $('.btn-back-to-top').fadeOut();
                }
            });

            $('.btn-back-to-top').click(function () {
                $('html, body').animate({scrollTop: 0}, 500);
                return false;
            });

            // Enhanced search functionality
            $('[data-search]').on('keyup', function() {
                var searchTerm = $(this).val().toLowerCase();
                var target = $(this).data('search');
                
                $(target + ' tbody tr').each(function() {
                    var text = $(this).text().toLowerCase();
                    if (text.indexOf(searchTerm) === -1) {
                        $(this).hide();
                    } else {
                        $(this).show();
                    }
                });
            });

            // Print functionality
            $('[data-print]').on('click', function(e) {
                e.preventDefault();
                var target = $(this).data('print');
                var printContent = $(target).html();
                var originalContent = $('body').html();
                
                $('body').html('<div class="print-content">' + printContent + '</div>');
                window.print();
                $('body').html(originalContent);
                location.reload();
            });
        });

        // Additional utility functions
        function showLoading() {
            $('body').append('<div class="loading-overlay"><div class="spinner-border text-primary" role="status"><span class="sr-only">Loading...</span></div></div>');
        }

        function hideLoading() {
            $('.loading-overlay').remove();
        }

        function showNotification(message, type = 'success') {
            var alertClass = 'alert-' + type;
            var icon = type === 'success' ? 'check' : (type === 'danger' ? 'times' : 'info');
            
            var notification = `
                <div class="alert ${alertClass} alert-dismissible fade show notification-alert" role="alert">
                    <i class="fas fa-${icon} mr-2"></i>
                    ${message}
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
            `;
            
            $('.content').prepend(notification);
            
            setTimeout(function() {
                $('.notification-alert').fadeOut();
            }, 5000);
        }
    </script>

    <style>
        /* Additional responsive styles */
        .btn-back-to-top {
            position: fixed;
            bottom: 20px;
            right: 20px;
            z-index: 1000;
            display: none;
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(40, 167, 69, 0.3);
        }

        .loading-overlay {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.5);
            display: flex;
            justify-content: center;
            align-items: center;
            z-index: 9999;
        }

        .notification-alert {
            position: fixed;
            top: 20px;
            right: 20px;
            z-index: 1050;
            min-width: 300px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
        }

        /* Enhanced mobile styles */
        @media (max-width: 575.98px) {
            .btn-back-to-top {
                bottom: 15px;
                right: 15px;
                width: 45px;
                height: 45px;
            }

            .notification-alert {
                top: 10px;
                right: 10px;
                left: 10px;
                min-width: auto;
            }

            .main-footer {
                padding: 0.5rem !important;
                font-size: 0.85rem !important;
            }

            .main-footer .row [class*="col-"] {
                margin-bottom: 0.5rem;
            }

            .table-responsive {
                font-size: 0.85rem;
            }

            .card-header {
                padding: 0.5rem 0.75rem !important;
            }

            .card-body {
                padding: 0.75rem !important;
            }

            .btn-group .btn {
                padding: 0.25rem 0.5rem !important;
                font-size: 0.8rem !important;
            }

            .modal-dialog {
                margin: 0.5rem !important;
            }

            .modal-body {
                padding: 1rem 0.75rem !important;
            }

            .form-group {
                margin-bottom: 0.75rem !important;
            }

            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                margin-bottom: 0.5rem !important;
            }
        }

        /* Print styles */
        @media print {
            .main-sidebar,
            .main-header,
            .main-footer,
            .btn,
            .pagination,
            .dataTables_wrapper .dataTables_length,
            .dataTables_wrapper .dataTables_filter,
            .dataTables_wrapper .dataTables_info,
            .dataTables_wrapper .dataTables_paginate {
                display: none !important;
            }

            .content-wrapper {
                margin-left: 0 !important;
                padding: 0 !important;
            }

            .content {
                padding: 0 !important;
            }

            .card {
                box-shadow: none !important;
                border: 1px solid #dee2e6 !important;
            }

            .table {
                font-size: 12px !important;
            }

            .table th,
            .table td {
                padding: 0.3rem !important;
            }
        }

        /* High contrast mode support */
        @media (prefers-contrast: high) {
            .main-sidebar {
                background: #000 !important;
                border-right: 2px solid #fff !important;
            }

            .nav-sidebar .nav-link {
                color: #fff !important;
                border: 1px solid transparent !important;
            }

            .nav-sidebar .nav-link:hover,
            .nav-sidebar .nav-link.active {
                background: #fff !important;
                color: #000 !important;
                border: 1px solid #fff !important;
            }
        }

        /* Focus styles for accessibility */
        .nav-sidebar .nav-link:focus,
        .btn:focus,
        .form-control:focus,
        .custom-control-input:focus ~ .custom-control-label::before {
            outline: 2px solid var(--primary-green) !important;
            outline-offset: 2px !important;
        }

        /* Reduced motion support */
        @media (prefers-reduced-motion: reduce) {
            *,
            *::before,
            *::after {
                animation-duration: 0.01ms !important;
                animation-iteration-count: 1 !important;
                transition-duration: 0.01ms !important;
            }
        }
    </style>
    
    @yield('script')
</body>
</html>