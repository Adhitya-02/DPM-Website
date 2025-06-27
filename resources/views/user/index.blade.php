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
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default">
                Tambah
            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Email</th>
                        <th>Nomor Hp</th>
                        <th>Tipe User</th>
                        <th>Tenant</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $user)
                        <tr>
                            <td>{{ $user->nama }}</td>
                            <td>{{ $user->email }}</td>
                            <td>{{ $user->no_hp }}</td>
                            <td>
                                @if ($user->tipe_user_id == 1)
                                    Dinas
                                @elseif($user->tipe_user_id == 2)
                                    Tenant
                                @else
                                    Pengunjung
                                @endif
                            </td>
                            <td>
                                @if ($user->tipe_user_id == 2)
                                    {{ $user->tenant->nama ?? '' }}
                                @endif
                            </td>
                            <td>
                                <!-- Tombol Edit -->
                                <button type="button" class="btn btn-warning btn-sm" data-toggle="modal"
                                    data-target="#modal-edit-{{ $user->id }}">
                                    <i class="fas fa-edit"></i>
                                </button>

                                <!-- Tombol Hapus -->
                                <form action="{{ route('user.destroy', $user->id) }}" method="POST"
                                    style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>

                                <!-- Tombol Reset Password -->
                                <form action="{{ route('user.update', $user->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('PUT')
                                    <input type="hidden" name="password" value="12345678">
                                    <button type="submit" class="btn btn-success btn-sm">
                                        <i class="fas fa-key"></i>
                                    </button>
                                </form>
                            </td>

                        </tr>

                        <div class="modal fade" id="modal-edit-{{ $user->id }}" tabindex="-1" role="dialog"
                            aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <form action="{{ route('user.update', $user->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">Edit Pengguna</h5>
                                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <div class="modal-body">
                                            <div class="form-group">
                                                <label for="nama">Nama</label>
                                                <input type="text" class="form-control" id="nama" name="nama"
                                                    value="{{ $user->nama }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="email">Email</label>
                                                <input type="email" class="form-control" id="email" name="email"
                                                    value="{{ $user->email }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="no_hp">Nomor HP</label>
                                                <input type="text" class="form-control" id="no_hp" name="no_hp"
                                                    value="{{ $user->no_hp }}">
                                            </div>
                                            <div class="form-group">
                                                <label for="tipe_user_id">Tipe User</label>
                                                <select class="form-control" id="tipe_user_id" name="tipe_user_id">
                                                    <option value="1"
                                                        {{ $user->tipe_user_id == 1 ? 'selected' : '' }}>
                                                        Dinas</option>
                                                    <option value="2"
                                                        {{ $user->tipe_user_id == 2 ? 'selected' : '' }}>
                                                        Tenant</option>
                                                    </option>
                                                </select>
                                            </div>
                                            <div class="form-group">
                                                <label for="tenant">Tenant</label>
                                                <select class="form-control" id="tenant" name="tenant">
                                                    <option value="">Pilih Tenant</option>
                                                    @foreach ($tenant as $t)
                                                        @if ($user->tipe_user_id == 2 || $user->tipe_tenant_id == 1)
                                                            <option value="{{ $t->id }}"
                                                                {{ $user->tenant->id == $t->id ? 'selected' : '' }}>
                                                                {{ $t->nama }}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
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
                    <h4 class="modal-title">Tambah Pengguna</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('user.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nama</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nama"
                                name="nama">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Email</label>
                            <input type="email" class="form-control" id="exampleInputEmail1" placeholder="Email"
                                name="email">
                        </div>
                        <div class="form-group">
                            <label for="exampleInputEmail1">Nomor HP</label>
                            <input type="text" class="form-control" id="exampleInputEmail1" placeholder="Nomor HP"
                                name="no_hp">
                        </div>
                        <div class="form-group">
                            <label>Tipe User</label>
                            <select class="form-control" name="tipe_user_id">
                                <option value="1">
                                    Dinas</option>
                                <option value="2">
                                    Tenant</option>
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Tenant</label>
                            <select class="form-control" name="tenant_id">
                                <option value="">Pilih Tenant</option>
                                @foreach ($tenant as $t)
                                    <option value="{{ $t->id }}">{{ $t->nama }}</option>
                                @endforeach
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
