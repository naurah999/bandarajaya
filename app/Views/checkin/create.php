<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Proses Check-in Penumpang</h2>
            <a href="<?= base_url('/checkin') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/checkin/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_tiket">Pilih Tiket Penumpang</label>
                    <select name="id_tiket" id="id_tiket" class="form-control" required>
                        <option value="">-- Pilih Tiket --</option>
                        <?php foreach ($tikets as $t): ?>
                            <option value="<?= $t['ID_TIKET'] ?>">
                                <?= esc($t['NOMER_TIKET']) ?> - <?= esc($t['NAMA_PENUMPANG']) ?> (<?= esc($t['KOTA_ASAL']) ?> -> <?= esc($t['KOTA_TUJUAN']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kursi">Pilih Kursi Tersedia</label>
                    <select name="id_kursi" id="id_kursi" class="form-control" required disabled>
                        <option value="">-- Pilih Tiket Terlebih Dahulu --</option>
                    </select>
                    <small id="seatStatus" style="color: var(--text-muted); margin-top: 4px; display: block;">* Kursi akan ditampilkan setelah tiket dipilih.</small>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>
                        <i class="fas fa-check-circle"></i> Selesaikan Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('id_tiket').addEventListener('change', function() {
        const idTiket = this.value;
        const seatSelect = document.getElementById('id_kursi');
        const btnSubmit = document.getElementById('btnSubmit');
        const seatStatus = document.getElementById('seatStatus');

        if (!idTiket) {
            seatSelect.innerHTML = '<option value="">-- Pilih Tiket Terlebih Dahulu --</option>';
            seatSelect.disabled = true;
            btnSubmit.disabled = true;
            return;
        }

        seatStatus.innerText = 'Memuat kursi tersedia...';
        seatSelect.disabled = true;

        fetch('<?= base_url('/checkin/get-available-seats/') ?>' + idTiket)
            .then(response => response.json())
            .then(data => {
                seatSelect.innerHTML = '<option value="">-- Pilih Kursi --</option>';
                if (data.length === 0) {
                    seatSelect.innerHTML += '<option value="">Tidak ada kursi tersedia</option>';
                    seatStatus.innerText = 'Peringatan: Tidak ada kursi tersedia untuk penerbangan ini.';
                    seatStatus.style.color = 'var(--danger)';
                    btnSubmit.disabled = true;
                } else {
                    data.forEach(seat => {
                        seatSelect.innerHTML += `<option value="${seat.ID_KURSI}">${seat.NO_KURSI2} (${seat.KELAS_PENERBANAN})</option>`;
                    });
                    seatSelect.disabled = false;
                    btnSubmit.disabled = false;
                    seatStatus.innerText = '* Silahkan pilih salah satu kursi di atas.';
                    seatStatus.style.color = 'var(--text-muted)';
                }
            })
            .catch(err => {
                console.error(err);
                seatStatus.innerText = 'Gagal memuat data kursi.';
                seatStatus.style.color = 'var(--danger)';
            });
    });
</script>

<?= $this->endSection() ?>
