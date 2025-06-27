@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengelola Tenant</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            @if (session('success'))
                <div class="alert alert-success">
                    {{ session('success') }}
                </div>
            @endif

            <button type="button" class="btn btn-primary mb-3" id="tambah" data-toggle="modal">
                Tambah
            </button>
            <table id="table-tenant" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Alamat</th>
                        <th>Deskripsi</th>
                        <th>Longitude</th>
                        <th>Latitude</th>
                        <th>Tipe Tenant</th>
                        <th>Harga</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->nama }}</td>
                            <td>{{ $d->alamat }}</td>
                            <td>{{ $d->deskripsi }}</td>
                            <td>{{ $d->latitude }}</td>
                            <td>{{ $d->longitude }}</td>
                            <td>
                                @if ($d->tipe_tenant_id == 1)
                                    Destinasi wisata
                                @elseif($d->tipe_tenant_id == 2)
                                    Rumah makan
                                @elseif($d->tipe_tenant_id == 3)
                                    Hotel
                                @endif
                            </td>
                            <td>{{ $d->harga }}</td>
                            <td>
                                @if ($d->is_status_aktif == 1)
                                    Aktif
                                @elseif($d->is_status_aktif == 0)
                                    Tidak aktif
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('gambar_tenant.edit', $d->id) }}" class="btn btn-info btn-sm">
                                    <i class="fas fa-eye"></i> <!-- Ikon untuk Detail -->
                                </a>

                                <button type="button" class="btn btn-warning btn-sm btn-edit" data-toggle="modal"
                                    _target="#modal-edit-{{ $d->id }}" lat="{{ $d->latitude }}"
                                    long="{{ $d->longitude }}">
                                    <i class="fas fa-edit"></i> <!-- Ikon untuk Edit -->
                                </button>

                                <form action="{{ route('tenant.destroy', $d->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> <!-- Ikon untuk Hapus -->
                                    </button>
                                </form>
                            </td>
                        </tr>
                        <div class="modal fade" id="modal-edit-{{ $d->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('tenant.update', $d->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Data</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $d->nama }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="alamat">Alamat</label>
                                                <input type="text" class="form-control" id="alamat" name="alamat"
                                                    value="{{ $d->alamat }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="deskripsi">Deskripsi</label>
                                                <input type="text" class="form-control" id="deskripsi" name="deskripsi"
                                                    value="{{ $d->deskripsi }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="longitude">Longitude</label>
                                                <input type="text" class="form-control long" name="longitude"
                                                    value="{{ $d->longitude }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="latitude">Latitude</label>
                                                <input type="text" class="form-control lat" name="latitude"
                                                    value="{{ $d->latitude }}" readonly>
                                            </div>
                                            <div class="form-group">
                                                <label for="harga">Harga</label>
                                                <input type="number" class="form-control" name="harga"
                                                    value="{{ $d->harga }}">
                                            </div>
                                            <div class="form-group">
                                                <div style="width: 100%; height:400px;">
                                                    <div class="map-container-edit" id="map-container-{{ $d->id }}"
                                                        style="height: 100%; width: 100%; display: block; position: relative; margin-bottom: 20px;">
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <label for="tipe_tenant_id">Tipe Tenant</label>
                                                <select class="form-control" id="tipe_tenant_id" name="tipe_tenant_id">
                                                    <option value="1" {{ $d->tipe_tenant_id == 1 ? 'selected' : '' }}>
                                                        Destinasi Wisata</option>
                                                    <option value="2" {{ $d->tipe_tenant_id == 2 ? 'selected' : '' }}>
                                                        Rumah Makan</option>
                                                    <option value="3" {{ $d->tipe_tenant_id == 3 ? 'selected' : '' }}>
                                                        Hotel</option>
                                                    <!-- Add other options as necessary -->
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="is_status_aktif">Status</label>
                                                <select class="form-control" id="is_status_aktif" name="is_status_aktif">
                                                    <option value="1"
                                                        {{ $d->is_status_aktif == 1 ? 'selected' : '' }}>
                                                        Aktif</option>
                                                    <option value="0"
                                                        {{ $d->is_status_aktif == 0 ? 'selected' : '' }}>Tidak Aktif
                                                    </option>
                                                    <!-- Add other options as necessary -->
                                                </select>
                                            </div>
                                            <!-- Add other fields as necessary -->
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-dismiss="modal">Tutup</button>
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
                    <h4 class="modal-title">Tambah Tenant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('tenant.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input name="nama" type="text" class="form-control" id="exampleInputEmail1"
                                placeholder="Nama" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Alamat</label>
                            <input name="alamat" type="text" class="form-control" id="exampleInputEmail1"
                                placeholder="Alamat" required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Deskripsi</label>
                            <textarea name="deskripsi" class="form-control" placeholder="Deskripsi" rows="30"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Latitude</label>
                            <input name="latitude" type="text" class="form-control lat" id="exampleInputEmail1"
                                placeholder="Latitude" readonly required>
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Longitude</label>
                            <input name="longitude" type="text" class="form-control long" id="exampleInputEmail1"
                                placeholder="Longitude" readonly required>
                        </div>
                        <div class="form-group">
                            <div style="width: 100%; height:400px;">
                                <div id="map-container-create"
                                    style="height: 100%; width: 100%; display: block; position: relative; margin-bottom: 20px;">
                                </div>
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Tipe Tenant</label>
                            <select name="tipe_tenant_id" class="form-control">
                                <option value="1">Destinasi Wisata</option>
                                <option value="2">Rumah Makan</option>
                                <option value="3">Hotel</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="harga">Harga</label>
                            <input name="harga" type="number" class="form-control" id="harga"
                                placeholder="Harga" required>
                        </div>
                        <div class="form-group">
                            <label>Status</label>
                            <select name="is_status_aktif" class="form-control">
                                <option value="1">Aktif</option>
                                <option value="0">Tidak Aktif</option>
                            </select>
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
    <script>
        $(document).ready(function() {
            const table = $("#table-tenant").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "searching": true,
                "ordering": false,
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





{{-- @section('script')
    <script>
        $(document).ready(function() {
            const table = $("#table-tenant").DataTable({
                "responsive": false,
                "lengthChange": false,
                "autoWidth": false,
                "searching": false,
                "ordering": false,
            });

            // Function to initialize edit button click events
            function initializeEditButtons() {
                $('.btn-edit').off('click').on('click', function() {
                    const targetModal = $(this).attr('_target');
                    const lat = $(this).attr('lat');
                    const long = $(this).attr('long');
                    $(targetModal).modal('show');
                    process(lat, long, $(targetModal).find('.map-container').attr('id'));
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
                process(null, null, 'map-container-create');
            });

            function process(lat, long, container_id) {
                (function() {
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
                    setTimeout(function() {
                        window.dispatchEvent(new Event("resize"));
                    }, 500);

                    const geocoder = L.Control.geocoder({
                        defaultMarkGeocode: false,
                        placeholder: 'Cari lokasi atau desa...',
                        position: 'topleft',
                    }).addTo(map);

                    let marker;
                    if (lat && long) {
                        marker = L.marker([initialLat, initialLong]).addTo(map);
                    }

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

                    // Handle map click events
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
                })();
            }
        });
    </script>
@endsection --}}