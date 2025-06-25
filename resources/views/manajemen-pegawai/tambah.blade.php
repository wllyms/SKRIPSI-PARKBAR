<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="tambahModalLabel">Tambah Pegawai</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <!-- Form Tambah Data -->
            <form action="{{ route('manajemen-pegawai.submit') }}" method="POST" enctype="multipart/form-data">
                @csrf
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plat_kendaraan">Plat Kendaraan</label>
                        <input type="text" name="plat_kendaraan" class="form-control" id="plat_kendaraan"
                            placeholder="Masukkan Plat Kendaraan" required>
                    </div>
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Masukkan Nama" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" id="no_telp"
                            placeholder="Masukkan No Telp" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Masukkan Email" required>
                    </div>
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" rows="3" required></textarea>
                    </div>
                    <div class="form-group">
                        <label for="merk_kendaraan">Merk Kendaraan</label>
                        <input type="text" name="merk_kendaraan" class="form-control" id="merk_kendaraan"
                            placeholder="Masukkan Merk Kendaraan">
                    </div>
                    <div class="form-group">
                        <label for="jenis_pegawai">Kategori Pegawai</label>
                        <select class="form-control" name="jenis_pegawai" id="jenis_pegawai" required>
                            <option value="">-- Pilih kategori Pegawai --</option>
                            @foreach ($jenis_pegawai as $data)
                                <option value="{{ $data->id }}">{{ $data->jenis_pegawai }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image">Foto</label>
                        <input type="file" name="image" class="form-control-file" id="image">
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
