@extends('layout.main')

@section('pagename', 'Detail Pegawai')
@section('title', 'ParkBar - Detail Pegawai')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Detail Pegawai: {{ $data->nama }}</h5>
            <a href="{{ route('laporan.detailpegawai.cetak', $data->id) }}" target="_blank" class="btn btn-success">
                <i class="fas fa-print"></i> Cetak PDF
            </a>
        </div>

        <div class="card-body">
            <div class="row mb-4 align-items-center">
                <div class="col-md-3 text-center">
                    @if ($data->image)
                        <img src="{{ asset('storage/' . $data->image) }}" class="rounded shadow-sm border"
                            style="width: 160px; height: 220px; object-fit: cover;" alt="Foto Pegawai">
                    @else
                        <div class="text-muted"><em>Tidak ada foto</em></div>
                    @endif
                </div>
                <div class="col-md-9">
                    <div class="row">
                        <div class="col-md-6 mb-2">
                            <strong>Nama:</strong><br>{{ $data->nama }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Plat Kendaraan:</strong><br>{{ $data->plat_kendaraan }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>No Telp:</strong><br>{{ $data->no_telp }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Email:</strong><br>{{ $data->email }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Alamat:</strong><br>{{ $data->alamat }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Merk Kendaraan:</strong><br>{{ $data->merk_kendaraan }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Jabatan:</strong><br>{{ $data->jabatan->nama_jabatan ?? '-' }}
                        </div>
                        <div class="col-md-6 mb-2">
                            <strong>Sub Jabatan:</strong><br>{{ $data->subjabatan->nama_sub_jabatan ?? '-' }}
                        </div>
                    </div>
                </div>
            </div>

            @if ($data->riwayatSubJabatans && $data->riwayatSubJabatans->count())
                <hr>
                <h5 class="text-primary">Riwayat Sub Jabatan</h5>
                <div class="table-responsive">
                    <table class="table table-bordered mt-2">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>Sub Jabatan</th>
                                <th>Tanggal Mulai</th>
                                <th>Tanggal Selesai</th>
                                <th>Keterangan</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->riwayatSubJabatans as $riwayat)
                                <tr>
                                    <td>{{ $riwayat->nama_sub_jabatan }}</td>
                                    <td>{{ \Carbon\Carbon::parse($riwayat->pivot->tanggal_mulai)->format('d-m-Y') }}</td>
                                    <td>{{ $riwayat->pivot->tanggal_selesai ? \Carbon\Carbon::parse($riwayat->pivot->tanggal_selesai)->format('d-m-Y') : '-' }}
                                    </td>
                                    <td>{{ $riwayat->pivot->keterangan ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <p class="text-muted"><em>Belum ada riwayat sub jabatan.</em></p>
            @endif
        </div>
    </div>

@endsection
