<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Data Kursi</h2>
            <a href="<?= base_url('/kursi') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/kursi/update/' . $kursi['ID_KURSI']) ?>" method="post">
                <div class="form-group">
                    <label for="id_pesawat">Pilih Pesawat</label>
                    <select name="id_pesawat" id="id_pesawat" class="form-control" required>
                        <?php foreach ($pesawat as $p): ?>
                            <option value="<?= $p['ID_PESAWAT'] ?>" <?= $p['ID_PESAWAT'] == $kursi['ID_PESAWAT'] ? 'selected' : '' ?>>
                                <?= esc($p['NAMA_MASKAPAI']) ?> - <?= esc($p['TIPE_PESAWAT']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas_penerbanan">Kelas Penerbangan</label>
                        <select name="kelas_penerbanan" id="kelas_penerbanan" class="form-control" required>
                            <option value="Ekonomi" <?= $kursi['KELAS_PENERBANAN'] == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                            <option value="Bisnis" <?= $kursi['KELAS_PENERBANAN'] == 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
                            <option value="First Class" <?= $kursi['KELAS_PENERBANAN'] == 'First Class' ? 'selected' : '' ?>>First Class</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="no_kursi2">Nomor Kursi</label>
                        <input type="text" name="no_kursi2" id="no_kursi2" class="form-control" value="<?= esc($kursi['NO_KURSI2']) ?>" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Kursi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
