@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengelola Tenant</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-check"></i> Berhasil!</h5>
                    {{ session('success') }}
                </div>
            @endif
            
            @if (session('error'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    {{ session('error') }}
                </div>
            @endif

            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                    <h5><i class="icon fas fa-ban"></i> Error!</h5>
                    <ul class="mb-0">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <button type="button" class="btn btn-primary mb-3" id="tambah" data-toggle="modal">
                <i class="fas fa-plus"></i> Tambah Tenant
            </button>
            
            <table id="table-tenant" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Deskripsi</th>
                        <th>Tipe Tenant</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $index => $d)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ Str::limit($d->deskripsi, 50) }}</td>
                            <td>
                                @if ($d->tipe_tenant_id == 1)
                                    <span class="badge badge-primary">Destinasi wisata</span>
                                @elseif($d->tipe_tenant_id == 2)
                                    <span class="badge badge-info">Rumah makan</span>
                                @elseif($d->tipe_tenant_id == 3)
                                    <span class="badge badge-success">Hotel</span>
                                @endif
                            </td>
                            <td>Rp {{ number_format($d->harga, 0, ',', '.') }}</td>
                            <td>
                                @if ($d->is_status_aktif == 1)
                                    <span class="badge badge-success">Aktif</span>
                                @else
                                    <span class="badge badge-secondary">Tidak aktif</span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Detail -->
                                <a href="{{ route('gambar_tenant.edit', $d->id) }}" class="btn btn-info btn-sm" title="Detail Tenant">
                                    <i class="fas fa-eye"></i>
                                </a>

                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm btn-edit" data-toggle="modal"
                                    _target="#modal-edit-{{ $d->id }}" lat="{{ $d->latitude }}"
                                    long="{{ $d->longitude }}" title="Edit Tenant">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="deleteTenant({{ $d->id }}, '{{ $d->nama }}')" title="Hapus Tenant">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit Tenant -->
                        <div class="modal fade" id="modal-edit-{{ $d->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="modalEditLabel{{ $d->id }}" aria-hidden="true">
                            <div class="modal-dialog modal-lg" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('tenant.update', $d->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel{{ $d->id }}">Edit Tenant: {{ $d->nama }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="nama{{ $d->id }}">Nama <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="nama{{ $d->id }}" name="nama"
                                                            value="{{ $d->nama }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="alamat{{ $d->id }}">Alamat <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control" id="alamat{{ $d->id }}" name="alamat"
                                                            value="{{ $d->alamat }}" required>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="deskripsi{{ $d->id }}">Deskripsi</label>
                                                        <textarea class="form-control" id="deskripsi{{ $d->id }}" name="deskripsi" rows="3">{{ $d->deskripsi }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="longitude{{ $d->id }}">Longitude <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control long" name="longitude"
                                                            value="{{ $d->longitude }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="latitude{{ $d->id }}">Latitude <span class="text-danger">*</span></label>
                                                        <input type="text" class="form-control lat" name="latitude"
                                                            value="{{ $d->latitude }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="harga{{ $d->id }}">Harga <span class="text-danger">*</span></label>
                                                        <input type="number" class="form-control" name="harga"
                                                            value="{{ $d->harga }}" required>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="form-group">
                                                <label>Lokasi pada Peta</label>
                                                <div style="width: 100%; height:400px;">
                                                    <div class="map-container-edit" id="map-container-{{ $d->id }}"
                                                        style="height: 100%; width: 100%; display: block; position: relative; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
                                                    </div>
                                                </div>
                                                <small class="form-text text-muted">Klik pada peta untuk mengubah lokasi</small>
                                            </div>

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="tipe_tenant_id{{ $d->id }}">Tipe Tenant <span class="text-danger">*</span></label>
                                                        <select class="form-control" id="tipe_tenant_id{{ $d->id }}" name="tipe_tenant_id" required>
                                                            <option value="1" {{ $d->tipe_tenant_id == 1 ? 'selected' : '' }}>
                                                                Destinasi Wisata</option>
                                                            <option value="2" {{ $d->tipe_tenant_id == 2 ? 'selected' : '' }}>
                                                                Rumah Makan</option>
                                                            <option value="3" {{ $d->tipe_tenant_id == 3 ? 'selected' : '' }}>
                                                                Hotel</option>
                                                        </select>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label for="is_status_aktif{{ $d->id }}">Status <span class="text-danger">*</span></label>
                                                        <select class="form-control" id="is_status_aktif{{ $d->id }}" name="is_status_aktif" required>
                                                            <option value="1" {{ $d->is_status_aktif == 1 ? 'selected' : '' }}>
                                                                Aktif</option>
                                                            <option value="0" {{ $d->is_status_aktif == 0 ? 'selected' : '' }}>
                                                                Tidak Aktif</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                                <i class="fas fa-times"></i> Tutup
                                            </button>
                                            <button type="submit" class="btn btn-primary">
                                                <i class="fas fa-save"></i> Simpan Perubahan
                                            </button>
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

    <!-- Modal Tambah Tenant -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fas fa-building"></i> Tambah Tenant Baru
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tenant.store') }}" method="POST" id="addTenantForm">
                        @csrf
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="nama">Nama <span class="text-danger">*</span></label>
                                    <input name="nama" type="text" class="form-control" id="nama"
                                        placeholder="Masukkan nama tenant" required value="{{ old('nama') }}">
                                </div>
                                <div class="form-group">
                                    <label for="alamat">Alamat <span class="text-danger">*</span></label>
                                    <input name="alamat" type="text" class="form-control" id="alamat"
                                        placeholder="Masukkan alamat lengkap" required value="{{ old('alamat') }}">
                                </div>
                                <div class="form-group">
                                    <label for="deskripsi">Deskripsi</label>
                                    <textarea name="deskripsi" class="form-control" id="deskripsi" placeholder="Masukkan deskripsi tenant" rows="3">{{ old('deskripsi') }}</textarea>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="latitude">Latitude <span class="text-danger">*</span></label>
                                    <input name="latitude" type="text" class="form-control lat" id="latitude"
                                        placeholder="Akan terisi otomatis dari peta" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="longitude">Longitude <span class="text-danger">*</span></label>
                                    <input name="longitude" type="text" class="form-control long" id="longitude"
                                        placeholder="Akan terisi otomatis dari peta" readonly required>
                                </div>
                                <div class="form-group">
                                    <label for="harga">Harga <span class="text-danger">*</span></label>
                                    <input name="harga" type="number" class="form-control" id="harga"
                                        placeholder="Masukkan harga" required value="{{ old('harga') }}">
                                </div>
                            </div>
                        </div>
                        
                        <div class="form-group">
                            <label>Lokasi pada Peta <span class="text-danger">*</span></label>
                            <div style="width: 100%; height:400px;">
                                <div id="map-container-create"
                                    style="height: 100%; width: 100%; display: block; position: relative; margin-bottom: 20px; border: 1px solid #ddd; border-radius: 4px;">
                                </div>
                            </div>
                            <small class="form-text text-muted">Klik pada peta untuk menandai lokasi tenant</small>
                        </div>
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="tipe_tenant_id">Tipe Tenant <span class="text-danger">*</span></label>
                                    <select name="tipe_tenant_id" class="form-control" id="tipe_tenant_id" required>
                                        <option value="">Pilih Tipe Tenant</option>
                                        <option value="1" {{ old('tipe_tenant_id') == '1' ? 'selected' : '' }}>Destinasi Wisata</option>
                                        <option value="2" {{ old('tipe_tenant_id') == '2' ? 'selected' : '' }}>Rumah Makan</option>
                                        <option value="3" {{ old('tipe_tenant_id') == '3' ? 'selected' : '' }}>Hotel</option>
                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="is_status_aktif">Status <span class="text-danger">*</span></label>
                                    <select name="is_status_aktif" class="form-control" id="is_status_aktif" required>
                                        <option value="1" {{ old('is_status_aktif') == '1' ? 'selected' : '' }}>Aktif</option>
                                        <option value="0" {{ old('is_status_aktif') == '0' ? 'selected' : '' }}>Tidak Aktif</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                        
                        <div class="modal-footer px-0">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">
                                <i class="fas fa-times"></i> Batal
                            </button>
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-save"></i> Simpan
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <!-- /.modal-content -->
        </div>
        <!-- /.modal-dialog -->
    </div>

    <!-- Form tersembunyi untuk aksi hapus tenant -->
    <form id="deleteTenantForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // Fungsi untuk hapus tenant
        function deleteTenant(tenantId, tenantName) {
            if (confirm('Apakah Anda yakin ingin menghapus tenant "' + tenantName + '"?\n\nAksi ini tidak dapat dibatalkan dan akan menghapus semua data terkait tenant tersebut.')) {
                const form = document.getElementById('deleteTenantForm');
                form.action = "{{ route('tenant.destroy', '') }}/" + tenantId;
                form.submit();
            }
        }

        // Auto close alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);
        });

        // Form validation untuk modal tambah tenant
        document.getElementById('addTenantForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const alamat = document.getElementById('alamat').value.trim();
            const latitude = document.getElementById('latitude').value.trim();
            const longitude = document.getElementById('longitude').value.trim();
            const harga = document.getElementById('harga').value.trim();
            const tipeTenant = document.getElementById('tipe_tenant_id').value;

            if (!nama || !alamat || !latitude || !longitude || !harga || !tipeTenant) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi (bertanda *)');
                return false;
            }

            if (harga <= 0) {
                e.preventDefault();
                alert('Harga harus lebih besar dari 0');
                return false;
            }
        });
    </script>

    <style>
        .table th {
            background-color: #f8f9fa;
            border-top: none;
        }
        
        .btn-sm {
            margin: 0 2px;
        }
        
        .badge {
            font-size: 0.8em;
        }
        
        .modal-header {
            background-color: #007bff;
            color: white;
        }
        
        .modal-header .close {
            color: white;
            opacity: 0.8;
        }
        
        .modal-header .close:hover {
            opacity: 1;
        }
        
        .text-danger {
            color: #dc3545 !important;
        }
        
        .form-text {
            margin-top: 0.25rem;
        }

        .modal-lg {
            max-width: 900px;
        }

        .map-container-edit, #map-container-create {
            border-radius: 8px;
            overflow: hidden;
        }
    </style>
@endsection

@section('script')
    <script>
        $(document).ready(function() {
            const table = $("#table-tenant").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": false,
                "language": {
                    "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                }
            });

            // Function to initialize edit button click events
            function initializeEditButtons() {
                $('.btn-edit').off('click').on('click', function() {
                    const targetModal = $(this).attr('_target');
                    const lat = $(this).attr('lat');
                    const long = $(this).attr('long');

                    // Show the modal
                    $(targetModal).modal('show');

                    // Initialize the map after the modal is fully shown
                    $(targetModal).on('shown.bs.modal', function() {
                        const containerId = $(targetModal).find('.map-container-edit').attr('id');
                        console.log(containerId);
                        process(lat, long, containerId);
                    });
                });
            }

            // Initialize edit buttons on page load
            initializeEditButtons();

            // Reinitialize edit buttons after DataTables redraw
            table.on('draw', function() {
                initializeEditButtons();
            });

            $('#tambah').on('click', function() {
                $('#modal-default').modal('show');

                // Initialize the map after the modal is fully shown
                $('#modal-default').on('shown.bs.modal', function() {
                    process(null, null, 'map-container-create');
                });
            });

            function process(lat, long, container_id) {
                const initialLat = lat ? parseFloat(lat).toFixed(10) : -7.6298;
                const initialLong = long ? parseFloat(long).toFixed(10) : 111.5130;

                // Initialize the map
                const map = L.map(container_id).setView([initialLat, initialLong], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    attribution: '© OpenStreetMap contributors'
                }).addTo(map);

                setTimeout(function() {
                    map.invalidateSize();
                }, 0);

                let marker;
                if (lat && long) {
                    marker = L.marker([initialLat, initialLong]).addTo(map);
                }

                map.on('click', function(e) {
                    if (marker) {
                        map.removeLayer(marker);
                    }
                    marker = L.marker(e.latlng).addTo(map);

                    const activeModal = document.querySelector('.modal.show');
                    if (activeModal) {
                        const latInput = activeModal.querySelector('.lat');
                        const longInput = activeModal.querySelector('.long');
                        if (latInput && longInput) {
                            latInput.value = e.latlng.lat.toFixed(6);
                            longInput.value = e.latlng.lng.toFixed(6);
                        }
                    }
                });

                const geocoder = L.Control.geocoder({
                        defaultMarkGeocode: false,
                        placeholder: 'Cari lokasi atau desa...',
                        position: 'topleft',
                    }).addTo(map);

                    geocoder.on('markgeocode', function(e) {
                        const latlng = e.geocode.center;

                        if (marker) {
                            map.removeLayer(marker);
                        }

                        marker = L.marker(latlng).addTo(map);
                        map.setView(latlng, 16);

                        const activeModal = document.querySelector('.modal.show');
                        if (activeModal) {
                            const latInput = activeModal.querySelector('.lat');
                            const longInput = activeModal.querySelector('.long');
                            if (latInput && longInput) {
                                latInput.value = latlng.lat.toFixed(6);
                                longInput.value = latlng.lng.toFixed(6);
                            }
                        }
                    });


                    const locationButton = L.control({
                        position: 'topleft'
                    });
                    locationButton.onAdd = function(map) {
                        const div = L.DomUtil.create('div', 'leaflet-bar leaflet-control');
                        div.innerHTML = `
<a href="#" title="Get Current Location" style="display:flex; align-items:center; justify-content:center; width:30px; height:30px; background:white; text-decoration:none;">
<i class="fas fa-location-arrow"></i>
</a>
`;

                        div.onclick = function(e) {
                            e.preventDefault();
                            if ("geolocation" in navigator) {
                                navigator.geolocation.getCurrentPosition(function(position) {
                                    const lat = position.coords.latitude;
                                    const lng = position.coords.longitude;

                                    // Update map view
                                    map.setView([lat, lng], 15);

                                    // Update marker
                                    if (marker) {
                                        map.removeLayer(marker);
                                    }
                                    marker = L.marker([lat, lng]).addTo(map);

                                    // Update form inputs
                                    const activeModal = document.querySelector('.modal.show');
                                    if (activeModal) {
                                        const latInput = activeModal.querySelector('.lat');
                                        const longInput = activeModal.querySelector('.long');
                                        if (latInput && longInput) {
                                            latInput.value = lat.toFixed(6);
                                            longInput.value = lng.toFixed(6);
                                        }
                                    }
                                });
                            } else {
                                alert("Geolocation is not supported by your browser");
                            }
                        };
                        return div;
                    };
                    locationButton.addTo(map);

            }
        });
    </script>
@endsection