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
            transform: translateX(5px);
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
        }

        /* Content Wrapper */
        .content-wrapper {
            background: #f8f9fa !important;
            min-height: calc(100vh - 57px);
        }

        /* Header/Navbar */
        .main-header {
            background: white !important;
            border-bottom: 3px solid var(--primary-green) !important;
            box-shadow: 0 2px 10px rgba(0,0,0,0.08);
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

        /* Responsive adjustments */
        @media (max-width: 768px) {
            .content {
                padding: 1rem 0.5rem !important;
            }
            
            .nav-sidebar .nav-link {
                margin: 2px 4px !important;
                padding: 0.4rem 0.6rem !important;
            }
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
    </style>
    
    @yield('script_top')
</head>

<body class="hold-transition sidebar-mini">
    <div class="wrapper">
        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4">
            <!-- Brand Logo -->
            <a href="#" class="brand-link">
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
                            <a href="#" class="nav-link">
                                <i class="nav-icon fas fa-tachometer-alt"></i>
                                <p>Dashboard</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('user.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-users"></i> 
                                <p>Kelola Pengguna</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{ route('tenant.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-map-marked-alt"></i> 
                                <p>Kelola Destinasi</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('tenant_report.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-chart-bar"></i>  
                                <p>Laporan Booking</p>
                            </a>
                        </li>
                        @endif
                        
                        @if (auth()->user()->tipeuser->id == 2)
                        <li class="nav-item">
                            <a href="{{route('user_tenant_booking.index') }}" class="nav-link">
                                <i class="nav-icon fas fa-calendar-check"></i> 
                                <p>Kelola Booking</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('user_tenant_booking.scan') }}" class="nav-link">
                                <i class="nav-icon fas fa-qrcode"></i>  
                                <p>Scan QR Code</p>
                            </a>
                        </li>
                        @endif
                        
                        <li class="nav-item mt-3">
                            <a href="{{route('user.edit', auth()->user()->id) }}" class="nav-link">
                                <i class="nav-icon fas fa-user-cog"></i> 
                                <p>Pengaturan Akun</p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="{{route('logout')}}" class="nav-link">
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
                    <strong>Copyright &copy; 2025 <a href="#">SIPETA</a>.</strong> 
                    Sistem Pariwisata Kabupaten Madiun.
                </div>
                <div class="col-md-6 text-right">
                    <small class="text-muted">
                        <i class="fas fa-leaf mr-1"></i>
                        Dinas Pariwisata Kabupaten Madiun
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
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)"
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
                "language": {
                    "search": "Cari:",
                    "lengthMenu": "Tampilkan _MENU_ data per halaman",
                    "zeroRecords": "Data tidak ditemukan",
                    "info": "Menampilkan halaman _PAGE_ dari _PAGES_",
                    "infoEmpty": "Tidak ada data tersedia",
                    "infoFiltered": "(difilter dari _MAX_ total data)"
                }
            });

            // Active menu highlighting
            const currentUrl = window.location.href;
            $('.nav-sidebar .nav-link').each(function() {
                if ($(this).attr('href') === currentUrl) {
                    $(this).addClass('active');
                }
            });

            // Smooth transitions for sidebar
            $('.nav-sidebar .nav-link').hover(
                function() {
                    $(this).find('.nav-icon').addClass('fa-spin');
                },
                function() {
                    $(this).find('.nav-icon').removeClass('fa-spin');
                }
            );
        });
    </script>
    
    @yield('script')
</body>
</html>