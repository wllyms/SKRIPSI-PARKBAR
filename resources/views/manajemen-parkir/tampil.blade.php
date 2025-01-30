@extends('layout.main')

@section('pagename', 'Manajemen Parkir')
@section('title', 'ParkBar - Parkir')
@section('content')

    <div class="row">
        <!-- Datatables -->
        <div class="col-lg-12">
            <div class="card mb-4">
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
                        <div class="alert alert-dagger alert-dismissible" role="alert">
                            {!! session('error') !!}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
                </div>

                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <h6 class="m-0 font-weight-bold text-primary">Data Parkiran</h6>
                    <div>
                        <!-- Button Modal -->
                        <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tambahModal">
                            Tambah
                        </button>
                    </div>
                </div>
                <div class="table-responsive p-3">
                    <table class="table align-items-center table-flush" id="dataTable">
                        <thead class="thead-light">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Jenis tarif</th>
                                {{-- <th>Tarif</th> --}}
                                <th>Jam Masuk</th>
                                <th>Jam Keluar</th>
                                <th>Tanggal</th>
                                <th>Status</th>
                                <th class="d-flex justify-content-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($parkir as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ $data->tarif->jenis_tarif }}</td>
                                    {{-- <td>{{ $data->tarif->tarif }}</td> --}}
                                    <td>{{ $data->jam_masuk }}</td>
                                    <td>{{ $data->jam_keluar }}</td>
                                    <td>{{ \Carbon\Carbon::parse($data->tanggal)->format('d-m-Y') }}</td>
                                    <td>
                                        @if ($data->status == 'Terparkir')
                                            <span class="badge badge-secondary">
                                                Terparkir
                                            </span>
                                        @else
                                            <span class="badge badge-success">Keluar</span>
                                        @endif

                                    </td>
                                    <td class="d-flex justify-content-center text-white">
                                        <a class="btn btn-info btn-sm mr-1"
                                            href="{{ route('manajemen-parkir.cetak-parkir', $data->id) }}">
                                            <i class="fa fa-id-card"></i>
                                        </a>
                                        <a class="btn btn-danger btn-sm mr-1" data-toggle="modal"
                                            data-target="#deleteModal{{ $data->id }}">
                                            <i class="fa fa-trash"></i>
                                        </a>
                                        <a class="btn btn-primary btn-sm" data-toggle="modal"
                                            data-target="#keluarModal{{ $data->id }}">
                                            Manual
                                        </a>
                                    </td>
                                </tr>

                                {{-- Modal Keluar Manual --}}
                                <div class="modal fade" id="keluarModal{{ $data->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="tambahModalLabel" aria-hidden="true">
                                    <div class="modal-dialog" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-gradient-primary">
                                                <h5 class="modal-title text-white" id="tambahModalLabel">Parkir Keluar</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <form action="{{ route('manajemen-parkir.keluar', $data->id) }}"
                                                method="POST">
                                                @method('PUT')
                                                @csrf
                                                <div class="modal-body">
                                                    <div class="form-group">
                                                        <label for="plat_kendaraan">Plat Kendaraan</label>
                                                        <input type="text" class="form-control" name="plat_kendaraan"
                                                            id="plat_kendaraan" value="{{ $data->plat_kendaraan }}"
                                                            readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jenis_tarif">Tarif</label>
                                                        <input type="text" class="form-control" name="jenis_tarif"
                                                            id="jenis_tarif" value="{{ $data->tarif->jenis_tarif }}"
                                                            readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jam_masuk">Jam Masuk</label>
                                                        <input type="text" class="form-control" name="jam_masuk"
                                                            id="jam_masuk" value="{{ $data->jam_masuk }}" readonly>
                                                    </div>
                                                    <div class="form-group">
                                                        <label for="jam_keluar">Jam Keluar</label>
                                                        <input type="text" class="form-control" name="jam_keluar"
                                                            id="jam_keluar"
                                                            value="{{ \Carbon\Carbon::parse($jam)->format('H:i') }}"
                                                            readonly>
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-dismiss="modal">Kembali</button>
                                                        <button type="submit" class="btn btn-primary">Keluar</button>
                                                    </div>
                                                </div>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            @endforeach

                            <!---- Modal Tambah ---->
                            @include('manajemen-parkir.tambah')

                            <!---- Modal Tambah ---->
                            @include('manajemen-parkir.delete')

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection
