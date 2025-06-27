@extends('layout')
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">Booking Report</h3>
        </div>
        <!-- /.card-header -->
        <div class="card-body">
            <form method="GET" action="{{ route('tenant_report.index') }}">
                <div class="form-group">
                    <label for="tenant_filter">Filter Tenant:</label>
                    <select name="tenant_filter" id="tenant_filter" class="form-control">
                        <option value="">Semua Tenant</option>
                        @foreach ($tenants as $tenant)
                            <option value="{{ $tenant->id }}" {{ request('tenant_filter') == $tenant->id ? 'selected' : '' }}>
                                {{ $tenant->nama }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
            </form>
            <br/>
            <table id="example1" class="table table-bordered table-striped">
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>Jumlah Pengunjung</th>
                        <th>Tenant</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($data as $d)
                        <tr>
                            <td>{{ $d->tanggal }}</td>
                            <td>{{ $d->jumlah_pengunjung }}</td>
                            <td>{{ $d->tenant_name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <!-- /.card-body -->
    </div>
@endsection
