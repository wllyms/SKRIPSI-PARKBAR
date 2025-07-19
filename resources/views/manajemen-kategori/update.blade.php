<!-- Modal -->
@foreach ($kategori as $data)
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog"
        aria-labelledby="tambahModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header bg-gradient-warning">
                    <h5 class="modal-title text-white" id="tambahModalLabel">Edit Kategori</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <!-- Form EDIT Data -->
                <form action="{{ route('manajemen-kategori.update', $data->id) }}" method="POST">
                    <div class="modal-body">
                        @method('PUT')
                        @csrf
                        <div class="form-group">
                            <label for="nama_kategori">Nama Kategori</label>
                            <input type="text" name="nama_kategori" class="form-control" id="nama_kategori"
                                value="{{ $data->nama_kategori }}">
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
