<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Profil Maskapai</h2>
            <a href="<?= base_url('/maskapai') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/maskapai/update') ?>" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nama_maskapai">Nama Maskapai</label>
                        <input type="text" name="nama_maskapai" id="nama_maskapai" class="form-control" value="<?= esc($maskapai['NAMA_MASKAPAI']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_maskapai">Kode Maskapai (IATA)</label>
                        <input type="text" name="kode_maskapai" id="kode_maskapai" class="form-control" value="<?= esc($maskapai['KODE_MASKAPAI']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="negara_asal">Negara Asal</label>
                        <input type="text" name="negara_asal" id="negara_asal" class="form-control" value="<?= esc($maskapai['NEGARA_ASAL']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="no_kontak">Nomor Kontak</label>
                        <input type="text" name="no_kontak" id="no_kontak" class="form-control" value="<?= esc($maskapai['NO_KONTAK']) ?>" required>
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
