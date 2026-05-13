<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Data Penumpang</h2>
            <a href="<?= base_url('/penumpang') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/penumpang/update/' . $penumpang['ID_PENUMPANG']) ?>" method="post">
                <div class="form-group">
                    <label for="nama_penumpang">Nama Lengkap</label>
                    <input type="text" name="nama_penumpang" id="nama_penumpang" class="form-control" value="<?= esc($penumpang['NAMA_PENUMPANG']) ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="no_identitas">Nomor Identitas (NIK/Passport)</label>
                        <input type="text" name="no_identitas" id="no_identitas" class="form-control" value="<?= esc($penumpang['NO_IDENTITAS']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="jenis_kelamin">Jenis Kelamin</label>
                        <select name="jenis_kelamin" id="jenis_kelamin" class="form-control" required>
                            <option value="Laki-laki" <?= $penumpang['JENIS_KELAMIN'] == 'Laki-laki' ? 'selected' : '' ?>>Laki-laki</option>
                            <option value="Perempuan" <?= $penumpang['JENIS_KELAMIN'] == 'Perempuan' ? 'selected' : '' ?>>Perempuan</option>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="tanggal_lahir">Tanggal Lahir</label>
                        <input type="date" name="tanggal_lahir" id="tanggal_lahir" class="form-control" value="<?= esc($penumpang['TANGGAL_LAHIR']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_telp">Nomor Telepon</label>
                        <input type="text" name="no_telp" id="no_telp" class="form-control" value="<?= esc($penumpang['NO_TELP']) ?>" required>
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
