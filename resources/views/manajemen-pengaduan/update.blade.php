@foreach ($laporan as $data)
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="editModalLabel{{ $data->id }}">Edit Laporan Pengunjung
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('manajemen-pengaduan.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama{{ $data->id }}">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama{{ $data->id }}"
                                value="{{ $data->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="waktu_lapor{{ $data->id }}">Tanggal & Waktu Lapor</label>
                            <input type="datetime-local" name="waktu_lapor" class="form-control"
                                id="waktu_lapor{{ $data->id }}"
                                value="{{ \Carbon\Carbon::parse($data->waktu_lapor)->format('Y-m-d\TH:i') }}">
                        </div>
                        <div class="form-group">
                            <label for="no_telp{{ $data->id }}">No Telp</label>
                            <input type="text" name="no_telp" class="form-control" id="no_telp{{ $data->id }}"
                                value="{{ $data->no_telp }}">
                        </div>
                        <div class="form-group">
                            <label for="keterangan{{ $data->id }}">Keterangan</label>
                            <textarea name="keterangan" class="form-control" id="keterangan{{ $data->id }}">{{ $data->keterangan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Petugas</label>
                            <input type="text" class="form-control" value="{{ $data->user->staff->nama ?? '-' }}"
                                readonly>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
