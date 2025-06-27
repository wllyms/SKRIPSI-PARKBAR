@foreach ($kuesioner as $data)
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="editModalLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editModalLabel{{ $data->id }}">Edit Pertanyaan</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form action="{{ route('kuesioner.update', $data->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="teks_pertanyaan">Teks Pertanyaan</label>
                            <textarea class="form-control" name="teks_pertanyaan" required rows="3">{{ $data->teks_pertanyaan }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select name="kategori" class="form-control" required>
                                <option value="fasilitas" {{ $data->kategori == 'fasilitas' ? 'selected' : '' }}>
                                    Fasilitas</option>
                                <option value="petugas" {{ $data->kategori == 'petugas' ? 'selected' : '' }}>Petugas
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select name="status" class="form-control" required>
                                <option value="aktif" {{ $data->status == 'aktif' ? 'selected' : '' }}>Aktif</option>
                                <option value="nonaktif" {{ $data->status == 'nonaktif' ? 'selected' : '' }}>Non-aktif
                                </option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="urutan">Nomor Urut Tampilan</label>
                            <input type="number" class="form-control" name="urutan" value="{{ $data->urutan }}"
                                required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-outline-primary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
