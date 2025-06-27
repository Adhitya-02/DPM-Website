@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Gambar Tenant</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <button type="button" class="btn btn-primary mb-3" data-toggle="modal" data-target="#modal-default">
                Tambah Data
            </button>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Gambar</th>
                        <th>Adalah Gambar Utama</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td><img width="150px" src="{{ asset('gambar_tenant') . '/' . $d->gambar }}" /></td>
                            <td>{{ $d->is_gambar_utama ? 'Ya' : 'Tidak' }}</td>
                        
                            <td>
                             
                                <form action="{{ route('gambar_tenant.destroy', $d->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger btn-sm">
                                        <i class="fas fa-trash"></i> <!-- Ikon untuk Hapus -->
                                    </button>
                                </form>
                            </td>
                        </tr>
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
                    <h4 class="modal-title">Tambah Gambar Tenant</h4>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{ route('gambar_tenant.tambah_gambar') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="hidden" name="tenant_id" value="{{ $id }}">
                        <div class="form-group">
                            <label for="gambar">Gambar</label>
                            <input name="gambar" type="file" class="form-control" id="gambar"
                                placeholder="gambar" required accept="image/*">
                        </div>
                        <div class="form-group">
                            <label for="gambar_utama">Adalah Gambar Utama</label>
                            <input name="gambar_utama" type="checkbox" class="form-control" id="gambar_utama"
                                placeholder="gambar_utama">
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
