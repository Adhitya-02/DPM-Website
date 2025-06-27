@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Scan Booking</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <div id="qr-reader" style="width: 500px;"></div>
            <div id="qr-reader-results"></div>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
@section('script')
<script src="https://cdnjs.cloudflare.com/ajax/libs/html5-qrcode/2.3.8/html5-qrcode.min.js"></script>
<script>
    function onScanSuccess(decodedText, decodedResult) {
        // document.getElementById('qr-reader-results').innerText = `QR Code detected: ${decodedText}`;

        // Send the decoded text to an API
        const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
        fetch('{{ route('user_tenant_booking.scanStore')}}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken
            },
            body: JSON.stringify({ kode_booking: decodedText }),
        })
        .then(response => response.json())
        .then(data => {
            // console.log('Success:', data);
            alert(data.message);
        })
        .catch((error) => {
            console.error('Error:', error);
        });

        // Stop the scanner after successful scan
        // html5QrcodeScanner.clear();
    }

    var html5QrcodeScanner = new Html5QrcodeScanner(
        "qr-reader", { fps: 10, qrbox: 250, formatsToSupport: [ Html5QrcodeSupportedFormats.QR_CODE ] });
    html5QrcodeScanner.render(onScanSuccess);
</script>
@endsection
    
