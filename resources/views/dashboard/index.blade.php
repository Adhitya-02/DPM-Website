@extends('layout')
@section('content')
<style>
    .dashboard-card {
        border: none;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        transition: all 0.3s ease;
        overflow: hidden;
        margin-bottom: 1.5rem;
    }

    .dashboard-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 30px rgba(0,0,0,0.15);
    }

    .card-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.5rem;
        color: white;
        margin-bottom: 1rem;
    }

    .card-number {
        font-size: 2.5rem;
        font-weight: bold;
        margin: 0;
        line-height: 1;
    }

    .card-title {
        font-size: 0.9rem;
        color: #6c757d;
        margin: 0;
        margin-top: 0.5rem;
    }

    .card-change {
        font-size: 0.8rem;
        margin-top: 0.5rem;
    }

    .card-change.positive {
        color: #28a745;
    }

    .card-change.negative {
        color: #dc3545;
    }

    .bg-primary-gradient {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    .bg-success-gradient {
        background: linear-gradient(135deg, #28a745 0%, #20c997 100%);
    }

    .bg-warning-gradient {
        background: linear-gradient(135deg, #ffc107 0%, #fd7e14 100%);
    }

    .bg-danger-gradient {
        background: linear-gradient(135deg, #dc3545 0%, #e83e8c 100%);
    }

    .bg-info-gradient {
        background: linear-gradient(135deg, #17a2b8 0%, #6f42c1 100%);
    }

    .bg-secondary-gradient {
        background: linear-gradient(135deg, #6c757d 0%, #495057 100%);
    }

    .chart-container {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 1.5rem;
        margin-bottom: 1.5rem;
    }

    .recent-activities {
        max-height: 400px;
        overflow-y: auto;
    }

    .activity-item {
        padding: 0.75rem;
        border-bottom: 1px solid #f8f9fa;
        display: flex;
        align-items: center;
    }

    .activity-item:last-child {
        border-bottom: none;
    }

    .activity-icon {
        width: 40px;
        height: 40px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin-right: 1rem;
        font-size: 0.9rem;
    }

    .top-destinations {
        background: white;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0,0,0,0.08);
        padding: 1.5rem;
    }

    .destination-item {
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0.75rem 0;
        border-bottom: 1px solid #f8f9fa;
    }

    .destination-item:last-child {
        border-bottom: none;
    }

    .progress-sm {
        height: 8px;
        border-radius: 4px;
    }

    .welcome-card {
        background: linear-gradient(135deg, var(--primary-green), var(--secondary-green));
        color: white;
        border-radius: 15px;
        padding: 2rem;
        margin-bottom: 2rem;
    }

    .stats-row {
        margin-bottom: 2rem;
    }

    @media (max-width: 768px) {
        .card-number {
            font-size: 2rem;
        }
        
        .card-icon {
            width: 50px;
            height: 50px;
            font-size: 1.2rem;
        }
    }
</style>

<!-- Welcome Section -->
<div class="welcome-card">
    <div class="row align-items-center">
        <div class="col-md-8">
            <h2><i class="fas fa-tachometer-alt mr-3"></i>Dashboard SIPETA</h2>
            <p class="mb-0">Selamat datang, <strong>{{ auth()->user()->nama ?? 'Administrator' }}</strong>! Berikut adalah ringkasan data sistem pariwisata Kabupaten Madiun.</p>
        </div>
        <div class="col-md-4 text-right">
            <h6 class="mb-1">{{ \Carbon\Carbon::now()->format('l, d F Y') }}</h6>
            <p class="mb-0">{{ \Carbon\Carbon::now()->format('H:i') }} WIB</p>
        </div>
    </div>
</div>

<!-- Statistics Cards -->
<div class="stats-row">
    <div class="row">
        <!-- Total Users -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="card-icon bg-primary-gradient mx-auto">
                        <i class="fas fa-users"></i>
                    </div>
                    <h3 class="card-number text-primary">{{ \App\Models\User::count() }}</h3>
                    <p class="card-title">Total Pengguna</p>
                    <p class="card-change positive">
                        <i class="fas fa-arrow-up"></i> +12% bulan ini
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Admins -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="card-icon bg-secondary-gradient mx-auto">
                        <i class="fas fa-user-shield"></i>
                    </div>
                    <h3 class="card-number text-secondary">{{ \App\Models\User::where('tipe_user_id', 1)->count() }}</h3>
                    <p class="card-title">Administrator</p>
                    <p class="card-change">
                        <i class="fas fa-minus"></i> Tidak berubah
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Destinations -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="card-icon bg-success-gradient mx-auto">
                        <i class="fas fa-map-marked-alt"></i>
                    </div>
                    <h3 class="card-number text-success">{{ \App\Models\Tenant::count() }}</h3>
                    <p class="card-title">Total Destinasi</p>
                    <p class="card-change positive">
                        <i class="fas fa-arrow-up"></i> +{{ \App\Models\Tenant::whereMonth('created_at', now()->month)->count() }} baru
                    </p>
                </div>
            </div>
        </div>

        <!-- Total Bookings -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="card-icon bg-info-gradient mx-auto">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3 class="card-number text-info">{{ \App\Models\UserTenantBooking::count() }}</h3>
                    <p class="card-title">Total Booking</p>
                    <p class="card-change positive">
                        <i class="fas fa-arrow-up"></i> +{{ \App\Models\UserTenantBooking::whereDate('tanggal', today())->count() }} hari ini
                    </p>
                </div>
            </div>
        </div>

        <!-- Paid Transactions -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="card-icon bg-success-gradient mx-auto">
                        <i class="fas fa-check-circle"></i>
                    </div>
                    <h3 class="card-number text-success">{{ \App\Models\UserTenantBooking::where('status_pembayaran', 1)->count() }}</h3>
                    <p class="card-title">Sudah Terbayar</p>
                    <p class="card-change positive">
                        <i class="fas fa-arrow-up"></i> {{ number_format((\App\Models\UserTenantBooking::where('status_pembayaran', 1)->count() / max(\App\Models\UserTenantBooking::count(), 1)) * 100, 1) }}%
                    </p>
                </div>
            </div>
        </div>

        <!-- Unpaid Transactions -->
        <div class="col-xl-2 col-md-4 col-sm-6 mb-3">
            <div class="card dashboard-card">
                <div class="card-body text-center">
                    <div class="card-icon bg-warning-gradient mx-auto">
                        <i class="fas fa-clock"></i>
                    </div>
                    <h3 class="card-number text-warning">{{ \App\Models\UserTenantBooking::where('status_pembayaran', 0)->count() }}</h3>
                    <p class="card-title">Belum Terbayar</p>
                    <p class="card-change negative">
                        <i class="fas fa-exclamation-triangle"></i> Perlu tindakan
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Revenue and Charts Section -->
<div class="row mb-4">
    <!-- Total Revenue -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="card-icon bg-success-gradient mx-auto">
                    <i class="fas fa-money-bill-wave"></i>
                </div>
                <h3 class="card-number text-success">
                    Rp {{ number_format(\DB::table('user_tenant_booking')->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')->where('user_tenant_booking.status_pembayaran', 1)->sum(\DB::raw('user_tenant_booking.jumlah * tenant.harga')), 0, ',', '.') }}
                </h3>
                <p class="card-title">Total Pendapatan</p>
                <p class="card-change positive">
                    <i class="fas fa-arrow-up"></i> +15% dari bulan lalu
                </p>
            </div>
        </div>
    </div>

    <!-- Monthly Revenue -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="card-icon bg-info-gradient mx-auto">
                    <i class="fas fa-chart-line"></i>
                </div>
                <h3 class="card-number text-info">
                    Rp {{ number_format(\DB::table('user_tenant_booking')->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')->where('user_tenant_booking.status_pembayaran', 1)->whereMonth('user_tenant_booking.tanggal', now()->month)->sum(\DB::raw('user_tenant_booking.jumlah * tenant.harga')), 0, ',', '.') }}
                </h3>
                <p class="card-title">Pendapatan Bulan Ini</p>
                <p class="card-change positive">
                    <i class="fas fa-arrow-up"></i> Target 80% tercapai
                </p>
            </div>
        </div>
    </div>

    <!-- Average Transaction -->
    <div class="col-md-4">
        <div class="card dashboard-card">
            <div class="card-body text-center">
                <div class="card-icon bg-warning-gradient mx-auto">
                    <i class="fas fa-receipt"></i>
                </div>
                @php
                    $totalRevenue = \DB::table('user_tenant_booking')->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')->where('user_tenant_booking.status_pembayaran', 1)->sum(\DB::raw('user_tenant_booking.jumlah * tenant.harga'));
                    $totalTransactions = \App\Models\UserTenantBooking::where('status_pembayaran', 1)->count();
                    $avgTransaction = $totalTransactions > 0 ? $totalRevenue / $totalTransactions : 0;
                @endphp
                <h3 class="card-number text-warning">
                    Rp {{ number_format($avgTransaction, 0, ',', '.') }}
                </h3>
                <p class="card-title">Rata-rata Transaksi</p>
                <p class="card-change">
                    <i class="fas fa-calculator"></i> Per booking
                </p>
            </div>
        </div>
    </div>
</div>

<!-- Charts and Activities Section -->
<div class="row">
    <!-- Recent Activities -->
    <div class="col-md-6">
        <div class="chart-container">
            <h5><i class="fas fa-history mr-2"></i>Aktivitas Terbaru</h5>
            <div class="recent-activities">
                @php
                    $recentBookings = \App\Models\UserTenantBooking::with(['user', 'tenant'])->orderBy('id', 'desc')->take(8)->get();
                @endphp
                @forelse($recentBookings as $booking)
                <div class="activity-item">
                    <div class="activity-icon bg-{{ $booking->status_pembayaran ? 'success' : 'warning' }}">
                        <i class="fas fa-{{ $booking->status_pembayaran ? 'check' : 'clock' }}"></i>
                    </div>
                    <div class="flex-grow-1">
                        <strong>{{ $booking->user->nama ?? 'User' }}</strong> 
                        booking {{ $booking->tenant->nama ?? 'Destinasi' }}
                        <br>
                        <small class="text-muted">
                            {{ $booking->jumlah }} tiket - 
                            Rp {{ number_format($booking->jumlah * ($booking->tenant->harga ?? 0), 0, ',', '.') }}
                            <span class="badge badge-{{ $booking->status_pembayaran ? 'success' : 'warning' }}">
                                {{ $booking->status_pembayaran ? 'Lunas' : 'Pending' }}
                            </span>
                        </small>
                    </div>
                    <small class="text-muted">{{ \Carbon\Carbon::parse($booking->tanggal)->diffForHumans() }}</small>
                </div>
                @empty
                <div class="text-center py-4">
                    <i class="fas fa-inbox fa-3x text-muted mb-3"></i>
                    <p class="text-muted">Belum ada aktivitas booking</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Top Destinations -->
    <div class="col-md-6">
        <div class="top-destinations">
            <h5><i class="fas fa-star mr-2"></i>Destinasi Terpopuler</h5>
            @php
                $topDestinations = \DB::table('user_tenant_booking')
                    ->join('tenant', 'tenant.id', '=', 'user_tenant_booking.tenant_id')
                    ->select('tenant.nama', \DB::raw('SUM(user_tenant_booking.jumlah) as total_visitors'), \DB::raw('COUNT(user_tenant_booking.id) as total_bookings'))
                    ->groupBy('tenant.id', 'tenant.nama')
                    ->orderBy('total_visitors', 'desc')
                    ->take(5)
                    ->get();
                $maxVisitors = $topDestinations->max('total_visitors') ?: 1;
            @endphp
            @forelse($topDestinations as $destination)
            <div class="destination-item">
                <div>
                    <strong>{{ $destination->nama }}</strong>
                    <br>
                    <small class="text-muted">{{ $destination->total_visitors }} pengunjung, {{ $destination->total_bookings }} booking</small>
                </div>
                <div style="width: 100px;">
                    <div class="progress progress-sm">
                        <div class="progress-bar bg-success" style="width: {{ ($destination->total_visitors / $maxVisitors) * 100 }}%"></div>
                    </div>
                </div>
            </div>
            @empty
            <div class="text-center py-4">
                <i class="fas fa-map-marked-alt fa-3x text-muted mb-3"></i>
                <p class="text-muted">Belum ada data destinasi</p>
            </div>
            @endforelse
        </div>
    </div>
</div>

<script>
    // Auto refresh dashboard setiap 5 menit
    setTimeout(function() {
        location.reload();
    }, 300000); // 5 minutes

    // Add loading effect to cards
    $('.dashboard-card').on('click', function() {
        $(this).addClass('loading');
        setTimeout(() => {
            $(this).removeClass('loading');
        }, 1000);
    });
</script>
@endsection