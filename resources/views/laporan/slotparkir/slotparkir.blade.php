@extends('layout.main')

@section('pagename', 'LAPORAN SLOT PARKIR')
@section('title', 'ParkBar - Laporan Slot Parkir')

@section('content')
    <div class="row">
        <!-- Filter Card -->
        <div class="col-lg-12">
            <div class="card mb-4 shadow-sm">
                <div class="card-header font-weight-bold text-primary">Filter Slot Parkir</div>
                <div class="card-body">
                    <form action="{{ route('laporan.slot') }}" method="GET">
                        <div class="row">
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_mulai" class="small font-weight-bold">Tanggal Mulai</label>
                                <input type="date" class="form-control" name="tanggal_mulai" id="tanggal_mulai"
                                    value="{{ request('tanggal_mulai', $tanggalMulai) }}">
                            </div>
                            <div class="col-md-4 mb-2">
                                <label for="tanggal_selesai" class="small font-weight-bold">Tanggal Selesai</label>
                                <input type="date" class="form-control" name="tanggal_selesai" id="tanggal_selesai"
                                    value="{{ request('tanggal_selesai', $tanggalSelesai) }}">
                            </div>

                            <div class="col-md-4 mb-2">
                                <label for="slot_id" class="small font-weight-bold">Slot Parkir</label>
                                <select class="form-control" name="slot_id" id="slot_id">
                                    <option value="">Semua Slot</option>
                                    @foreach ($semuaSlot as $s)
                                        <option value="{{ $s->id }}"
                                            {{ request('slot_id') == $s->id ? 'selected' : '' }}>
                                            {{ $s->nama_slot }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="d-flex justify-content-between mt-3">
                            <button type="submit" class="btn btn-primary">
                                <i class="fas fa-filter"></i> Terapkan Filter
                            </button>
                            <a href="{{ route('laporan.slot.pdf', request()->query()) }}" target="_blank"
                                class="btn btn-success">
                                <i class="fas fa-file-pdf"></i> Cetak PDF
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <!-- Data Table -->
        <div class="col-lg-12">
            <div class="card mb-4">
                <div class="card shadow-sm">
                    <div class="card-body table-responsive">
                        <table class="table table-bordered table-hover" id="dataTable">
                            <thead class="thead-light text-center">
                                <tr>
                                    <th>No</th>
                                    <th>Nama Slot</th>
                                    <th>Kapasitas</th>
                                    <th>Terisi Sekarang</th>
                                    <th>Total Keluar</th>
                                    <th>Riwayat Terisi (Masuk)</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse ($dataSlot as $slot)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $slot->nama_slot }}</td>
                                        <td class="text-center">{{ $slot->kapasitas }}</td>

                                        {{-- Kendaraan yg saat ini sedang terparkir di slot --}}
                                        <td class="text-center">{{ $slot->terpakai_sekarang ?? 0 }}</td>

                                        {{-- Kendaraan yg keluar selama filter tanggal --}}
                                        <td class="text-center">{{ $slot->total_keluar ?? 0 }}</td>

                                        {{-- Riwayat kendaraan masuk selama filter tanggal --}}
                                        <td class="text-center">{{ $slot->riwayat_terisi ?? 0 }}</td>



                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="7" class="text-center">Data tidak ditemukan</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
