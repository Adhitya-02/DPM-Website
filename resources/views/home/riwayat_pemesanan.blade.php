<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            background-color: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 40px 20px;
            margin-bottom: 30px;
            position: relative;
            overflow: hidden;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1000 100" fill="white" opacity="0.1"><polygon points="0,0 0,100 1000,100"/></svg>');
            background-size: cover;
        }

        .hero-content {
            max-width: 1200px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 20px;
        }

        .header {
            text-align: center;
            font-size: 42px;
            font-weight: 700;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .menu-booking {
            display: flex;
            gap: 15px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .menu-tab {
            background: rgba(255,255,255,0.2);
            border: 2px solid rgba(255,255,255,0.3);
            color: white;
            padding: 12px 24px;
            border-radius: 25px;
            text-decoration: none;
            font-weight: 500;
            transition: all 0.3s ease;
            font-size: 16px;
            display: flex;
            align-items: center;
            gap: 8px;
            cursor: pointer;
            min-width: 200px;
            justify-content: center;
        }

        .menu-tab:hover, .menu-tab.active {
            background: rgba(255,255,255,0.9);
            color: #667eea;
            border-color: rgba(255,255,255,0.9);
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(0,0,0,0.2);
        }

        .main-container {
            flex: 1;
            display: flex;
            justify-content: center;
            align-items: flex-start;
            padding: 20px;
            min-height: calc(100vh - 400px);
        }

        .content-wrapper {
            width: 100%;
            max-width: 1000px;
            display: flex;
            justify-content: center;
        }

        .content-area {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 16px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 800px;
        }

        .booking-header {
            margin-bottom: 25px;
            text-align: center;
        }

        .booking-header h3 {
            color: #2c3e50;
            font-size: 24px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .booking-header p {
            color: #6c757d;
            font-size: 14px;
            max-width: 500px;
            margin: 0 auto;
        }

        .orders-grid {
            display: flex;
            flex-direction: column;
            gap: 15px;
            align-items: center;
        }

        .order-card {
            background: white;
            border-radius: 12px;
            padding: 20px;
            box-shadow: 0 2px 12px rgba(0,0,0,0.06);
            border: 1px solid #e9ecef;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
            text-decoration: none;
            color: inherit;
            display: block;
            width: 100%;
            max-width: 600px;
        }

        .order-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .order-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 20px rgba(0,0,0,0.1);
            text-decoration: none;
            color: inherit;
            border-color: #667eea;
        }

        .order-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 15px;
            flex-wrap: wrap;
            gap: 10px;
        }

        .order-code {
            font-size: 16px;
            font-weight: 600;
            color: #2c3e50;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-code i {
            color: #667eea;
            font-size: 16px;
        }

        .order-date {
            font-size: 13px;
            color: #6c757d;
            display: flex;
            align-items: center;
            gap: 6px;
            background: #f8f9fa;
            padding: 6px 12px;
            border-radius: 15px;
        }

        .order-details {
            margin-bottom: 15px;
        }

        .order-destination {
            font-size: 18px;
            font-weight: 600;
            color: #2c3e50;
            margin-bottom: 12px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .order-destination i {
            color: #667eea;
            font-size: 16px;
        }

        .order-info {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 12px;
            margin-bottom: 15px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
            border: 1px solid #e9ecef;
        }

        .info-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: 0.3px;
        }

        .info-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 600;
        }

        .status-badges {
            display: flex;
            gap: 10px;
            justify-content: center;
            flex-wrap: wrap;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            display: flex;
            align-items: center;
            gap: 6px;
            border: 2px solid;
            min-width: 120px;
            justify-content: center;
            letter-spacing: 0.3px;
        }

        .status-kehadiran {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #1565c0;
            border-color: #90caf9;
        }

        .status-kehadiran.hadir {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            color: #2e7d32;
            border-color: #81c784;
        }

        .status-pembayaran {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            color: #e65100;
            border-color: #ffb74d;
        }

        .status-pembayaran.lunas {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            color: #2e7d32;
            border-color: #81c784;
        }

        .empty-state {
            text-align: center;
            padding: 50px 30px;
            color: #6c757d;
            max-width: 400px;
            margin: 0 auto;
        }

        .empty-state i {
            font-size: 60px;
            margin-bottom: 20px;
            color: #dee2e6;
        }

        .empty-state h4 {
            font-size: 22px;
            margin-bottom: 10px;
            color: #495057;
            font-weight: 600;
        }

        .empty-state p {
            font-size: 14px;
            margin-bottom: 25px;
            line-height: 1.5;
        }

        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.3s ease;
        }

        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.3);
            text-decoration: none;
            color: white;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .main-container {
                padding: 15px;
                align-items: stretch;
            }

            .content-area {
                padding: 20px;
            }

            .header {
                font-size: 28px;
            }

            .menu-booking {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .menu-tab {
                width: 85%;
                max-width: 300px;
                min-width: auto;
                font-size: 14px;
                padding: 10px 20px;
            }

            .order-card {
                padding: 18px;
                max-width: 100%;
            }

            .booking-header h3 {
                font-size: 22px;
            }

            .booking-header p {
                font-size: 13px;
            }

            .order-header {
                flex-direction: column;
                align-items: center;
                text-align: center;
                gap: 8px;
            }

            .order-info {
                grid-template-columns: 1fr;
                gap: 10px;
            }

            .order-destination {
                font-size: 16px;
                justify-content: center;
                text-align: center;
            }

            .status-badges {
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }

            .status-badge {
                min-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: 20px 15px;
            }

            .main-container {
                padding: 10px;
            }

            .content-area {
                padding: 15px;
                border-radius: 12px;
            }

            .booking-header {
                margin-bottom: 20px;
            }

            .booking-header h3 {
                font-size: 20px;
            }

            .booking-header p {
                font-size: 13px;
            }

            .order-card {
                padding: 15px;
            }

            .order-destination {
                font-size: 15px;
            }

            .order-code {
                font-size: 14px;
            }

            .info-item {
                padding: 10px;
            }

            .empty-state {
                padding: 40px 20px;
            }

            .empty-state i {
                font-size: 50px;
                margin-bottom: 15px;
            }

            .empty-state h4 {
                font-size: 18px;
            }

            .empty-state p {
                font-size: 13px;
            }

            .btn-primary {
                padding: 10px 20px;
                font-size: 13px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .order-card {
            animation: fadeInUp 0.6s ease-out;
        }

        .order-card:nth-child(2) {
            animation-delay: 0.1s;
        }

        .order-card:nth-child(3) {
            animation-delay: 0.2s;
        }

        .order-card:nth-child(4) {
            animation-delay: 0.3s;
        }
    </style>
</head>

<body>
    @include('home.menu')
    
    <div class="hero-section">
        <div class="hero-content">
            <div class="header">Riwayat Pemesanan</div>
            <div class="menu-booking">
                <a href="{{ route('booking') }}" class="menu-tab">
                    <i class="fas fa-plus"></i>
                    Booking Destinasi Wisata
                </a>
                <a href="{{ route('riwayat_pemesanan') }}" class="menu-tab active">
                    <i class="fas fa-history"></i>
                    Riwayat Pemesanan
                </a>
            </div>
        </div>
    </div>

    <div class="main-container">
        <div class="content-wrapper">
            <div class="content-area">
                <div class="booking-header">
                    <h3>Riwayat Pemesanan Anda</h3>
                    <p>Lihat semua pemesanan tiket destinasi wisata yang pernah Anda buat dan kelola perjalanan Anda dengan mudah</p>
                </div>

                @if($data->count() > 0)
                    <div class="orders-grid">
                        @foreach($data as $d)
                        <a href="{{ route('tiket_qr_code', ['id' => $d->id]) }}" class="order-card">
                            <div class="order-header">
                                <div class="order-code">
                                    <i class="fas fa-ticket-alt"></i>
                                    {{ $d->kode_booking }}
                                </div>
                                <div class="order-date">
                                    <i class="fas fa-calendar"></i>
                                    {{ formatDateIndonesia($d->created_at, 'd M Y') }}
                                </div>
                            </div>

                            <div class="order-details">
                                <div class="order-destination">
                                    <i class="fas fa-map-marker-alt"></i>
                                    {{ $d->tenant->nama }}
                                </div>

                                <div class="order-info">
                                    <div class="info-item">
                                        <div class="info-label">Tanggal Kunjungan</div>
                                        <div class="info-value">{{ formatDateIndonesia($d->tanggal, 'd M Y') }}</div>
                                    </div>
                                    <div class="info-item">
                                        <div class="info-label">Jumlah Tiket</div>
                                        <div class="info-value">{{ $d->jumlah }} Tiket</div>
                                    </div>
                                </div>
                            </div>

                            <div class="status-badges">
                                <span class="status-badge {{ getStatusBadgeClass($d->status, 'kehadiran') }}">
                                    <i class="{{ getStatusIcon($d->status, 'kehadiran') }}"></i>
                                    {{ getStatusText($d->status, 'kehadiran') }}
                                </span>
                                <span class="status-badge {{ getStatusBadgeClass($d->status_pembayaran, 'pembayaran') }}">
                                    <i class="{{ getStatusIcon($d->status_pembayaran, 'pembayaran') }}"></i>
                                    {{ getStatusText($d->status_pembayaran, 'pembayaran') }}
                                </span>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @else
                    <div class="empty-state">
                        <i class="fas fa-ticket-alt"></i>
                        <h4>Belum Ada Pemesanan</h4>
                        <p>Anda belum pernah melakukan pemesanan tiket destinasi wisata.<br>Mulai petualangan Anda sekarang juga!</p>
                        <a href="{{ route('booking') }}" class="btn-primary">
                            <i class="fas fa-plus"></i>
                            Buat Pemesanan Pertama
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</body>

</html>