@extends('layout.main')

@section('title', 'Riwayat Pegawai')
@section('content')

    <div class="card">
        <div class="card-header bg-primary text-white">
            <h5 class="mb-0">Riwayat Sub Jabatan - {{ $pegawai->nama }}</h5>
        </div>

        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <form action="{{ route('manajemen-pegawai.riwayat.tambah', $pegawai->id) }}" method="POST">
                @csrf
                <div class="form-row">
                    <div class="form-group col-md-6">
                        <label>Sub Jabatan</label>
                        <select name="sub_jabatan_id" class="form-control" required>
                            <option value="">-- Pilih Sub Jabatan --</option>
                            @foreach ($subjabatan as $sub)
                                <option value="{{ $sub->id }}">{{ $sub->nama_sub_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tanggal Mulai</label>
                        <input type="date" name="tanggal_mulai" class="form-control" required>
                    </div>
                    <div class="form-group col-md-3">
                        <label>Tanggal Selesai</label>
                        <input type="date" name="tanggal_selesai" class="form-control">
                    </div>
                </div>
                <div class="form-group">
                    <label>Keterangan (Opsional)</label>
                    <textarea name="keterangan" class="form-control" rows="2"></textarea>
                </div>
                <button type="submit" class="btn btn-primary">Tambah Riwayat</button>
            </form>

            <hr>

            <h6>Daftar Riwayat:</h6>
            <table class="table table-bordered mt-3">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Sub Jabatan</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Keterangan</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($pegawai->riwayatSubJabatans as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nama_sub_jabatan }}</td>
                            <td>{{ \Carbon\Carbon::parse($item->pivot->tanggal_mulai)->format('d-m-Y') }}</td>
                            <td>{{ $item->pivot->tanggal_selesai ? \Carbon\Carbon::parse($item->pivot->tanggal_selesai)->format('d-m-Y') : '-' }}
                            </td>
                            <td>{{ $item->pivot->keterangan ?? '-' }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5">Belum ada riwayat.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

@endsection
