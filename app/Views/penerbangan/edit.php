<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 900px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Jadwal Penerbangan</h2>
            <a href="<?= base_url('/penerbangan') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/penerbangan/update/' . $penerbangan['ID_PENERBANGAN']) ?>" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_pesawat">Pesawat</label>
                        <select name="id_pesawat" id="id_pesawat" class="form-control" required>
                            <?php foreach ($pesawat as $p): ?>
                                <option value="<?= $p['ID_PESAWAT'] ?>" data-maskapai-kode="<?= esc($p['KODE_MASKAPAI']) ?>" <?= $p['ID_PESAWAT'] == $penerbangan['ID_PESAWAT'] ? 'selected' : '' ?>>
                                    <?= esc($p['CATALOG_TIPE'] ?? $p['TIPE_PESAWAT']) ?> (<?= esc($p['KODE_PESAWAT'] ?? '-') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_gate">Gate Keberangkatan</label>
                        <select name="id_gate" id="id_gate" class="form-control" required>
                            <?php foreach ($gates as $g): ?>
                                <option value="<?= $g['ID_GATE'] ?>" <?= $g['ID_GATE'] == $penerbangan['ID_GATE'] ? 'selected' : '' ?>>
                                    Gate <?= esc($g['NOMOR_GATE']) ?> (Terminal <?= esc($g['TERMINAL']) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_penerbangan">Kode Penerbangan <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="kode_penerbangan" id="kode_penerbangan" class="form-control" value="<?= esc($penerbangan['KODE_PENERBANGAN'] ?? '') ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Tiket Dasar (Rp) <span style="color:var(--danger)">*</span></label>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?= esc($penerbangan['HARGA'] ?? '') ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_berangkat">Tanggal Keberangkatan</label>
                        <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" value="<?= esc($penerbangan['TANGGAL_BERANGKAT']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_berangkat">Waktu Keberangkatan</label>
                        <input type="time" name="waktu_berangkat" id="waktu_berangkat" class="form-control" value="<?= esc($penerbangan['WAKTU_BERANGKAT']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kota_asal">Kota Asal</label>
                        <input type="text" name="kota_asal" id="kota_asal" class="form-control" value="<?= esc($penerbangan['KOTA_ASAL']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kota_tujuan">Kota Tujuan</label>
                        <input type="text" name="kota_tujuan" id="kota_tujuan" class="form-control" value="<?= esc($penerbangan['KOTA_TUJUAN']) ?>" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Jadwal
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.getElementById('id_pesawat').addEventListener('change', function() {
    const selectedOption = this.options[this.selectedIndex];
    const maskapaiKode = selectedOption.getAttribute('data-maskapai-kode');
    const initialPesawatId = "<?= $penerbangan['ID_PESAWAT'] ?>";
    const initialFlightCode = "<?= esc($penerbangan['KODE_PENERBANGAN']) ?>";
    
    if (this.value == initialPesawatId) {
        document.getElementById('kode_penerbangan').value = initialFlightCode;
    } else if (maskapaiKode) {
        // Generate automatic flight code like GA-101 to GA-999
        const randomNum = Math.floor(100 + Math.random() * 900);
        document.getElementById('kode_penerbangan').value = maskapaiKode + '-' + randomNum;
    } else {
        document.getElementById('kode_penerbangan').value = '';
    }
});
</script>

<?= $this->endSection() ?>
