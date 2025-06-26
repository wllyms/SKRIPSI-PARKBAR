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

                    {{-- Plat Nomor --}}
                    <div class="form-group">
                        <label for="plat_kendaraan">Plat Kendaraan</label>
                        <input type="text" name="plat_kendaraan" class="form-control" id="plat_kendaraan"
                            placeholder="Masukkan Plat Kendaraan" required>
                    </div>

                    {{-- Nama --}}
                    <div class="form-group">
                        <label for="nama">Nama</label>
                        <input type="text" name="nama" class="form-control" id="nama"
                            placeholder="Masukkan Nama" required>
                    </div>

                    {{-- No Telp --}}
                    <div class="form-group">
                        <label for="no_telp">No Telp</label>
                        <input type="text" name="no_telp" class="form-control" id="no_telp"
                            placeholder="Masukkan No Telp" required>
                    </div>

                    {{-- Email --}}
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email"
                            placeholder="Masukkan Email" required>
                    </div>

                    {{-- Alamat --}}
                    <div class="form-group">
                        <label for="alamat">Alamat</label>
                        <textarea name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" rows="3" required></textarea>
                    </div>

                    {{-- Merk Kendaraan --}}
                    <div class="form-group">
                        <label for="merk_kendaraan">Merk Kendaraan</label>
                        <input type="text" name="merk_kendaraan" class="form-control" id="merk_kendaraan"
                            placeholder="Masukkan Merk Kendaraan">
                    </div>

                    {{-- Jabatan --}}
                    <div class="form-group">
                        <label for="jabatan_id">Jabatan</label>
                        <select class="form-control" name="jabatan_id" id="jabatan_id" required>
                            <option value="">-- Pilih Jabatan --</option>
                            @foreach ($jabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Sub Jabatan --}}
                    <div class="form-group">
                        <label for="sub_jabatan_id">Sub Jabatan</label>
                        <select class="form-control" name="sub_jabatan_id" id="sub_jabatan_id" required>
                            <option value="">-- Pilih Sub Jabatan --</option>
                            @foreach ($subjabatan as $item)
                                <option value="{{ $item->id }}">{{ $item->nama_sub_jabatan }}</option>
                            @endforeach
                        </select>
                    </div>

                    {{-- Foto --}}
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
