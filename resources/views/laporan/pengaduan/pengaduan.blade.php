@extends('layout.main')

@section('pagename', 'LAPORAN PENGADUAN')
@section('title', 'ParkBar - Laporan Pengaduan')
@section('content')
    <div class="row">
        <!-- Filter Form -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <form action="{{ route('laporan.pengaduan') }}" method="GET">
                        <div class="row mb-1">
                            <!-- Filter Tanggal Mulai -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_mulai">Tanggal Mulai</label>
                                    <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                        value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                                </div>
                            </div>
                            <!-- Filter Tanggal Selesai -->
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="tanggal_selesai">Tanggal Selesai</label>
                                    <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                        value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                                </div>
                            </div>
                        </div>
                        <!-- Tombol Filter -->
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan Pengaduan -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <a href="{{ route('laporan.pengaduan.cetak', ['tanggal_mulai' => request('tanggal_mulai', $tanggalMulai), 'tanggal_selesai' => request('tanggal_selesai', $tanggalSelesai)]) }}"
                        target="_blank" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> Cetak
                    </a>
                    <h6 class="mb-0 font-weight-bold text-primary">Data Pengaduan Pengunjung</h6>
                </div>
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered" id="dataTable" style="margin-top: 20px;">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Nama</th>
                                <th>Tanggal & Waktu Lapor</th>
                                <th>No Telp</th>
                                <th>Keterangan</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($laporan as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->waktu_lapor)->format('d-m-Y H:i') }}</td>
                                    <td>{{ $data->no_telp }}</td>
                                    <td>{{ $data->keterangan }}</td>
                                    <td>{{ $data->user->staff->nama ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
