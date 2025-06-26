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

            <hr>
            <div class="d-flex justify-content-between align-items-center mb-2">
                <h5 class="text-primary mb-0">Riwayat Sub Jabatan</h5>
                <button class="btn btn-sm btn-primary" data-toggle="modal" data-target="#modalTambahRiwayat">
                    <i class="fas fa-plus"></i> Tambah Riwayat
                </button>
            </div>
            @if ($data->riwayatSubJabatans && $data->riwayatSubJabatans->count())

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
                <hr>
                <p class="text-muted"><em>Belum ada riwayat sub jabatan.</em></p>
            @endif

            <!-- Modal Tambah Riwayat -->
            <div class="modal fade" id="modalTambahRiwayat" tabindex="-1" aria-labelledby="modalTambahRiwayatLabel"
                aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <form action="{{ route('pegawai.riwayat.store', $data->id) }}" method="POST">
                            @csrf
                            <div class="modal-header">
                                <h5 class="modal-title" id="modalTambahRiwayatLabel">Tambah Riwayat Sub Jabatan</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                    aria-label="Tutup"></button>
                            </div>
                            <div class="modal-body">
                                <div class="form-group mb-3">
                                    <label>Sub Jabatan</label>
                                    <select name="sub_jabatan_id" class="form-control" required>
                                        <option value="">-- Pilih Sub Jabatan --</option>
                                        @foreach ($subjabatans as $sub)
                                            <option value="{{ $sub->id }}"
                                                {{ old('sub_jabatan_id', $data->sub_jabatan_id) == $sub->id ? 'selected' : '' }}>
                                                {{ $sub->nama_sub_jabatan }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Tanggal Mulai</label>
                                    <input type="date" name="tanggal_mulai" class="form-control" required>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Tanggal Selesai</label>
                                    <input type="date" name="tanggal_selesai" class="form-control">
                                    <small class="text-muted">Boleh kosong jika masih aktif</small>
                                </div>

                                <div class="form-group mb-3">
                                    <label>Keterangan</label>
                                    <textarea name="keterangan" class="form-control" rows="2" placeholder="Opsional..."></textarea>
                                </div>
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                <button type="submit" class="btn btn-primary"><i class="fas fa-save"></i> Simpan</button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection
