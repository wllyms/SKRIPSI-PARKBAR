<!-- Modal -->
<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="tambahModalLabel">Tambah Data Parkir</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <!-- Form Tambah Data -->
            <form action="{{ route('manajemen-parkir.submit') }}" method="POST" target="_blank"
                onclick="setTimeout(function(){location.reload()}, 12000)">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="kode_parkir">Kode Parkir</label>
                        <input type="text" class="form-control" id="kode_parkir" value="{{ $kodeParkir }}"
                            readonly>
                    </div>

                    <div class="form-group">
                        <label for="plat_kendaraan">Plat Kendaraan</label>
                        <input type="text" class="form-control" name="plat_kendaraan" id="plat_kendaraan" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_tarif">Tarif</label>
                        <select class="form-control" name="jenis_tarif" id="jenis_tarif" required>
                            @foreach ($tarif as $data)
                                <option value="{{ $data->id }}">
                                    {{ $data->jenis_tarif }} | {{ $data->kategori->nama_kategori ?? '-' }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="slot_id">Slot Parkir</label>
                        <select class="form-control" name="slot_id" id="slot_id" required>
                            @foreach ($slot as $item)
                                @php
                                    $tersisa = $item->kapasitas - $item->terpakai;
                                @endphp
                                @if ($tersisa > 0)
                                    <option value="{{ $item->id }}">
                                        {{ $item->nama_slot }} - {{ $tersisa }} slot tersedia
                                    </option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Kembali</button>
                    <button type="submit" class="btn btn-primary">Tambah</button>
                </div>
            </form>
        </div>
    </div>
</div>
