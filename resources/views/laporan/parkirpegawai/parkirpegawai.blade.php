@extends('layout.main')

@section('pagename', 'LAPORAN PARKIR PEGAWAI')
@section('title', 'ParkBar - Laporan Parkir Pegawai')

@section('content')
    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">
                    <i class="fas fa-filter"></i> Filter Laporan
                </div>
                <div class="card-body">
                    <form action="{{ route('laporan.parkirpegawai') }}" method="GET">
                        <div class="form-row align-items-end">
                            <div class="form-group col-md-4">
                                <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                            </div>
                            <div class="form-group col-md-4">
                                <label for="tanggal_selesai" class="small font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                    value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                            </div>
                            <div class="form-group col-md-2">
                                <button type="submit" class="btn btn-primary w-100">Terapkan</button>
                            </div>
                            <div class="form-group col-md-2">
                                {{-- REVISI: Tombol Cetak sekarang membawa filter yang aktif --}}
                                <a href="{{ route('laporan.parkirpegawai.cetak', request()->query()) }}" target="_blank"
                                    class="btn btn-success w-100">
                                    <i class="fas fa-file-pdf"></i> Cetak PDF
                                </a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header">
                    <h6 class="m-0 font-weight-bold text-primary">Data Riwayat Parkir Pegawai</h6>
                </div>
                <div class="card-body table-responsive">
                    <table class="table table-bordered table-hover" id="dataTable">
                        <thead class="thead-light text-center">
                            <tr>
                                <th style="width: 5%;">No</th>
                                <th>Nama Pegawai</th>
                                <th>Kode Member</th>
                                <th>Plat Kendaraan</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Durasi</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($dataParkir as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td>{{ $data->pegawai->nama ?? '-' }}</td>
                                    <td class="text-center">{{ $data->kode_member }}</td>
                                    <td class="text-uppercase text-center">{{ $data->plat_kendaraan }}</td>

                                    {{-- REVISI: Menampilkan Waktu Masuk --}}
                                    <td class="text-center">{{ $data->waktu_masuk->format('d-m-Y H:i') }}</td>

                                    {{-- REVISI: Menampilkan Waktu Keluar (jika ada) --}}
                                    <td class="text-center">
                                        @if ($data->waktu_keluar)
                                            {{ $data->waktu_keluar->format('d-m-Y H:i') }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    {{-- REVISI: Menampilkan Durasi (jika sudah keluar) --}}
                                    <td class="text-center">
                                        @if ($data->waktu_keluar)
                                            {{ $data->waktu_masuk->diffForHumans($data->waktu_keluar, true) }}
                                        @else
                                            -
                                        @endif
                                    </td>

                                    <td class="text-center">
                                        <span
                                            class="badge badge-{{ $data->status == 'Keluar' ? 'secondary' : 'success' }}">
                                            {{ $data->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="8" class="text-center">Data tidak ditemukan</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
