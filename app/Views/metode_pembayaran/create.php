<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 600px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Metode Pembayaran</h2>
            <a href="<?= base_url('/metode-pembayaran') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/metode-pembayaran/store') ?>" method="post">
                <div class="form-group">
                    <label for="tipe_pembayaran">Tipe Pembayaran</label>
                    <input type="text" name="tipe_pembayaran" id="tipe_pembayaran" class="form-control" placeholder="Contoh: Transfer Bank, E-Wallet, dll." required>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Metode
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
