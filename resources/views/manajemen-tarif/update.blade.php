@foreach ($tarif as $data)
    <!-- Modal -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning">
                    <h5 class="modal-title text-white" id="updateModalLabel">Update Data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form Tambah Data -->
                <form action="{{ route('manajemen-tarif.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenis_tarif">Jenis Tarif</label>
                            <input type="text" class="form-control" value="{{ $data->jenis_tarif }}"
                                name="jenis_tarif" id="jenis_tarif">
                        </div>
                        <div class="form-group">
                            <label for="tarif">Tarif</label>
                            <input type="text" class="form-control" value="{{ $data->tarif }}" name="tarif"
                                id="tarif">
                        </div>
                        <div class="form-group">
                            <label for="kategori">Kategori</label>
                            <select class="form-control" name="kategori" id="kategori">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($kategori as $kdata)
                                    <option value="{{ $kdata->id }}"
                                        {{ $kdata->id == $data->kategori_id ? 'selected' : '' }}>
                                        {{ $kdata->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn bg-gradient-warning text-white">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
