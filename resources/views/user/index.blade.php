@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Pengelola Pengguna</h3>
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

            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default">
                <i class="fas fa-plus"></i> Tambah Pengguna
            </button>
            
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th style="width: 5%">No</th>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor HP</th>
                        <th>Tipe User</th>
                        <th>Tenant</th>
                        <th style="width: 15%">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $index => $user)
                        <tr>
                            <td>{{ $index + 1 }}</td>
                            <td>{{ $user->nama ?? '-' }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp ?? '-' }}</td>
                            <td>
                                @if ($user->tipe_user_id == 1)
                                    <span class="badge badge-primary">Dinas</span>
                                @elseif($user->tipe_user_id == 2)
                                    <span class="badge badge-info">Tenant</span>
                                @else
                                    <span class="badge badge-secondary">Pengunjung</span>
                                @endif
                            </td>
                            <td>
                                @if ($user->tipe_user_id == 2 && isset($user->tenant))
                                    {{ $user->tenant->nama }}
                                @else
                                    <span class="text-muted">-</span>
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#modal-edit-{{ $user->id }}" title="Edit User">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Tombol Reset Password -->
                                <button type="button" class="btn btn-success btn-sm" 
                                    onclick="resetPassword({{ $user->id }}, '{{ $user->nama }}')" title="Reset Password">
                                    <i class="fas fa-key"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <button type="button" class="btn btn-danger btn-sm" 
                                    onclick="deleteUser({{ $user->id }}, '{{ $user->nama }}')" title="Hapus User">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </td>
                        </tr>

                        <!-- Modal Edit User -->
                        <div class="modal fade" id="modal-edit-{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="modalEditLabel{{ $user->id }}" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="modalEditLabel{{ $user->id }}">Edit Pengguna: {{ $user->nama }}</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama{{ $user->id }}">Nama <span class="text-danger">*</span></label>
                                                <input type="text" class="form-control" id="nama{{ $user->id }}" name="nama"
                                                    value="{{ $user->nama }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="email{{ $user->id }}">Email <span class="text-danger">*</span></label>
                                                <input type="email" class="form-control" id="email{{ $user->id }}" name="email"
                                                    value="{{ $user->email }}" required>
                                            </div>
                                            <div class="form-group">
                                                <label for="no_hp{{ $user->id }}">Nomor HP</label>
                                                <input type="text" class="form-control" id="no_hp{{ $user->id }}" name="no_hp"
                                                    value="{{ $user->no_hp }}" placeholder="Contoh: 08123456789">
                                            </div>
                                            <div class="form-group">
                                                <label for="tipe_user_id{{ $user->id }}">Tipe User <span class="text-danger">*</span></label>
                                                <select class="form-control" id="tipe_user_id{{ $user->id }}" name="tipe_user_id" required>
                                                    <option value="1" {{ $user->tipe_user_id == 1 ? 'selected' : '' }}>
                                                        Dinas</option>
                                                    <option value="2" {{ $user->tipe_user_id == 2 ? 'selected' : '' }}>
                                                        Tenant</option>
                                                    <option value="3" {{ $user->tipe_user_id == 3 ? 'selected' : '' }}>
                                                        Pengunjung</option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tenant{{ $user->id }}">Tenant</label>
                                                <select class="form-control" id="tenant{{ $user->id }}" name="tenant">
                                                    <option value="">Pilih Tenant (Opsional)</option>
                                                    @foreach ($tenant as $t)
                                                        @php
                                                            $selected = '';
                                                            if (isset($user->tenant) && $user->tenant->id == $t->id) {
                                                                $selected = 'selected';
                                                            }
                                                        @endphp
                                                        <option value="{{ $t->id }}" {{ $selected }}>
                                                            {{ $t->nama }}
                                                        </option>
                                                    @endforeach
                                                </select>
                                                <small class="form-text text-muted">Hanya diperlukan untuk user dengan tipe "Tenant"</small>
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

    <!-- Modal Tambah User -->
    <div class="modal fade" id="modal-default">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">
                        <i class="fas fa-user-plus"></i> Tambah Pengguna Baru
                    </h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.store') }}" method="POST" id="addUserForm">
                        @csrf
                        <div class="form-group">
                            <label for="nama">Nama <span class="text-danger">*</span></label>
                            <input type="text" class="form-control" id="nama" name="nama" 
                                placeholder="Masukkan nama lengkap" required value="{{ old('nama') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email <span class="text-danger">*</span></label>
                            <input type="email" class="form-control" id="email" name="email" 
                                placeholder="contoh@email.com" required value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_hp">Nomor HP</label>
                            <input type="text" class="form-control" id="no_hp" name="no_hp" 
                                placeholder="08123456789" value="{{ old('no_hp') }}">
                        </div>
                        <div class="form-group">
                            <label for="tipe_user_id">Tipe User <span class="text-danger">*</span></label>
                            <select class="form-control" id="tipe_user_id" name="tipe_user_id" required>
                                <option value="">Pilih Tipe User</option>
                                <option value="1" {{ old('tipe_user_id') == '1' ? 'selected' : '' }}>Dinas</option>
                                <option value="2" {{ old('tipe_user_id') == '2' ? 'selected' : '' }}>Tenant</option>
                                <option value="3" {{ old('tipe_user_id') == '3' ? 'selected' : '' }}>Pengunjung</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="tenant_id">Tenant</label>
                            <select class="form-control" id="tenant_id" name="tenant_id">
                                <option value="">Pilih Tenant (Opsional)</option>
                                @foreach ($tenant as $t)
                                    <option value="{{ $t->id }}" {{ old('tenant_id') == $t->id ? 'selected' : '' }}>
                                        {{ $t->nama }}
                                    </option>
                                @endforeach
                            </select>
                            <small class="form-text text-muted">
                                Hanya diperlukan untuk user dengan tipe "Tenant". Password default: <strong>12345678</strong>
                            </small>
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
        </div>
    </div>

    <!-- Form tersembunyi untuk aksi reset password -->
    <form id="resetPasswordForm" method="POST" style="display: none;">
        @csrf
        @method('POST')
    </form>

    <!-- Form tersembunyi untuk aksi hapus user -->
    <form id="deleteUserForm" method="POST" style="display: none;">
        @csrf
        @method('DELETE')
    </form>

    <script>
        // Fungsi untuk reset password
        function resetPassword(userId, userName) {
            if (confirm('Apakah Anda yakin ingin mereset password untuk user "' + userName + '" ke default (12345678)?')) {
                const form = document.getElementById('resetPasswordForm');
                form.action = "{{ url('user/reset-password') }}/" + userId;
                form.submit();
            }
        }

        // Fungsi untuk hapus user
        function deleteUser(userId, userName) {
            if (confirm('Apakah Anda yakin ingin menghapus user "' + userName + '"?\n\nAksi ini tidak dapat dibatalkan dan akan menghapus semua data terkait user tersebut.')) {
                const form = document.getElementById('deleteUserForm');
                form.action = "{{ route('user.destroy', '') }}/" + userId;
                form.submit();
            }
        }

        // Auto close alerts after 5 seconds
        $(document).ready(function() {
            setTimeout(function() {
                $('.alert').fadeOut('slow');
            }, 5000);

            // DataTable initialization if you're using it
            if (typeof $('#example1').DataTable === 'function') {
                $('#example1').DataTable({
                    "responsive": true,
                    "lengthChange": false,
                    "autoWidth": false,
                    "buttons": ["copy", "csv", "excel", "pdf", "print", "colvis"],
                    "language": {
                        "url": "//cdn.datatables.net/plug-ins/1.10.24/i18n/Indonesian.json"
                    }
                }).buttons().container().appendTo('#example1_wrapper .col-md-6:eq(0)');
            }
        });

        // Form validation untuk modal tambah user
        document.getElementById('addUserForm').addEventListener('submit', function(e) {
            const nama = document.getElementById('nama').value.trim();
            const email = document.getElementById('email').value.trim();
            const tipeUser = document.getElementById('tipe_user_id').value;

            if (!nama || !email || !tipeUser) {
                e.preventDefault();
                alert('Mohon lengkapi semua field yang wajib diisi (bertanda *)');
                return false;
            }

            // Email validation
            const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
            if (!emailRegex.test(email)) {
                e.preventDefault();
                alert('Format email tidak valid');
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
    </style>

@endsection