<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="tambahModalLabel">Tambah Data</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Form Tambah Data -->
            <form action="{{ route('manajemen-tarif.submit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_tarif">Jenis Tarif</label>
                        <input type="text" class="form-control" name="jenis_tarif" id="jenis_tarif" required>
                    </div>
                    <div class="form-group">
                        <label for="tarif">Tarif</label>
                        <input type="text" class="form-control" name="tarif" id="tarif" required>
                    </div>
                    <div class="form-group">
                        <label for="kategori">Kategori</label>
                        <select class="form-control" name="kategori" id="kategori">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach ($kategori as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
