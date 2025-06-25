@extends('layout.main')

@section('pagename', 'LAPORAN PEGAWAI')
@section('title', 'ParkBar - Laporan Pegawai')
@section('content')

    <style>
        /* General Styles */
        body {
            font-family: 'Arial', sans-serif;
        }

        /* Card Styling */
        .card {
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0px 2px 6px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
        }

        /* Form Styling */
        .form-control {
            border-radius: 4px;
            padding: 10px;
        }

        button.btn {
            border-radius: 4px;
            padding: 8px 16px;
        }

        /* Table Styling */
        .table {
            margin-top: 20px;
        }

        .table th {
            background-color: #f8f9fa;
            color: #333;
            text-align: center;
            font-weight: bold;
            vertical-align: middle;
        }

        .table td {
            text-align: center;
            vertical-align: middle;
        }

        .table-responsive {
            overflow-x: auto;
            padding: 20px;
        }

        /* Modal Styling */
        .modal-content {
            border-radius: 10px;
            box-shadow: 0px 4px 10px rgba(0, 0, 0, 0.2);
        }

        .modal-header {
            background-color: #007bff;
            color: #fff;
            border-bottom: 1px solid #ddd;
        }

        .modal-body {
            padding: 20px;
        }

        .modal-footer {
            padding: 15px;
            text-align: right;
        }

        /* Photo Styling */
        .img-fluid {
            max-width: 150px;
            max-height: 150px;
            object-fit: cover;
            border-radius: 8px;
            box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.2);
        }

        /* Button Styling */
        .btn {
            padding: 8px 12px;
            font-size: 14px;
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            color: #fff;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #0056b3;
        }

        .btn-success {
            background-color: #28a745;
            border-color: #28a745;
            color: #fff;
        }

        .btn-success:hover {
            background-color: #218838;
            border-color: #1e7e34;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
            color: #fff;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }
    </style>
    <div class="row">
        <!-- Filter Form -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                    <form action="{{ route('laporan.pegawai') }}" method="GET">
                        <!-- Filter Jenis Pegawai -->
                        <div class="row mb-1">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="jenis_pegawai">Kategori Pegawai</label>
                                    <select class="form-control" name="jenis_pegawai" id="jenis_pegawai">
                                        <option value="">Semua</option>
                                        @foreach ($jenis_pegawai as $jenis)
                                            <option value="{{ $jenis->id }}"
                                                {{ request('jenis_pegawai') == $jenis->id ? 'selected' : '' }}>
                                                {{ $jenis->jenis_pegawai }}
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="row mb-3">
                            <div class="col-md-6 d-flex align-items-end">
                                <button type="submit" class="btn btn-primary">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Tabel Laporan Pegawai -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <!-- Header Judul dan Tombol Cetak -->
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="m-0 text-primary">Laporan Data Pegawai</h5>
                    <a href="{{ route('laporan.pegawai.cetak', ['jenis_pegawai' => request('jenis_pegawai')]) }}"
                        target="_blank" class="btn btn-success">
                        <i class="fas fa-file-pdf"></i> Cetak PDF
                    </a>
                </div>

                <!-- Tabel Data -->
                <div class="table-responsive p-3">
                    <table class="table table-striped table-bordered" id="dataTable" style="margin-top: 20px;">
                        <thead class="thead-light text-center">
                            <tr>
                                <th>No</th>
                                <th>Plat Kendaraan</th>
                                <th>Nama</th>
                                <th>No. Telp</th>
                                <th>Kategori Pegawai</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($pegawai as $data)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $data->plat_kendaraan }}</td>
                                    <td>{{ $data->nama }}</td>
                                    <td>{{ $data->no_telp }}</td>
                                    <td>{{ $data->jenisPegawai->jenis_pegawai ?? '-' }}</td>
                                    <td>
                                        <button class="btn btn-info btn-sm" data-toggle="modal"
                                            data-target="#detailModal{{ $data->id }}">
                                            <i class="fas fa-eye"></i>
                                        </button>
                                    </td>
                                </tr>

                                <!-- Modal Detail Pegawai -->
                                <div class="modal fade" id="detailModal{{ $data->id }}" tabindex="-1" role="dialog"
                                    aria-labelledby="tambahModalLabel" aria-hidden="true">
                                    <div class="modal-dialog modal-xl" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header bg-primary">
                                                <h5 class="modal-title text-white">Detail Pegawai</h5>
                                                <button type="button" class="close text-white" data-dismiss="modal"
                                                    aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>

                                            <div class="modal-body">
                                                <div class="row">
                                                    <div class="col-md-4 text-center">
                                                        @if ($data->image)
                                                            <img src="{{ asset('storage/' . $data->image) }}"
                                                                alt="Foto Pegawai" class="img-fluid rounded shadow">
                                                        @else
                                                            <p><em>Tidak ada foto yang diunggah</em></p>
                                                        @endif
                                                    </div>
                                                    <div class="col-md-8">
                                                        <p><strong>Nama Lengkap:</strong> {{ $data->nama }}</p>
                                                        <p><strong>Plat Kendaraan:</strong> {{ $data->plat_kendaraan }}</p>
                                                        <p><strong>No Telp:</strong> {{ $data->no_telp }}</p>
                                                        <p><strong>Email:</strong> {{ $data->email }}</p>
                                                        <p><strong>Alamat:</strong> {{ $data->alamat }}</p>
                                                        <p><strong>Merk Kendaraan:</strong> {{ $data->merk_kendaraan }}</p>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="modal-footer">
                                                <a href="{{ route('laporan.detailpegawai.cetak', $data->id) }}"
                                                    target="_blank" class="btn btn-primary">
                                                    <i class="fas fa-print"></i> Cetak
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>

    </div>
@endsection
