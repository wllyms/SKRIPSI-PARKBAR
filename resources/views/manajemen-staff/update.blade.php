@foreach ($staff as $data)
    <!-- Modal -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning">
                    <h5 class="modal-title text-white" id="tambahModalLabel">Edit Staff</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form Tambah Data -->
                <form action="{{ route('manajemen-staff.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="nama">Nama</label>
                            <input type="text" name="nama" class="form-control" id="nama"
                                value="{{ $data->nama }}">
                        </div>
                        <div class="form-group">
                            <label for="no_telp">No Telp</label>
                            <input type="text" name="no_telp" class="form-control" id="no_telp"
                                value="{{ $data->no_telp }}">
                        </div>
                        <div class="form-group">
                            <label for="alamat">Alamat</label>
                            <input type="text" name="alamat" class="form-control" id="alamat"
                                value="{{ $data->alamat }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn bg-gradient-warning text-white">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
