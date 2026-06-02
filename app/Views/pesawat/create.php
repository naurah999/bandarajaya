<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Pesawat Baru</h2>
            <a href="<?= base_url('/pesawat') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/pesawat/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_catalog">Pilih Catalog (Template Pesawat) <span style="color:var(--danger)">*</span></label>
                    <select name="id_catalog" id="id_catalog" class="form-control" required>
                        <option value="">-- Pilih Jenis Pesawat --</option>
                        <?php foreach ($catalogs as $c): ?>
                            <option value="<?= $c['ID_CATALOG'] ?>"><?= esc($c['TIPE_PESAWAT']) ?> (<?= esc($c['TOTAL_KAPASITAS']) ?> Kursi)</option>
                        <?php endforeach; ?>
                    </select>
                    <small style="color: var(--text-muted); font-size: 12px; margin-top: 4px; display: block;">Tipe pesawat dan kapasitas otomatis mengikuti catalog yang dipilih.</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kode_pesawat">Kode Pesawat (Registrasi) <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="kode_pesawat" id="kode_pesawat" class="form-control" placeholder="Contoh: PK-ABC" required>
                    </div>
                    <div class="form-group">
                        <label for="tahun_produksi">Tahun Produksi <span style="color:var(--danger)">*</span></label>
                        <input type="number" name="tahun_produksi" id="tahun_produksi" class="form-control" placeholder="Contoh: 2018" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="status_pesawat">Status</label>
                    <select name="status_pesawat" id="status_pesawat" class="form-control" required>
                        <option value="Aktif">Aktif</option>
                        <option value="Maintenance">Maintenance</option>
                        <option value="Grounded">Grounded</option>
                    </select>
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
