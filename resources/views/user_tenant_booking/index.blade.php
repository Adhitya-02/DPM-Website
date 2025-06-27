@extends('layout')

@section('script_top')
<script type="text/javascript"
		src="https://app.sandbox.midtrans.com/snap/snap.js"
    data-client-key="{{ $midtrans_client_key }}"></script>
@endsection

@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Booking</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default">
                Tambah 
            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Status Kehadiran</th>
                        <th>Status Pembayaran</th>
                        <th>Kode Booking</th>
                        <!-- <th>QR Code</th> -->
                        <th>Jumlah Pengunjung</th>
                        <th>User</th>
                        <th>Tenant</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->tanggal }}</td>
                            <td>
                                @if ($d->status == 1)
                                    Pesan
                                @else
                                    Hadir
                                @endif
                            </td>
                            <td>
                                @if ($d->status_pembayaran == 0)
                                    Belum Bayar
                                @else
                                    Sudah Bayar
                                @endif
                            </td>
                            <td>{{ $d->kode_booking }}</td>
                            <!-- <td>
                                <div id="qrcode-{{ $d->kode_booking }}"></div>
                            </td> -->
                            <td>{{ $d->jumlah }}</td>
                            <td>{{ $d->user?->nama }}</td>
                            <td>{{ $d->tenant?->nama }}</td>
                            <td>
                                @if ($d->status_pembayaran == 0)
                                <form action="{{ route('user_tenant_booking.update', $d->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_pembayaran" value="1">
                                    <button type="submit" class="btn btn-success btn-sm">Ubah Sudah Bayar</button>
                                </form>
                                @else
                                <form action="{{ route('user_tenant_booking.update', $d->id) }}" method="POST"
                                    style="display: inline">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="status_pembayaran" value="0">
                                    <button type="submit" class="btn btn-danger btn-sm">Ubah Belum Bayar</button>
                                </form>
                                @endif
                                {{-- <button id="pay-button-{{ $d->id }}" class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#modal-midtrans-{{ $d->id }}">Bayar dengan Midtrans</button>
                                <script>
                                    var payButton = document.getElementById('pay-button-{{ $d->id }}');
                                        payButton.addEventListener('click', function () {
                                        window.snap.pay('{{$d->snap_token }}');
                                    });
                                </script> --}}
                            </td>
                        </tr>                        
                        <div class="modal fade" id="modal-edit-{{ $d->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('user_tenant_booking.update', $d->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Tutup</button>
                                            <button type="submit" class="btn btn-primary">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>

    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Tambah Booking</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user_tenant_boo.store') }}" method="POST">
                        <input type="hidden" class="form-control" id="tenant_id" name="tenant_id" value="{{ auth()->user()->tenant->id }}">
                        @csrf
                        <div class="form-group">
                            <label for="tenant_id">Jumlah Pengunjung</label>
                            <input type="number" class="form-control" id="jumlah" name="jumlah">
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>
@endsection
@section('script')
<script src="https://cdn.jsdelivr.net/npm/qrcode-generator@1.4.4/qrcode.min.js"></script>
    @foreach ($data as $d)
        <script>
            document.addEventListener("DOMContentLoaded", function() {
                var kodeBooking = @json($d->kode_booking);
                const typeNumber = 0; // Auto size
               const errorCorrectionLevel = 'L'; // Low

               const qr = qrcode(typeNumber, errorCorrectionLevel);
               qr.addData(kodeBooking);
               qr.make();

               const cellSize = 4; // Size of each cell in the QR code
               const margin = 4; // Number of cells for margin
// Generate the QR code as an image tag
               const qrCodeImageTag = qr.createImgTag(cellSize, margin);
               document.getElementById('qrcode-' + kodeBooking).innerHTML = qrCodeImageTag;
            });
        </script>
    @endforeach
@endsection