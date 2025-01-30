@foreach ($parkir as $data)
    <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="deleteModalLabel{{ $data->id }}" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-danger">
                    <h5 class="modal-title text-white" id="deleteModalLabel{{ $data->id }}">Hapus Data</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form DELETE Data -->
                <form action="{{ route('manajemen-parkir.delete', $data->id) }}" method="POST">
                    <div class="modal-body">
                        <p>Apakah Anda yakin ingin menghapus kendaraan dengana plat kendaraan
                            <strong>{{ $data->plat_kendaraan }}</strong>?
                        </p>
                        @method('DELETE')
                        @csrf
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                        <button type="submit" class="btn bg-danger text-white">Hapus</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endforeach
