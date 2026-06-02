<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 900px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Jadwal Penerbangan</h2>
            <a href="<?= base_url('/penerbangan') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/penerbangan/store') ?>" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_pesawat">Pesawat</label>
                        <select name="id_pesawat" id="id_pesawat" class="form-control" required>
                            <option value="">-- Pilih Pesawat --</option>
                            <?php foreach ($pesawat as $p): ?>
                                <option value="<?= $p['ID_PESAWAT'] ?>" data-maskapai-kode="<?= esc($p['KODE_MASKAPAI']) ?>">
                                    <?= esc($p['CATALOG_TIPE'] ?? $p['TIPE_PESAWAT']) ?> (<?= esc($p['KODE_PESAWAT'] ?? '-') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_gate">Gate Keberangkatan</label>
                        <select name="id_gate" id="id_gate" class="form-control" required>
                            <option value="">-- Pilih Gate --</option>
                            <?php foreach ($gates as $g): ?>
                                <option value="<?= $g['ID_GATE'] ?>">Gate <?= esc($g['NOMOR_GATE']) ?> (Terminal <?= esc($g['TERMINAL']) ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-group">
                    <label for="kode_penerbangan">Kode Penerbangan <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="kode_penerbangan" id="kode_penerbangan" class="form-control" placeholder="Otomatis terisi..." readonly required style="background-color: #f1f5f9; cursor: not-allowed; opacity: 0.8;">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_berangkat">Tanggal Keberangkatan</label>
                        <input type="date" name="tanggal_berangkat" id="tanggal_berangkat" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="waktu_berangkat">Waktu Keberangkatan</label>
                        <input type="time" name="waktu_berangkat" id="waktu_berangkat" class="form-control" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kota_asal">Kota Asal</label>
                        <input type="text" name="kota_asal" id="kota_asal" class="form-control" placeholder="Contoh: Jakarta" required>
                    </div>
                    <div class="form-group">
                        <label for="kota_tujuan">Kota Tujuan</label>
                        <input type="text" name="kota_tujuan" id="kota_tujuan" class="form-control" placeholder="Contoh: Surabaya" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Jadwal
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
    if (maskapaiKode) {
        // Generate automatic flight code like GA-101 to GA-999
        const randomNum = Math.floor(100 + Math.random() * 900);
        document.getElementById('kode_penerbangan').value = maskapaiKode + '-' + randomNum;
    } else {
        document.getElementById('kode_penerbangan').value = '';
    }
});
</script>

<?= $this->endSection() ?>
