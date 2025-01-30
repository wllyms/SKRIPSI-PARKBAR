@foreach ($user as $data)
    <!-- Modal -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="tambahModalLabel">Edit Data</h5>
                    <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form Tambah Data -->
                <form action="{{ route('manajemen-user.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control" value="{{ $data->username }}" name="username"
                                id="username">
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="text" class="form-control" value="{{ $data->password }}" name="password"
                                id="password">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <input type="text" class="form-control" value="{{ $data->role }}" name="role"
                                id="role">
                        </div>
                        <div class="form-group">
                            <label for="staff">Staff</label>
                            <select class="form-control" name="staff" id="staff">
                                <option value="">-- Pilih Staff --</option>
                                @foreach ($staff as $gdata)
                                    <option value="{{ $gdata->id }}"
                                        {{ $gdata->id == $data->staff_id ? 'selected' : '' }}>
                                        {{ $gdata->nama }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Update</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
