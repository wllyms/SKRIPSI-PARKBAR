@foreach ($slot as $data)
    <div class="modal fade" id="editModal{{ $data->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{ route('manajemen-slot.update', $data->id) }}" method="POST">
                @csrf @method('PUT')
                <div class="modal-content">
                    <div class="modal-header bg-gradient-warning text-white">
                        <h5 class="modal-title">Edit Slot Parkir</h5>
                        <button type="button" class="close" data-dismiss="modal">
                            <span>&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Nama Slot</label>
                            <input type="text" name="nama_slot" class="form-control" value="{{ $data->nama_slot }}"
                                required>
                        </div>
                        <div class="form-group">
                            <label>Kapasitas</label>
                            <input type="number" name="kapasitas" class="form-control" value="{{ $data->kapasitas }}"
                                required min="1">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal" type="button">Batal</button>
                        <button class="btn bg-gradient-warning text-white" type="submit">Edit</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
