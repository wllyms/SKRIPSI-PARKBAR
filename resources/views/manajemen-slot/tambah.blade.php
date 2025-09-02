<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <form action="{{ route('manajemen-slot.submit') }}" method="POST">
            @csrf
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary text-white">
                    <h5 class="modal-title">Tambah Slot Parkir</h5>
                    <button type="button" class="close" data-dismiss="modal">
                        <span>&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Slot</label>
                        <input type="text" name="nama_slot" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Kapasitas</label>
                        <input type="number" name="kapasitas" class="form-control" required min="1">
                    </div>
                    <div class="form-group">
                        <label>Kategori</label>
                        <select name="kategori_id" class="form-control" required>
                            <option value="">Pilih Kategori</option>
                            @foreach ($kategori as $data)
                                <option value="{{ $data->id }}">{{ $data->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" data-dismiss="modal" type="button">Kembali</button>
                    <button class="btn bg-gradient-primary text-white" type="submit">Tambah</button>
                </div>
            </div>
        </form>
    </div>
</div>
