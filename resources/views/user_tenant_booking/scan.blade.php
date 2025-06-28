@extends('layout')
@section('content')
<div class="content-wrapper">
    <div class="content-header">
        <div class="container-fluid">
            <div class="row mb-2">
                <div class="col-sm-6">
                    <h1 class="m-0">Scan QR Code Booking</h1>
                </div>
                <div class="col-sm-6">
                    <ol class="breadcrumb float-sm-right">
                        <li class="breadcrumb-item"><a href="{{ route('user_tenant_booking.index') }}">Booking</a></li>
                        <li class="breadcrumb-item active">Scan QR Code</li>
                    </ol>
                </div>
            </div>
        </div>
    </div>

    <section class="content">
        <div class="container-fluid">
            <!-- LOKASI UTAMA UNTUK MENGATUR POSISI: Ubah col-md-8 offset-md-2 untuk centering yang lebih baik -->
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-2 col-sm-10">
                    <div class="card card-primary">
                        <div class="card-header text-center">
                            <h3 class="card-title">
                                <i class="fas fa-qrcode mr-2"></i>
                                Scanner QR Code Tiket
                            </h3>
                        </div>
                        <div class="card-body">
                            <!-- Instructions -->
                            <div class="alert alert-info mb-4 text-center">
                                <i class="fas fa-info-circle mr-2"></i>
                                <strong>Petunjuk:</strong> Arahkan kamera ke QR Code tiket untuk memverifikasi booking
                            </div>

                            <!-- Scanner Container - LOKASI KUNCI UNTUK MENGATUR SCANNER -->
                            <div class="scanner-container mb-4">
                                <div id="qr-reader" class="scanner-box"></div>
                            </div>

                            <!-- Results Container -->
                            <div id="scan-status" class="mt-3">
                                <div class="alert alert-secondary text-center">
                                    <i class="fas fa-camera mr-2"></i>
                                    Siap untuk scan QR Code...
                                </div>
                            </div>

                            <!-- Manual Input Option -->
                            <div class="card mt-4">
                                <div class="card-header bg-light">
                                    <h5 class="mb-0 text-center">
                                        <button class="btn btn-link collapsed" type="button" data-toggle="collapse" data-target="#manualInput" aria-expanded="false">
                                            <i class="fas fa-keyboard mr-2"></i>
                                            Input Manual Kode Booking
                                        </button>
                                    </h5>
                                </div>
                                <div id="manualInput" class="collapse">
                                    <div class="card-body">
                                        <form id="manualBookingForm">
                                            <div class="input-group">
                                                <input type="text" class="form-control" id="manualBookingCode" 
                                                       placeholder="Masukkan kode booking..." 
                                                       style="text-transform: uppercase;">
                                                <div class="input-group-append">
                                                    <button class="btn btn-primary" type="submit">
                                                        <i class="fas fa-check mr-1"></i> Verifikasi
                                                    </button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="mt-4 text-center">
                                <button id="startScan" class="btn btn-success mr-2" style="display: none;">
                                    <i class="fas fa-play mr-1"></i> Mulai Scan
                                </button>
                                <button id="stopScan" class="btn btn-warning mr-2" style="display: none;">
                                    <i class="fas fa-stop mr-1"></i> Berhenti Scan
                                </button>
                                <a href="{{ route('user_tenant_booking.index') }}" class="btn btn-secondary">
                                    <i class="fas fa-arrow-left mr-1"></i> Kembali
                                </a>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Scans Card -->
                    <div class="card mt-4" id="recentScans" style="display: none;">
                        <div class="card-header">
                            <h3 class="card-title">
                                <i class="fas fa-history mr-2"></i>
                                Scan Terakhir
                            </h3>
                        </div>
                        <div class="card-body">
                            <div id="scanHistory"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<!-- Loading Modal
<div class="modal fade" id="loadingModal" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false">
    <div class="modal-dialog modal-sm modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-body text-center py-4">
                <div class="spinner-border text-primary mb-3" role="status">
                    <span class="sr-only">Loading...</span>
                </div>
                <p class="mb-0">Memverifikasi booking...</p>
            </div>
        </div>
    </div>
</div> -->
@endsection

@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
let html5QrcodeScanner;
let scanHistory = [];

// Initialize scanner
function initScanner() {
    html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", 
        { 
            fps: 10, 
            qrbox: { width: 250, height: 250 },
            formatsToSupport: [Html5QrcodeSupportedFormats.QR_CODE],
            showTorchButtonIfSupported: true,
            showZoomSliderIfSupported: true
        }
    );
    html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    updateScanStatus('scanning', 'Scanning aktif... Arahkan kamera ke QR Code');
    document.getElementById('stopScan').style.display = 'inline-block';
    document.getElementById('startScan').style.display = 'none';
}

// Success callback
function onScanSuccess(decodedText, decodedResult) {
    processBooking(decodedText);
}

// Error callback
function onScanFailure(error) {
    // Silent fail - tidak perlu log setiap error scan
}

// Process booking verification
function processBooking(bookingCode) {
    // Show loading
    $('#loadingModal').modal('show');
    updateScanStatus('processing', `Memverifikasi kode: ${bookingCode}`);

    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
    
    fetch('{{ route('user_tenant_booking.scanStore') }}', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': csrfToken
        },
        body: JSON.stringify({ kode_booking: bookingCode }),
    })
    .then(response => response.json())
    .then(data => {
        $('#loadingModal').modal('hide');
        
        if (data.success) {
            updateScanStatus('success', data.message);
            addToHistory(bookingCode, 'success', data.message);
            
            // Success sound (optional)
            playSound('success');
            
            // Show success alert
            Swal.fire({
                icon: 'success',
                title: 'Berhasil!',
                text: data.message,
                timer: 3000,
                showConfirmButton: false
            });
        } else {
            updateScanStatus('error', data.message);
            addToHistory(bookingCode, 'error', data.message);
            
            // Error sound (optional)
            playSound('error');
            
            // Show error alert
            Swal.fire({
                icon: 'error',
                title: 'Gagal!',
                text: data.message,
                confirmButtonText: 'OK'
            });
        }
    })
    .catch((error) => {
        $('#loadingModal').modal('hide');
        console.error('Error:', error);
        updateScanStatus('error', 'Terjadi kesalahan koneksi');
        
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Terjadi kesalahan saat memverifikasi booking',
            confirmButtonText: 'OK'
        });
    });
}

// Update scan status
function updateScanStatus(type, message) {
    const statusDiv = document.getElementById('scan-status');
    let icon, alertClass;
    
    switch(type) {
        case 'scanning':
            icon = 'fas fa-camera';
            alertClass = 'alert-info';
            break;
        case 'processing':
            icon = 'fas fa-spinner fa-spin';
            alertClass = 'alert-warning';
            break;
        case 'success':
            icon = 'fas fa-check-circle';
            alertClass = 'alert-success';
            break;
        case 'error':
            icon = 'fas fa-exclamation-triangle';
            alertClass = 'alert-danger';
            break;
        default:
            icon = 'fas fa-info-circle';
            alertClass = 'alert-secondary';
    }
    
    statusDiv.innerHTML = `
        <div class="alert ${alertClass} text-center">
            <i class="${icon} mr-2"></i>
            ${message}
        </div>
    `;
}

// Add to scan history
function addToHistory(code, status, message) {
    const now = new Date().toLocaleString('id-ID');
    scanHistory.unshift({
        code: code,
        status: status,
        message: message,
        time: now
    });
    
    // Keep only last 10 scans
    if (scanHistory.length > 10) {
        scanHistory = scanHistory.slice(0, 10);
    }
    
    updateHistoryDisplay();
}

// Update history display
function updateHistoryDisplay() {
    const historyDiv = document.getElementById('scanHistory');
    const recentScansCard = document.getElementById('recentScans');
    
    if (scanHistory.length > 0) {
        recentScansCard.style.display = 'block';
        
        let historyHtml = '';
        scanHistory.forEach((item, index) => {
            const badgeClass = item.status === 'success' ? 'badge-success' : 'badge-danger';
            const icon = item.status === 'success' ? 'fas fa-check' : 'fas fa-times';
            
            historyHtml += `
                <div class="d-flex justify-content-between align-items-center border-bottom py-2 ${index === 0 ? 'bg-light' : ''}">
                    <div>
                        <strong>${item.code}</strong><br>
                        <small class="text-muted">${item.time}</small>
                    </div>
                    <div class="text-right">
                        <span class="badge ${badgeClass}">
                            <i class="${icon} mr-1"></i>
                            ${item.status === 'success' ? 'Berhasil' : 'Gagal'}
                        </span><br>
                        <small>${item.message}</small>
                    </div>
                </div>
            `;
        });
        
        historyDiv.innerHTML = historyHtml;
    }
}

// Play sound (optional)
function playSound(type) {
    // You can add sound files later
    // const audio = new Audio(`/sounds/${type}.mp3`);
    // audio.play().catch(e => console.log('Audio play failed'));
}

// Stop scanner
function stopScanner() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
        updateScanStatus('stopped', 'Scanner dihentikan');
        document.getElementById('startScan').style.display = 'inline-block';
        document.getElementById('stopScan').style.display = 'none';
    }
}

// Manual booking form
document.getElementById('manualBookingForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const bookingCode = document.getElementById('manualBookingCode').value.trim().toUpperCase();
    
    if (bookingCode) {
        processBooking(bookingCode);
        document.getElementById('manualBookingCode').value = '';
    } else {
        Swal.fire({
            icon: 'warning',
            title: 'Perhatian!',
            text: 'Silakan masukkan kode booking',
            confirmButtonText: 'OK'
        });
    }
});

// Event listeners
document.getElementById('startScan').addEventListener('click', initScanner);
document.getElementById('stopScan').addEventListener('click', stopScanner);

// Auto uppercase for manual input
document.getElementById('manualBookingCode').addEventListener('input', function(e) {
    e.target.value = e.target.value.toUpperCase();
});

// Initialize scanner on page load
document.addEventListener('DOMContentLoaded', function() {
    initScanner();
});

// Cleanup on page unload
window.addEventListener('beforeunload', function() {
    if (html5QrcodeScanner) {
        html5QrcodeScanner.clear();
    }
});
</script>

<!-- SweetAlert2 for better alerts -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<style>
/* LOKASI CSS UNTUK MENGATUR POSISI DAN UKURAN SCANNER */
.scanner-container {
    background: #f8f9fa;
    border-radius: 15px;
    padding: 15px;
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    display: flex;
    justify-content: center;
    align-items: center;
}

.scanner-box {
    width: 100%;
    max-width: 350px; /* UBAH NILAI INI UNTUK MENGATUR LEBAR SCANNER */
    margin: 0 auto;
    border: 3px dashed #007bff;
    border-radius: 10px;
    padding: 10px;
    background: white;
}

#qr-reader {
    background: white;
    border-radius: 10px;
    overflow: hidden;
}

#qr-reader > div {
    border: none !important;
}

/* MENGATUR WIDTH UNTUK ELEMEN SCANNER INTERNAL */
#qr-reader__dashboard_section {
    text-align: center !important;
}

#qr-reader__camera_selection {
    text-align: center !important;
    margin: 10px auto !important;
}

.card {
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
    border: none;
}

.alert {
    border-radius: 10px;
    border: none;
}

.btn {
    border-radius: 25px;
    padding: 8px 20px;
}

.spinner-border {
    width: 3rem;
    height: 3rem;
}

/* RESPONSIVE DESIGN */
@media (max-width: 768px) {
    .col-lg-6.col-md-8.col-sm-10 {
        padding: 0 15px; /* UBAH PADDING SAMPING DI MOBILE */
    }
    
    .scanner-box {
        max-width: 100% !important; /* FULL WIDTH DI MOBILE */
    }
    
    #qr-reader {
        width: 100% !important;
    }
    
    .scanner-container {
        padding: 10px;
        margin: 0 -5px; /* NEGATIF MARGIN UNTUK LEBIH KE KIRI DI MOBILE */
    }
    
    .card-body {
        padding: 15px; /* KURANGI PADDING CARD DI MOBILE */
    }
}

@media (max-width: 576px) {
    .col-lg-6.col-md-8.col-sm-10 {
        padding: 0 10px; /* PADDING LEBIH KECIL DI MOBILE KECIL */
    }
    
    .scanner-container {
        margin: 0 -10px; /* LEBIH KE KIRI LAGI DI MOBILE KECIL */
    }
}

/* OVERRIDE UNTUK MEMASTIKAN SCANNER CENTERED */
#qr-reader > div:first-child {
    margin: 0 auto !important;
    text-align: center !important;
}
</style>
@endsection