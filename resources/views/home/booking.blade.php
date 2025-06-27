<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dinas Pariwisata Kabupaten Madiun</title>
    <link rel="stylesheet" href="style2.css">
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
            margin-bottom: 20px;
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

        .container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            min-height: calc(100vh - 300px);
        }

        .content-area {
            background: white;
            border-radius: 12px;
            padding: 30px;
            box-shadow: 0 4px 12px rgba(0,0,0,0.08);
            max-width: 800px;
            margin: 0 auto;
        }

        .booking-header {
            margin-bottom: 30px;
            text-align: center;
        }

        .booking-header h3 {
            color: #2c3e50;
            font-size: 28px;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .booking-header p {
            color: #6c757d;
            font-size: 16px;
        }

        .booking-form {
            max-width: 600px;
            margin: 0 auto;
        }

        .form-group {
            margin-bottom: 25px;
        }

        .form-group label {
            display: block;
            margin-bottom: 8px;
            color: #2c3e50;
            font-weight: 500;
            font-size: 15px;
        }

        .form-control {
            width: 100%;
            padding: 12px 16px;
            font-size: 16px;
            line-height: 1.5;
            color: #495057;
            background-color: #fff;
            border: 2px solid #e9ecef;
            border-radius: 8px;
            transition: all 0.3s ease;
            box-sizing: border-box;
        }

        .form-control:focus {
            color: #495057;
            background-color: #fff;
            border-color: #667eea;
            outline: 0;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }

        .form-control::placeholder {
            color: #adb5bd;
        }

        select.form-control {
            cursor: pointer;
        }

        .input-group {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: #6c757d;
            font-size: 16px;
            pointer-events: none;
        }

        .input-group .form-control {
            padding-left: 45px;
        }

        .btn-booking {
            width: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            border: none;
            padding: 15px 20px;
            border-radius: 8px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 20px;
        }

        .btn-booking:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(102, 126, 234, 0.4);
        }

        .btn-booking:active {
            transform: translateY(0);
        }

        .form-help {
            font-size: 13px;
            color: #6c757d;
            margin-top: 5px;
        }

        .booking-steps {
            display: flex;
            justify-content: center;
            margin-bottom: 30px;
            gap: 20px;
        }

        .step {
            display: flex;
            align-items: center;
            gap: 8px;
            color: #6c757d;
            font-size: 14px;
        }

        .step.active {
            color: #667eea;
            font-weight: 600;
        }

        .step-number {
            width: 24px;
            height: 24px;
            border-radius: 50%;
            background: #e9ecef;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 12px;
            font-weight: 600;
        }

        .step.active .step-number {
            background: #667eea;
            color: white;
        }

        .info-card {
            background: linear-gradient(135deg, #e3f2fd 0%, #f3e5f5 100%);
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 25px;
            border-left: 4px solid #667eea;
        }

        .info-card h5 {
            color: #2c3e50;
            font-size: 16px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .info-card p {
            color: #6c757d;
            font-size: 14px;
            margin: 0;
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .container {
                padding: 15px;
            }

            .content-area {
                padding: 20px;
            }

            .header {
                font-size: 28px;
                margin: 15px 0;
            }

            .menu-booking {
                flex-direction: column;
                align-items: center;
                gap: 10px;
            }

            .menu-tab {
                width: 80%;
                max-width: 280px;
                justify-content: center;
                padding: 12px 20px;
                font-size: 14px;
                min-width: auto;
            }

            .booking-header h3 {
                font-size: 24px;
            }

            .booking-steps {
                flex-direction: column;
                gap: 10px;
            }

            .step {
                justify-content: center;
            }

            .form-control {
                font-size: 16px; /* Prevents zoom on iOS */
            }
        }

        @media (max-width: 480px) {
            .hero-section {
                padding: 20px 15px;
            }

            .container {
                padding: 10px;
            }

            .content-area {
                padding: 15px;
            }

            .booking-header h3 {
                font-size: 20px;
            }

            .form-control {
                padding: 10px 14px;
            }

            .btn-booking {
                padding: 12px 18px;
                font-size: 15px;
            }
        }

        /* Animation for form submission */
        .form-submitting .btn-booking {
            background: #6c757d;
            cursor: not-allowed;
        }

        .form-submitting .btn-booking::after {
            content: "Processing...";
        }
    </style>
</head>

<body>
    @include('home.menu')
    
    <div class="hero-section">
        <div class="hero-content">
            <div class="header">Booking Destinasi Wisata</div>
            <div class="menu-booking">
                <a href="{{ route('booking') }}" class="menu-tab active">
                    Booking Destinasi Wisata
                </a>
                <a href="{{ route('riwayat_pemesanan') }}" class="menu-tab">
                    Riwayat Pemesanan
                </a>
            </div>
        </div>
    </div>

    <div class="container">
        <div class="content-area">
            <div class="booking-header">
                <h3>Pesan Tiket Destinasi Wisata</h3>
                <p>Pilih destinasi wisata favorit Anda dan nikmati pengalaman tak terlupakan</p>
            </div>

            <div class="booking-steps">
                <div class="step active">
                    <div class="step-number">1</div>
                    <span>Pilih Destinasi</span>
                </div>
                <div class="step">
                    <div class="step-number">2</div>
                    <span>Tentukan Tanggal</span>
                </div>
                <div class="step">
                    <div class="step-number">3</div>
                    <span>Konfirmasi Booking</span>
                </div>
            </div>

            <div class="info-card">
                <h5>💡 Tips Booking</h5>
                <p>Pastikan tanggal kunjungan Anda sudah sesuai dan periksa kembali jumlah tiket sebelum melanjutkan pembayaran.</p>
            </div>

            <!-- Error Messages -->
            @if(session('error'))
                <div style="background: #f8d7da; color: #721c24; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #f5c6cb;">
                    <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
                </div>
            @endif

            @if(session('success'))
                <div style="background: #d4edda; color: #155724; padding: 15px; border-radius: 8px; margin-bottom: 20px; border: 1px solid #c3e6cb;">
                    <i class="fas fa-check-circle"></i> {{ session('success') }}
                </div>
            @endif

            <form action="{{ route('booking_post') }}" method="POST" class="booking-form" id="bookingForm">
                @csrf
                <div class="form-group">
                    <label for="tenant_id">
                        Destinasi Wisata
                    </label>
                    <select class="form-control" name="tenant_id" id="tenant_id" required>
                        @if(!request('tenant_id'))
                        <option value="" disabled selected>Pilih Destinasi Wisata</option>
                        @endif
                        @foreach ($tenant as $t)
                            <option value="{{ $t->id }}" 
                                    data-harga="{{ $t->harga }}"
                                    @if(request('tenant_id') == $t->id) selected @endif>
                                {{ $t->nama }} - {{ formatCurrency($t->harga ?? 0) }}
                            </option>                   
                        @endforeach
                    </select>
                    <div class="form-help">Pilih destinasi wisata yang ingin Anda kunjungi</div>
                </div>

                <div class="form-group">
                    <label for="tanggal_pemesanan">
                        Tanggal & Waktu Kunjungan
                    </label>
                    <input type="datetime-local" 
                           class="form-control" 
                           name="tanggal_pemesanan" 
                           id="tanggal_pemesanan" 
                           required>
                    <div class="form-help">Pilih tanggal dan waktu yang diinginkan untuk kunjungan</div>
                </div>

                <div class="form-group">
                    <label for="jumlah_tiket">
                        Jumlah Tiket
                    </label>
                    <input type="number" 
                           class="form-control" 
                           min="1" 
                           max="10"
                           placeholder="Masukkan jumlah tiket (maks. 10)" 
                           name="jumlah_tiket" 
                           id="jumlah_tiket" 
                           required>
                    <div class="form-help">Maksimal 10 tiket per transaksi</div>
                </div>

                <button class="btn-booking" type="submit" id="submitBtn">
                    Lanjutkan ke Pembayaran
                </button>
                
                <!-- Price Calculator Display -->
                <div id="priceCalculator" style="display: none; margin-top: 20px; padding: 15px; background: #e3f2fd; border-radius: 8px; text-align: center;">
                    <div style="font-size: 14px; color: #1565c0; margin-bottom: 5px;">Total Pembayaran:</div>
                    <div id="totalPrice" style="font-size: 20px; font-weight: 600; color: #1565c0;"></div>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Set minimum date to today
        document.addEventListener('DOMContentLoaded', function() {
            const today = new Date();
            const tomorrow = new Date(today);
            tomorrow.setDate(tomorrow.getDate() + 1);
            
            const dateInput = document.getElementById('tanggal_pemesanan');
            const minDate = tomorrow.toISOString().slice(0, 16);
            dateInput.min = minDate;
        });

        // Form submission animation
        document.getElementById('bookingForm').addEventListener('submit', function() {
            document.body.classList.add('form-submitting');
            document.getElementById('submitBtn').disabled = true;
        });

        // Update steps based on form progress
        const formInputs = document.querySelectorAll('.form-control');
        const steps = document.querySelectorAll('.step');

        formInputs.forEach((input, index) => {
            input.addEventListener('change', function() {
                if (this.value) {
                    if (steps[index + 1]) {
                        steps[index + 1].classList.add('active');
                    }
                }
            });
        });

        // Auto-submit prevention for double clicks
        let formSubmitted = false;
        document.getElementById('bookingForm').addEventListener('submit', function(e) {
            if (formSubmitted) {
                e.preventDefault();
                return false;
            }
            formSubmitted = true;
        });

        // Price Calculator
        function formatCurrency(amount) {
            return 'Rp ' + new Intl.NumberFormat('id-ID').format(amount);
        }

        function updatePriceCalculator() {
            const tenantSelect = document.getElementById('tenant_id');
            const jumlahInput = document.getElementById('jumlah_tiket');
            const priceCalculator = document.getElementById('priceCalculator');
            const totalPriceElement = document.getElementById('totalPrice');

            if (tenantSelect.value && jumlahInput.value) {
                const selectedOption = tenantSelect.options[tenantSelect.selectedIndex];
                const harga = parseInt(selectedOption.getAttribute('data-harga') || 0);
                const jumlah = parseInt(jumlahInput.value || 0);
                const total = harga * jumlah;

                if (total > 0) {
                    totalPriceElement.textContent = formatCurrency(total);
                    priceCalculator.style.display = 'block';
                } else {
                    priceCalculator.style.display = 'none';
                }
            } else {
                priceCalculator.style.display = 'none';
            }
        }

        // Event listeners for price calculation
        document.getElementById('tenant_id').addEventListener('change', updatePriceCalculator);
        document.getElementById('jumlah_tiket').addEventListener('input', updatePriceCalculator);

        // Initial calculation if form has pre-filled values
        updatePriceCalculator();
    </script>
</body>

</html>