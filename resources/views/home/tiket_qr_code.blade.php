<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
    <!-- Font Awesome for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Midtrans Snap -->
    <script type="text/javascript" src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ $midtrans_client_key }}"></script>
    
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
        }

        .hero-section {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            padding: 30px 20px;
            margin-bottom: 20px;
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
            max-width: 1000px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            text-align: center;
        }

        .header {
            font-size: 32px;
            font-weight: 600;
            color: white;
            text-shadow: 0 2px 4px rgba(0,0,0,0.3);
        }

        .main-content {
            max-width: 900px;
            margin: 0 auto;
            padding: 20px;
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        .ticket-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
            position: relative;
            overflow: hidden;
        }

        .ticket-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 4px;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .ticket-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .ticket-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .ticket-title h2 {
            color: #2c3e50;
            font-size: 22px;
            font-weight: 600;
            margin: 0;
        }

        .ticket-subtitle {
            color: #6c757d;
            font-size: 13px;
            margin: 0;
        }

        .ticket-info {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .info-item {
            background: #f8f9fa;
            padding: 12px;
            border-radius: 8px;
            border-left: 3px solid #667eea;
        }

        .info-label {
            font-size: 11px;
            color: #6c757d;
            text-transform: uppercase;
            font-weight: 600;
            margin-bottom: 4px;
            letter-spacing: 0.5px;
        }

        .info-value {
            font-size: 14px;
            color: #2c3e50;
            font-weight: 600;
        }

        .status-badges {
            display: flex;
            gap: 10px;
            margin-bottom: 20px;
            flex-wrap: wrap;
            justify-content: center;
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 18px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            border: 2px solid;
            display: flex;
            align-items: center;
            gap: 5px;
        }

        .status-badge.status-kehadiran {
            background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%);
            color: #1565c0;
            border-color: #90caf9;
        }

        .status-badge.status-kehadiran.hadir {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            color: #2e7d32;
            border-color: #81c784;
        }

        .status-badge.status-pembayaran {
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            color: #e65100;
            border-color: #ffb74d;
        }

        .status-badge.status-pembayaran.lunas {
            background: linear-gradient(135deg, #e8f5e8 0%, #c8e6c9 100%);
            color: #2e7d32;
            border-color: #81c784;
        }

        .qr-section {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #f8f9fa 0%, #ffffff 100%);
            border-radius: 10px;
            border: 2px dashed #dee2e6;
            margin-bottom: 20px;
        }

        .qr-section h4 {
            margin-bottom: 15px;
            color: #2c3e50;
            font-size: 16px;
            font-weight: 600;
        }

        .qr-code img {
            border-radius: 8px;
            box-shadow: 0 3px 12px rgba(0,0,0,0.1);
            max-width: 200px;
            width: 100%;
        }

        .qr-section p {
            margin-top: 12px;
            color: #6c757d;
            font-size: 13px;
            max-width: 300px;
            margin-left: auto;
            margin-right: auto;
        }

        .payment-section {
            text-align: center;
            padding: 25px;
            background: linear-gradient(135deg, #fff3e0 0%, #ffe0b2 100%);
            border-radius: 10px;
            border: 2px solid #ffb74d;
        }

        .payment-section h4 {
            margin-bottom: 8px;
            color: #e65100;
            font-size: 16px;
            font-weight: 600;
        }

        .payment-message {
            color: #e65100;
            font-size: 14px;
            margin-bottom: 18px;
            font-weight: 500;
        }

        .btn-payment {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 12px 24px;
            border-radius: 8px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }

        .btn-payment:hover {
            transform: translateY(-2px);
            box-shadow: 0 4px 16px rgba(102, 126, 234, 0.3);
        }

        .btn-selesai {
            background: #6c757d;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 500;
            text-decoration: none;
            display: inline-flex;
            align-items: right;
            gap: 6px;
            transition: all 0.3s ease;
        }

        .btn-selesai:hover {
            background: #5a6268;
            transform: translateY(-1px);
            text-decoration: none;
            color: white;
        }

        /* Review Section */
        .review-section {
            background: white;
            border-radius: 12px;
            padding: 25px;
            box-shadow: 0 4px 20px rgba(0,0,0,0.08);
            border: 1px solid #e9ecef;
        }

        .review-header {
            display: flex;
            align-items: center;
            gap: 12px;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 1px solid #e9ecef;
        }

        .review-icon {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            width: 40px;
            height: 40px;
            border-radius: 10px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 18px;
        }

        .review-title h3 {
            color: #2c3e50;
            font-size: 18px;
            font-weight: 600;
            margin: 0;
        }

        .review-title p {
            color: #6c757d;
            margin: 0;
            font-size: 13px;
        }

        .rating-form {
            display: flex;
            flex-direction: column;
            gap: 15px;
        }

        .rating-stars {
            display: flex;
            justify-content: center;
            gap: 4px;
            margin: 15px 0;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars label {
            font-size: 28px;
            color: #ddd;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .rating-stars input[type="radio"]:checked ~ label,
        .rating-stars label:hover,
        .rating-stars label:hover ~ label {
            color: #ffc107;
            transform: scale(1.1);
        }

        .review-textarea {
            width: 100%;
            padding: 12px;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            font-size: 14px;
            min-height: 100px;
            resize: vertical;
            transition: all 0.3s ease;
            font-family: inherit;
        }

        .review-textarea:focus {
            outline: none;
            border-color: #667eea;
            box-shadow: 0 0 0 3px rgba(102, 126, 234, 0.1);
        }

        .review-buttons {
            display: flex;
            gap: 12px;
            justify-content: center;
            margin-top: 15px;
        }

        .btn-cancel, .btn-submit {
            padding: 10px 20px;
            border: none;
            border-radius: 6px;
            font-size: 13px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            min-width: 100px;
        }

        .btn-cancel {
            background: #6c757d;
            color: white;
        }

        .btn-cancel:hover {
            background: #5a6268;
        }

        .btn-submit {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
        }

        .btn-submit:hover {
            transform: translateY(-1px);
            box-shadow: 0 3px 12px rgba(102, 126, 234, 0.3);
        }

        /* Alert Messages */
        .alert {
            padding: 12px 16px;
            border-radius: 8px;
            margin-bottom: 15px;
            border: 1px solid;
            font-size: 14px;
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .alert-success {
            background: #d4edda;
            color: #155724;
            border-color: #c3e6cb;
        }

        .alert-warning {
            background: #fff3cd;
            color: #856404;
            border-color: #ffeaa7;
        }

        .alert-error {
            background: #f8d7da;
            color: #721c24;
            border-color: #f5c6cb;
        }

        .alert-info {
            background: #d1ecf1;
            color: #0c5460;
            border-color: #bee5eb;
        }

        .button-group {
            text-align: center;
            margin-top: 20px;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .header {
                font-size: 24px;
            }

            .main-content {
                padding: 15px;
                gap: 15px;
            }

            .ticket-section, .review-section {
                padding: 20px;
            }

            .ticket-info {
                grid-template-columns: 1fr;
                gap: 12px;
            }

            .ticket-header {
                flex-direction: column;
                text-align: center;
                gap: 8px;
            }

            .status-badges {
                justify-content: center;
                flex-direction: column;
                align-items: center;
                gap: 8px;
            }

            .status-badge {
                min-width: 160px;
                justify-content: center;
            }

            .review-buttons {
                flex-direction: column;
                align-items: center;
            }

            .btn-cancel, .btn-submit {
                width: 100%;
                max-width: 200px;
            }

            .btn-selesai {
                width: auto;
                min-width: 160px;
                max-width: 180px;
            }

            .qr-code img {
                max-width: 150px;
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: 20px 15px;
            }

            .main-content {
                padding: 10px;
            }

            .ticket-section, .review-section {
                padding: 15px;
            }

            .rating-stars label {
                font-size: 24px;
            }

            .ticket-info {
                gap: 10px;
            }

            .info-item {
                padding: 10px;
            }

            .qr-section, .payment-section {
                padding: 20px;
            }
        }

        /* Animation */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .ticket-section, .review-section {
            animation: fadeInUp 0.6s ease-out;
        }
    </style>
</head>

<body>
    @include('home.menu')

    <div class="hero-section">
        <div class="hero-content">
            <div class="header">Tiket Destinasi Wisata</div>
        </div>
    </div>

    <div class="main-content">
        <!-- Success/Error Messages -->
        @if(session('success'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i> {{ session('success') }}
            </div>
        @endif

        @if(session('warning'))
            <div class="alert alert-warning">
                <i class="fas fa-exclamation-triangle"></i> {{ session('warning') }}
            </div>
        @endif

        @if(session('error'))
            <div class="alert alert-error">
                <i class="fas fa-times-circle"></i> {{ session('error') }}
            </div>
        @endif

        @if(session('info'))
            <div class="alert alert-info">
                <i class="fas fa-info-circle"></i> {{ session('info') }}
            </div>
        @endif

        <!-- Ticket Section -->
        <div class="ticket-section">
            <div class="ticket-header">
                <div class="ticket-icon">
                    <i class="fas fa-ticket-alt"></i>
                </div>
                <div class="ticket-title">
                    <h2>Tiket Digital</h2>
                    <p class="ticket-subtitle">{{ $data->kode_booking }}</p>
                </div>
            </div>

            <div class="ticket-info">
                <div class="info-item">
                    <div class="info-label">Destinasi Wisata</div>
                    <div class="info-value">{{ $tenant->nama }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Tanggal Kunjungan</div>
                    <div class="info-value">{{ formatDateIndonesia($data->tanggal, 'd M Y, H:i') }}</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Jumlah Tiket</div>
                    <div class="info-value">{{ $data->jumlah }} Tiket</div>
                </div>
                <div class="info-item">
                    <div class="info-label">Kode Booking</div>
                    <div class="info-value">{{ $data->kode_booking }}</div>
                </div>
            </div>

            <div class="status-badges">
                <span class="status-badge {{ getStatusBadgeClass($data->status, 'kehadiran') }}">
                    <i class="{{ getStatusIcon($data->status, 'kehadiran') }}"></i>
                    {{ getStatusText($data->status, 'kehadiran') }}
                </span>
                <span class="status-badge {{ getStatusBadgeClass($data->status_pembayaran, 'pembayaran') }}">
                    <i class="{{ getStatusIcon($data->status_pembayaran, 'pembayaran') }}"></i>
                    {{ getStatusText($data->status_pembayaran, 'pembayaran') }}
                </span>
            </div>

            @if ($data->status_pembayaran == 1)
                <div class="qr-section">
                    <h4>
                        <i class="fas fa-qrcode"></i> QR Code Tiket
                    </h4>
                    <div id="qrcode-{{ $data->kode_booking }}"></div>
                    <p>
                        Tunjukkan QR Code ini kepada petugas saat masuk destinasi wisata
                    </p>
                </div>
            @else
                <div class="payment-section">
                    <h4>
                        <i class="fas fa-credit-card"></i> Pembayaran Diperlukan
                    </h4>
                    <p class="payment-message">
                        Silakan lakukan pembayaran terlebih dahulu untuk mendapatkan QR Code tiket
                    </p>
                    @if($data->snap_token)
                        <button id="pay-button" class="btn-payment">
                            <i class="fas fa-credit-card"></i>
                            Bayar dengan Midtrans
                        </button>
                    @else
                        <p style="color: #dc3545; margin-top: 10px; font-size: 13px;">
                            <i class="fas fa-exclamation-triangle"></i>
                            Token pembayaran tidak tersedia. Silakan hubungi customer service.
                        </p>
                    @endif
                </div>
            @endif

            <div class="button-group">
                <a href="{{ route('riwayat_pemesanan') }}" class="btn-selesai">
                    <i class="fas fa-arrow-left"></i>Kembali ke Riwayat
                </a>
            </div>
        </div>

        <!-- Review Section -->
        @if($data->status_pembayaran == 1)
        <div class="review-section">
            <div class="review-header">
                <div class="review-icon">
                    <i class="fas fa-star"></i>
                </div>
                <div class="review-title">
                    <h3>Berikan Rating dan Ulasan</h3>
                    <p>Bagikan pengalaman Anda tentang {{ $tenant->nama }}</p>
                </div>
            </div>

            <form method="POST" action="{{ route('ulasan') }}" class="rating-form">
                @csrf
                <input type="hidden" name="tenant_id" value="{{ $tenant->id }}">
                
                <div class="rating-stars">
                    <input type="radio" name="rating" id="star-5" value="5" required>
                    <label for="star-5">★</label>
                    <input type="radio" name="rating" id="star-4" value="4">
                    <label for="star-4">★</label>
                    <input type="radio" name="rating" id="star-3" value="3">
                    <label for="star-3">★</label>
                    <input type="radio" name="rating" id="star-2" value="2">
                    <label for="star-2">★</label>
                    <input type="radio" name="rating" id="star-1" value="1">
                    <label for="star-1">★</label>
                </div>

                <textarea 
                    name="komentar" 
                    class="review-textarea" 
                    placeholder="Bagikan pengalaman Anda tentang tempat ini..." 
                    required></textarea>

                <div class="review-buttons">
                    <button type="reset" class="btn-cancel">
                        <i class="fas fa-times"></i> Batal
                    </button>
                    <button type="submit" class="btn-submit">
                        <i class="fas fa-paper-plane"></i> Kirim Ulasan
                    </button>
                </div>
            </form>
        </div>
        @endif
    </div>

    <!-- QR Generator Script -->
    <script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Generate QR Code if payment is completed
            @if($data->status_pembayaran == 1)
            var kodeBooking = "{{ $data->kode_booking }}";
            var qrElement = document.getElementById('qrcode-' + kodeBooking);
            
            if (qrElement) {
                const qr = qrcode(0, 'L');
                qr.addData(kodeBooking);
                qr.make();
                const qrCodeImageTag = qr.createImgTag(5, 5);
                qrElement.innerHTML = qrCodeImageTag;
            }
            @endif

            // Payment button handler
            @if($data->status_pembayaran == 0 && $data->snap_token)
            var payButton = document.getElementById('pay-button');
            if (payButton) {
                payButton.addEventListener('click', function() {
                    if (window.snap) {
                        window.snap.pay('{{ $data->snap_token }}', {
                            onSuccess: function(result) {
                                console.log('Payment success:', result);
                                // Reload page to show updated payment status
                                window.location.reload();
                            },
                            onPending: function(result) {
                                console.log('Payment pending:', result);
                                alert('Pembayaran sedang diproses. Silakan tunggu konfirmasi.');
                                window.location.reload();
                            },
                            onError: function(result) {
                                console.log('Payment error:', result);
                                alert('Terjadi kesalahan dalam pembayaran. Silakan coba lagi.');
                            },
                            onClose: function() {
                                console.log('Payment popup closed');
                            }
                        });
                    } else {
                        alert('Midtrans Snap belum tersedia. Silakan refresh halaman.');
                    }
                });
            }
            @endif

            // Auto-dismiss alerts
            setTimeout(function() {
                const alerts = document.querySelectorAll('.alert');
                alerts.forEach(function(alert) {
                    alert.style.transition = 'opacity 0.5s ease';
                    alert.style.opacity = '0';
                    setTimeout(function() {
                        alert.remove();
                    }, 500);
                });
            }, 5000);
        });
    </script>
</body>

</html>