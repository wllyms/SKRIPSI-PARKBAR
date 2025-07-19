@foreach ($staff as $data)
    <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel">Konfirmasi Hapus</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    Apakah Anda yakin ingin menghapus <strong>{{ $data->nama }}</strong>?
                </div>
                <div class="modal-footer">
                    <form action="{{ route('manajemen-staff.delete', $data->id) }}" method="POST">
                        @csrf
                        @method('DELETE')
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button type="submit" class="btn bg-gradient-danger text-white">Hapus</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endforeach
