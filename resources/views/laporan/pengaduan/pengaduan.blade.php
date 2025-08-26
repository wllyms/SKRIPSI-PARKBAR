@extends('layout.main')

@section('pagename', 'LAPORAN PENGADUAN')
@section('title', 'ParkBar - Laporan Pengaduan')
@section('content')
    <div class="row">
        <!-- Filter Form -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">
                    <i class="fas fa-filter"></i> Filter Laporan Pengaduan
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.pengaduan') }}" method="GET">
                        <div class="row">
                            {{-- Tanggal Mulai --}}
                            <div class="col-md-6 mb-2">
                                <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                            </div>

                            {{-- Tanggal Selesai --}}
                            <div class="col-md-6 mb-2">
                                <label for="tanggal_selesai" class="small font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                    value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                            </div>
                        </div>

                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Terapkan Filter
                            </button>

                            {{-- Tombol Cetak PDF jika diperlukan --}}
                            <a href="{{ route('laporan.pengaduan.cetak', request()->query()) }}" target="_blank"
                                class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>


        <!-- Tabel Laporan Pengaduan -->
        <div class="col-lg-12">
            <div class="card mb-4">
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
