<?php
/**
 * @var array $pembayaran
 * @var array $tikets
 */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Catat Detail Pelunasan</h2>
            <a href="<?= base_url('/detail-pembayaran') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/detail-pembayaran/store') ?>" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_pembayaran">ID Transaksi Induk</label>
                        <select name="id_pembayaran" id="id_pembayaran" class="form-control" required>
                            <option value="">-- Pilih Transaksi --</option>
                            <?php foreach ($pembayaran as $p): ?>
                                <option value="<?= (string)$p['ID_PEMBAYARAN'] ?>">TRX-<?= (string)$p['ID_PEMBAYARAN'] ?> (<?= (string)$p['TIPE_PEMBAYARAN'] ?> - Rp <?= number_format((float)$p['TOTAL_HARGA'],0,',','.') ?>)</option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_tiket">Pilih Tiket</label>
                        <select name="id_tiket" id="id_tiket" class="form-control" required>
                            <option value="">-- Pilih Tiket --</option>
                            <?php foreach ($tikets as $t): ?>
                                <option value="<?= (string)$t['ID_TIKET'] ?>"><?= esc((string)$t['NOMER_TIKET']) ?> - <?= esc((string)$t['NAMA_PENUMPANG']) ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah_bayar">Jumlah yang Dibayarkan (Rp)</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="status_pembayaran">Status</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                            <option value="Lunas">Lunas</option>
                            <option value="Pending">Pending</option>
                            <option value="Gagal">Gagal</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Detail
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
