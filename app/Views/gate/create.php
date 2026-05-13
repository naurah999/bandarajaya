<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Gate Baru</h2>
            <a href="<?= base_url('/gate') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/gate/store') ?>" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="nomor_gate">Nomor Gate</label>
                        <input type="text" name="nomor_gate" id="nomor_gate" class="form-control" placeholder="Contoh: A1" required>
                    </div>
                    <div class="form-group">
                        <label for="terminal">Terminal</label>
                        <input type="text" name="terminal" id="terminal" class="form-control" placeholder="Contoh: 1" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Data
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
