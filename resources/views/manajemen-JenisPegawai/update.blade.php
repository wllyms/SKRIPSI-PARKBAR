@foreach ($jenis_pegawai as $data)
    <!-- Modal -->
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-primary">
                    <h5 class="modal-title text-white" id="tambahModalLabel">Edit Ketegori Pegawai</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form Tambah Data -->
                <form action="{{ route('manajemen-JenisPegawai.update', $data->id) }}" method="POST">
                    @method('PUT')
                    @csrf
                    <div class="modal-body">
                        <div class="form-group">
                            <label for="jenis_pegawai">Ketegori Pegawai</label>
                            <input type="text" name="jenis_pegawai" class="form-control" id="jenis_pegawai"
                                value="{{ $data->jenis_pegawai }}">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn btn-primary">Edit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
