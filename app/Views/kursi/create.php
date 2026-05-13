<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Kursi Baru</h2>
            <a href="<?= base_url('/kursi') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/kursi/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_pesawat">Pilih Pesawat</label>
                    <select name="id_pesawat" id="id_pesawat" class="form-control" required>
                        <option value="">-- Pilih Pesawat --</option>
                        <?php foreach ($pesawat as $p): ?>
                            <option value="<?= $p['ID_PESAWAT'] ?>"><?= esc($p['NAMA_MASKAPAI']) ?> - <?= esc($p['TIPE_PESAWAT']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas_penerbanan">Kelas Penerbangan</label>
                        <select name="kelas_penerbanan" id="kelas_penerbanan" class="form-control" required>
                            <option value="">-- Pilih Kelas --</option>
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="First Class">First Class</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_kursi2">Nomor Kursi</label>
                        <input type="text" name="no_kursi2" id="no_kursi2" class="form-control" placeholder="Contoh: 12A" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Kursi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
