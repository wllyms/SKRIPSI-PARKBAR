@extends('layout.main')

@section('pagename', 'Tambah Riwayat Sub Jabatan')
@section('title', 'ParkBar - Tambah Riwayat')
@section('content')

    <div class="card shadow mb-4">
        <div class="card-header py-3 d-flex justify-content-between align-items-center">
            <h5 class="m-0 text-primary">Tambah Riwayat Sub Jabatan: {{ $pegawai->nama }}</h5>
            <a href="{{ route('manajemen-pegawai.show', $pegawai->id) }}" class="btn btn-secondary btn-sm">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>

        <div class="card-body">
            @if ($errors->any())
                <div class="alert alert-danger">
                    <strong>Terjadi kesalahan!</strong>
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li style="font-size: 14px;">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            <form action="{{ route('pegawai.riwayat.store', $pegawai->id) }}" method="POST">
                @csrf
                <div class="form-group mb-3">
                    <label>Sub Jabatan</label>
                    <select name="sub_jabatan_id" class="form-control" required>
                        <option value="">-- Pilih Sub Jabatan --</option>
                        @foreach ($subjabatans as $sub)
                            <option value="{{ $sub->id }}">{{ $sub->nama_sub_jabatan }}</option>
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
                    <small class="form-text text-muted">Kosongkan jika masih aktif</small>
                </div>

                <div class="form-group mb-4">
                    <label>Keterangan</label>
                    <textarea name="keterangan" class="form-control" rows="3"></textarea>
                </div>

                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save"></i> Simpan Riwayat
                </button>
            </form>
        </div>
    </div>

@endsection
