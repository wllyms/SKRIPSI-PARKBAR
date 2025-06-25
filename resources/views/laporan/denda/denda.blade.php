@extends('layout.main')

@section('pagename', 'LAPORAN DENDA')
@section('title', 'ParkBar - Laporan Denda')

@section('content')
    <div class="row">
        <!-- Filter Card -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">Filter Laporan Denda</div>
                <div class="card-body">
                    <form action="{{ route('laporan.denda') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai"
                                    value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_selesai" class="small font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai"
                                    value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="status" class="small font-weight-bold">Status Pembayaran</label>
                                <select class="form-control" name="status">
                                    <option value="">Semua</option>
                                    <option value="Belum Dibayar"
                                        {{ request('status') == 'Belum Dibayar' ? 'selected' : '' }}>Belum Dibayar</option>
                                    <option value="Sudah Dibayar"
                                        {{ request('status') == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah Dibayar</option>
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Terapkan
                                Filter</button>
                            <a href="{{ route('laporan.denda.cetak', ['tanggal_mulai' => request('tanggal_mulai', $tanggalMulai), 'tanggal_selesai' => request('tanggal_selesai', $tanggalSelesai), 'status' => request('status')]) }}"
                                target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Data -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Tarif Parkir</th>
                                <th>Denda</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataDenda as $denda)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $denda->parkir->plat_kendaraan ?? '-' }}</td>
                                    <td class="text-center">
                                        {{ $denda->parkir->waktu_masuk ? \Carbon\Carbon::parse($denda->parkir->waktu_masuk)->format('H:i - d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-center">
                                        {{ $denda->parkir->waktu_keluar ? \Carbon\Carbon::parse($denda->parkir->waktu_keluar)->format('H:i - d/m/Y') : '-' }}
                                    </td>
                                    <td class="text-right">
                                        Rp{{ number_format($denda->parkir->tarif->tarif ?? 0, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        Rp{{ number_format($denda->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-right">
                                        Rp{{ number_format(($denda->parkir->tarif->tarif ?? 0) + $denda->nominal, 0, ',', '.') }}
                                    </td>
                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $denda->status === 'Belum Dibayar' ? 'danger' : 'success' }}">
                                            {{ $denda->status }}
                                        </span>
                                    </td>
                                    <td class="text-center">{{ $denda->parkir->user->staff->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9" class="text-center">Tidak ada data denda</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>

                </div>
            </div>
        </div>
    </div>
@endsection
