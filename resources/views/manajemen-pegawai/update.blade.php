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
                    @method('PUT')

                    <div class="modal-body">
                        <div class="form-group">
                            <label for="plat_kendaraan">Plat Kendaraan</label>
                            <input type="text" name="plat_kendaraan" class="form-control"
                                value="{{ old('plat_kendaraan', $data->plat_kendaraan) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control"
                                value="{{ old('nama', $data->nama) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="text" name="no_telp" class="form-control"
                                value="{{ old('no_telp', $data->no_telp) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control"
                                value="{{ old('email', $data->email) }}" required>
                        </div>

                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <textarea name="alamat" class="form-control" rows="3" required>{{ old('alamat', $data->alamat) }}</textarea>
                        </div>

                        <div class="form-group">
                            <label for="merk_kendaraan">Merk Kendaraan</label>
                            <input type="text" name="merk_kendaraan" class="form-control"
                                value="{{ old('merk_kendaraan', $data->merk_kendaraan) }}">
                        </div>

                        <div class="form-group">
                            <label for="jabatan_id">Jabatan</label>
                            <select name="jabatan_id" class="form-control" required>
                                <option value="">-- Pilih Jabatan --</option>
                                @foreach ($jabatan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->jabatan_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="sub_jabatan_id">Sub Jabatan</label>
                            <select name="sub_jabatan_id" class="form-control" required>
                                <option value="">-- Pilih Sub Jabatan --</option>
                                @foreach ($subjabatan as $item)
                                    <option value="{{ $item->id }}"
                                        {{ $data->sub_jabatan_id == $item->id ? 'selected' : '' }}>
                                        {{ $item->nama_sub_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="form-group">
                            <label for="image">Foto Profil</label>
                            <input type="file" name="image" class="form-control-file">
                            @if ($data->image)
                                <div class="mt-2">
                                    <img src="{{ asset('storage/' . $data->image) }}" alt="Foto Profil" width="100">
                                    <p class="small text-muted">Foto saat ini</p>
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
