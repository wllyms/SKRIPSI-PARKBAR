<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="tambahModalLabel">Tambah Laporan Pengunjung</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Form Tambah Data -->
            <form action="{{ route('manajemen-pengaduan.submit') }}" method="POST">
                @csrf
                <div class="modal-body">
                    {{-- Nama --}}
                    <div class="form-group">
                        <label for="nama">Nama Pengunjung</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Masukkan Nama Pengunjung" required>
                    </div>

                    {{-- Waktu Lapor --}}
                    <div class="form-group">
                        <label for="waktu_lapor">Waktu Lapor</label>
                        <input type="datetime-local" name="waktu_lapor" class="form-control" id="waktu_lapor" required>
                    </div>

                    {{-- No Telp --}}
                    <div class="form-group">
                        <label for="no_telp">No Telepon</label>
                        <input type="text" name="no_telp" class="form-control" id="no_telp"
                            placeholder="Masukkan No Telepon" required>
                    </div>

                    {{-- Keterangan --}}
                    <div class="form-group">
                        <label for="keterangan">Keterangan</label>
                        <textarea name="keterangan" class="form-control" id="keterangan" rows="3" placeholder="Masukkan Keterangan"
                            required></textarea>
                    </div>

                    {{-- user_id (hidden) --}}
                    <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
