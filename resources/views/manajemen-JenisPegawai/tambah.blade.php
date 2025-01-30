<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="tambahModalLabel">Tambah Jenis Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Form Tambah Data -->
            <form action="{{ route('manajemen-JenisPegawai.submit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="jenis_pegawai">Jenis Pegawai</label>
                        <input type="text" name="jenis_pegawai" class="form-control" id="nama_kategori"
                            placeholder="Masukkan Jenis Pegawai" required>
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
