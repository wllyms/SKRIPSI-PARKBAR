<div class="modal fade" id="tambahModal" tabindex="-1" role="dialog" aria-labelledby="tambahModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header bg-gradient-primary">
                <h5 class="modal-title text-white" id="tambahModalLabel">Tambah Data Parkir</h5>
                <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form action="{{ route('manajemen-parkir.submit') }}" method="POST" target="_blank"
                onclick="setTimeout(function(){location.reload()}, 12000)">
                @csrf
                <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="plat_kendaraan">Plat Kendaraan</label>
                        <input type="text" class="form-control" name="plat_kendaraan" id="plat_kendaraan" required>
                    </div>

                    <div class="form-group">
                        <label for="jenis_tarif">Tarif</label>
                        <select class="form-control" name="jenis_tarif" id="jenis_tarif" required>
                            <option value="">Pilih Jenis Tarif</option>
                            @foreach ($tarif as $data)
                                <option value="{{ $data->id }}" data-kategori-id="{{ $data->kategori_id }}">
                                    {{ $data->jenis_tarif }} | {{ $data->kategori->nama_kategori ?? '-' }}
                                </option>
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

<script>
    const allSlots = @json($allSlotsData);

    const tarifSelect = document.getElementById('jenis_tarif');
    const slotSelect = document.getElementById('slot_id');
    const errorMessage = document.getElementById('slot-error-message');

    tarifSelect.addEventListener('change', function() {
        slotSelect.innerHTML = '<option value="">Pilih Slot Parkir</option>';

        const selectedOption = tarifSelect.options[tarifSelect.selectedIndex];
        const kategoriId = selectedOption.getAttribute('data-kategori-id');

        if (kategoriId) {
            const filteredSlots = allSlots.filter(slot => slot.kategori_id == kategoriId);
            let hasAvailableSlot = false;

            filteredSlots.forEach(slot => {
                const tersisa = slot.kapasitas - slot.terpakai;
                if (tersisa > 0) {
                    hasAvailableSlot = true;
                    const option = document.createElement('option');
                    option.value = slot.id;
                    option.textContent = `${slot.nama_slot} - ${tersisa} slot tersedia`;
                    slotSelect.appendChild(option);
                }
            });

            if (!hasAvailableSlot) {
                errorMessage.style.display = 'block';
                slotSelect.setAttribute('disabled', 'disabled');
            } else {
                errorMessage.style.display = 'none';
                slotSelect.removeAttribute('disabled');
            }
        } else {
            slotSelect.setAttribute('disabled', 'disabled');
            errorMessage.style.display = 'none';
        }
    });

    tarifSelect.dispatchEvent(new Event('change'));
</script>
