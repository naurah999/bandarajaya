<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Tiket</h2>
            <a href="<?= base_url('/tiket') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/tiket/update/' . $tiket['ID_TIKET']) ?>" method="post">
                <div class="form-group">
                    <label for="id_penumpang">Penumpang</label>
                    <select name="id_penumpang" id="id_penumpang" class="form-control" required>
                        <?php foreach ($penumpang as $p): ?>
                            <option value="<?= $p['ID_PENUMPANG'] ?>" <?= $p['ID_PENUMPANG'] == $tiket['ID_PENUMPANG'] ? 'selected' : '' ?>>
                                <?= esc($p['NAMA_PENUMPANG']) ?> (<?= esc($p['NO_IDENTITAS']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_penerbangan">Penerbangan</label>
                    <select name="id_penerbangan" id="id_penerbangan" class="form-control" required>
                        <?php foreach ($penerbangan as $p): ?>
                            <option value="<?= $p['ID_PENERBANGAN'] ?>" <?= $p['ID_PENERBANGAN'] == $tiket['ID_PENERBANGAN'] ? 'selected' : '' ?>>
                                [<?= esc($p['KODE_PENERBANGAN'] ?? '') ?>] <?= date('d M', strtotime($p['TANGGAL_BERANGKAT'])) ?> <?= date('H:i', strtotime($p['WAKTU_BERANGKAT'])) ?> | 
                                <?= esc($p['KOTA_ASAL']) ?> -> <?= esc($p['KOTA_TUJUAN']) ?> (Rp <?= number_format($p['HARGA'] ?? 0, 0, ',', '.') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="nomer_tiket">Nomor Tiket</label>
                        <input type="text" name="nomer_tiket" id="nomer_tiket" class="form-control" value="<?= esc($tiket['NOMER_TIKET']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Tiket</label>
                        <input type="text" class="form-control" value="Rp <?= number_format($tiket['HARGA'], 0, ',', '.') ?> (Otomatis menyesuaikan rute jika diubah)" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
