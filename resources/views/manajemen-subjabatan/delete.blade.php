@foreach ($subjabatan as $data)
    <!-- Modal Delete -->
    <div class="modal fade" id="deleteModal{{ $data->id }}" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <form action="{{ route('manajemen-subjabatan.delete', $data->id) }}" method="GET">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title">Hapus Sub Jabatan</h5>
                        <button type="button" class="close" data-dismiss="modal"><span>&times;</span></button>
                    </div>
                    <div class="modal-body">
                        Yakin ingin menghapus sub jabatan <strong>{{ $data->nama_sub_jabatan }}</strong>?
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" data-dismiss="modal">Batal</button>
                        <button class="btn btn-danger">Hapus</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
@endforeach
