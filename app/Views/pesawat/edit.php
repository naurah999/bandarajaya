<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Pesawat</h2>
            <a href="<?= base_url('/pesawat') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/pesawat/update/' . $pesawat['ID_PESAWAT']) ?>" method="post">
                <div class="form-group">
                    <label for="id_maskapai">Pilih Maskapai</label>
                    <select name="id_maskapai" id="id_maskapai" class="form-control" required>
                        <?php foreach ($maskapai as $m): ?>
                            <option value="<?= $m['ID_MASKAPAI'] ?>" <?= $m['ID_MASKAPAI'] == $pesawat['ID_MASKAPAI'] ? 'selected' : '' ?>>
                                <?= esc($m['NAMA_MASKAPAI']) ?> (<?= esc($m['KODE_MASKAPAI']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_pesawat">Kode Pesawat</label>
                        <input type="text" name="kode_pesawat" id="kode_pesawat" class="form-control" value="<?= esc($pesawat['KODE_PESAWAT']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tipe_pesawat">Tipe Pesawat</label>
                        <input type="text" name="tipe_pesawat" id="tipe_pesawat" class="form-control" value="<?= esc($pesawat['TIPE_PESAWAT']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kapasitas">Kapasitas Penumpang</label>
                        <input type="number" name="kapasitas" id="kapasitas" class="form-control" value="<?= esc($pesawat['KAPASITAS']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_produksi">Tahun Produksi</label>
                        <input type="number" name="tahun_produksi" id="tahun_produksi" class="form-control" value="<?= esc($pesawat['TAHUN_PRODUKSI']) ?>" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
