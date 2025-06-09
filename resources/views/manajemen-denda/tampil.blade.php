@extends('layout.main')

@section('pagename', 'LAPORAN DENDA')
@section('title', 'ParkBar - Laporan Denda')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">Filter Laporan Denda</div>
                <div class="card-body">
                    <form action="{{ route('laporan.denda') }}" method="GET" class="row">
                        <div class="col-md-4 mb-2">
                            <label for="tanggal_mulai">Tanggal Mulai</label>
                            <input type="date" name="tanggal_mulai" class="form-control"
                                value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="tanggal_selesai">Tanggal Selesai</label>
                            <input type="date" name="tanggal_selesai" class="form-control"
                                value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                        </div>
                        <div class="col-md-4 mb-2">
                            <label for="status">Status Pembayaran</label>
                            <select name="status" class="form-control">
                                <option value="" {{ $status == '' ? 'selected' : '' }}>Semua</option>
                                <option value="Belum Dibayar" {{ $status == 'Belum Dibayar' ? 'selected' : '' }}>Belum
                                    Dibayar</option>
                                <option value="Sudah Dibayar" {{ $status == 'Sudah Dibayar' ? 'selected' : '' }}>Sudah
                                    Dibayar</option>
                            </select>
                        </div>
                        <div class="col-12 mt-3 d-flex justify-content-between">
                            <button type="submit" class="btn btn-primary"><i class="fas fa-filter"></i> Terapkan
                                Filter</button>
                            <a href="{{ route('laporan.denda.cetak', request()->only('tanggal_mulai', 'tanggal_selesai', 'status')) }}"
                                target="_blank" class="btn btn-success"><i class="fas fa-file-pdf"></i> Cetak PDF</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover text-center">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Harga Parkir</th>
                                <th>Denda</th>
                                <th>Total</th>
                                <th>Status</th>
                                <th>Petugas</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataDenda as $denda)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $denda->parkir->plat_kendaraan ?? '-' }}</td>
                                    <td>{{ optional($denda->parkir->waktu_masuk)->format('H:i - d/m/Y') ?? '-' }}</td>
                                    <td>{{ optional($denda->parkir->waktu_keluar)->format('H:i - d/m/Y') ?? '-' }}</td>
                                    <td class="text-right">
                                        Rp{{ number_format($denda->parkir->tarif->tarif ?? 0, 0, ',', '.') }}</td>
                                    <td class="text-right">Rp{{ number_format($denda->nominal, 0, ',', '.') }}</td>
                                    <td class="text-right">
                                        Rp{{ number_format(($denda->parkir->tarif->tarif ?? 0) + $denda->nominal, 0, ',', '.') }}
                                    </td>
                                    <td>
                                        <span
                                            class="badge badge-{{ $denda->status == 'Belum Dibayar' ? 'danger' : 'success' }}">
                                            {{ $denda->status }}
                                        </span>
                                    </td>
                                    <td>{{ $denda->parkir->user->staff->nama ?? '-' }}</td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="9">Tidak ada data denda</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
