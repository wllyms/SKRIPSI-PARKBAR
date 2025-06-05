@extends('layout.main')

@section('pagename', 'MANAJEMEN PARKIR')
@section('title', 'ParkBar - Parkir')
@section('content')

    <div class="row">
        <div class="col-lg-12">
            <div class="card mb-4">

                {{-- Notifikasi --}}
                <div>
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            {!! session('success') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                    @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                {{-- Header --}}
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Parkiran</h6>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                        Tambah
                    </button>
                </div>

                {{-- Tabel --}}
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Jenis Tarif</th>
                                <th>Waktu Masuk</th>
                                <th>Waktu Keluar</th>
                                <th>Status</th>
                                <th>Petugas</th>
                                <th class="text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parkir as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>
                                        {{ $data->tarif->jenis_tarif ?? '-' }} -
                                        {{ $data->tarif->kategori->nama_kategori ?? '-' }}
                                    </td>
                                    <td>{{ \Carbon\Carbon::parse($data->waktu_masuk)->format('H:i - d/m/Y') }}</td>
                                    <td>
                                        @if ($data->waktu_keluar)
                                            {{ \Carbon\Carbon::parse($data->waktu_keluar)->format('H:i - d/m/Y') }}
                                        @else
                                            <span class="text-muted">-</span>
                                        @endif
                                    </td>

                                    <td>
                                        @if ($data->status == 'Terparkir')
                                            <span class="badge badge-secondary">Terparkir</span>
                                        @else
                                            <span class="badge badge-success">Keluar</span>
                                        @endif
                                    </td>
                                    <td>{{ $data->user->staff->nama ?? '-' }}</td>
                                    <td class="text-center">
                                        {{-- Cetak Barcode --}}
                                        <a class="btn btn-info btn-sm text-white"
                                            href="{{ route('manajemen-parkir.cetak-parkir', $data->id) }}"
                                            title="Cetak Tiket Parkir">
                                            <i class="fas fa-barcode"></i> Cetak
                                        </a>

                                        {{-- Hapus Data --}}
                                        <a class="btn btn-danger btn-sm text-white" data-toggle="modal"
                                            data-target="#deleteModal{{ $data->id }}" title="Hapus Data Parkir">
                                            <i class="fas fa-trash-alt"></i> Hapus
                                        </a>

                                        {{-- Manual Keluar --}}
                                        @if ($data->status == 'Terparkir')
                                            <a class="btn btn-warning btn-sm text-white" data-toggle="modal"
                                                data-target="#keluarModal{{ $data->id }}" title="Proses Keluar Manual">
                                                <i class="fas fa-sign-out-alt"></i> Keluar
                                            </a>
                                        @endif
                                    </td>

                                </tr>

                                {{-- Modal Keluar --}}
                                <div class="modal fade" id="keluarModal{{ $data->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="keluarModalLabel{{ $data->id }}" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-gradient-danger">
                                                <h5 class="modal-title text-white"
                                                    id="keluarModalLabel{{ $data->id }}">
                                                    Proses Parkir Keluar
                                                </h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('manajemen-parkir.keluar', $data->id) }}"
                                                method="POST">
                                                @csrf
                                                @method('PUT')
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="waktu_keluar">Waktu Keluar</label>
                                                        <input type="datetime-local" class="form-control"
                                                            name="waktu_keluar" required
                                                            value="{{ \Carbon\Carbon::now()->format('Y-m-d\TH:i') }}">
                                                    </div>

                                                    <div class="alert alert-warning">
                                                        Pastikan waktu keluar lebih lambat dari waktu masuk.<br>
                                                        Denda dikenakan jika melebihi batas jam parkir (contoh: 12 jam
                                                        NON-INAP, 24 jam INAP).
                                                    </div>
                                                </div>

                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-secondary"
                                                        data-dismiss="modal">Batal</button>
                                                    <button type="submit" class="btn btn-danger">Proses Keluar</button>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>

                                {{-- Modal Hapus --}}
                                @include('manajemen-parkir.delete', ['id' => $data->id])
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Tambah -->
    @include('manajemen-parkir.tambah')

@endsection
