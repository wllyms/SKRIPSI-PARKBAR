@foreach ($pegawai as $data)
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog" aria-labelledby="editModalLabel"
        aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="editModalLabel">Edit Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form Edit Data -->
                <form action="{{ route('manajemen-pegawai.update', $data->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT') <!-- Menggunakan metode PUT untuk update -->
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="plat_kendaraan">Plat Kendaraan</label>
                            <input type="text" name="plat_kendaraan" class="form-control" id="plat_kendaraan"
                                placeholder="Masukkan Plat Kendaraan"
                                value="{{ old('plat_kendaraan', $data->plat_kendaraan) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama"
                                placeholder="Masukkan Nama" value="{{ old('nama', $data->nama) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="text" name="no_telp" class="form-control" id="no_telp"
                                placeholder="Masukkan No Telp" value="{{ old('no_telp', $data->no_telp) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email"
                                placeholder="Masukkan Email" value="{{ old('email', $data->email) }}" required>
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" id="alamat" placeholder="Masukkan Alamat" rows="3" required>{{ old('alamat', $data->alamat) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="merk_kendaraan">Merk Kendaraan</label>
                            <input type="text" name="merk_kendaraan" class="form-control" id="merk_kendaraan"
                                placeholder="Masukkan Merk Kendaraan"
                                value="{{ old('merk_kendaraan', $data->merk_kendaraan) }}">
                        </div>
                        <div class="form-group">
                            <label for="jenis_pegawai">Kategori Pegawai</label>
                            <select class="form-control" name="jenis_pegawai_id" id="jenis_pegawai" required>
                                <option value="">-- Pilih Kategori Pegawai --</option>
                                @foreach ($jenis_pegawai as $data)
                                    <option value="{{ $data->id }}"
                                        {{ old('jenis_pegawai_id') == $data->id || (isset($pegawai) && $data->jenis_pegawai_id == $data->id) ? 'selected' : '' }}>
                                        {{ $data->jenis_pegawai }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Foto Profil</label>
                            <input type="file" name="image" class="form-control-file" id="image">
                            @if ($data->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $data->image) }}" alt="Foto Profil" width="100">
                                    <p>Foto saat ini</p>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>

            </div>
        </div>
    </div>
@endforeach
