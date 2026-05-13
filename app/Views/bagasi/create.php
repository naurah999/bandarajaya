<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Bagasi</h2>
            <a href="<?= base_url('/bagasi') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/bagasi/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_checkin">Pilih Data Check-in Penumpang</label>
                    <select name="id_checkin" id="id_checkin" class="form-control" required>
                        <option value="">-- Pilih Penumpang --</option>
                        <?php foreach ($checkins as $c): ?>
                            <option value="<?= $c['ID_CHECKIN'] ?>">
                                <?= esc($c['NAMA_PENUMPANG']) ?> - Tiket: <?= esc($c['NOMER_TIKET']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="berat_bagasi">Berat Bagasi (Kg)</label>
                        <input type="number" step="0.1" name="berat_bagasi" id="berat_bagasi" class="form-control" placeholder="Contoh: 15.5" required>
                    </div>
                    <div class="form-group">
                        <label for="status_bagasi">Status Bagasi</label>
                        <select name="status_bagasi" id="status_bagasi" class="form-control" required>
                            <option value="Diterima">Diterima</option>
                            <option value="Dalam Proses">Dalam Proses</option>
                            <option value="Dimasukkan">Dimasukkan Pesawat</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Bagasi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
