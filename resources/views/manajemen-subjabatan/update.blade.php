@foreach ($subjabatan as $data)
    <!-- Modal Edit -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{ route('manajemen-subjabatan.update', $data->id) }}" method="POST">
                @csrf
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Edit Sub Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Pilih Jabatan</label>
                            <select name="jabatan_id" class="form-control" required>
                                @foreach ($jabatans as $j)
                                    <option value="{{ $j->id }}"
                                        {{ $data->jabatan_id == $j->id ? 'selected' : '' }}>
                                        {{ $j->nama_jabatan }}
                                    </option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Nama Sub Jabatan</label>
                            <input type="text" class="form-control" name="nama_sub_jabatan"
                                value="{{ $data->nama_sub_jabatan }}" required>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-warning">Update</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
