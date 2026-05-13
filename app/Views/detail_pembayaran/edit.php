<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Detail Pembayaran</h2>
            <a href="<?= base_url('/detail-pembayaran') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/detail-pembayaran/update/' . $detail['ID_MEMBAYAR']) ?>" method="post">
                <div class="form-row">
                    <div class="form-group">
                        <label for="id_pembayaran">ID Transaksi Induk</label>
                        <select name="id_pembayaran" id="id_pembayaran" class="form-control" required>
                            <?php foreach ($pembayaran as $p): ?>
                                <option value="<?= $p['ID_PEMBAYARAN'] ?>" <?= $p['ID_PEMBAYARAN'] == $detail['ID_PEMBAYARAN'] ? 'selected' : '' ?>>
                                    TRX-<?= (string)$p['ID_PEMBAYARAN'] ?> (<?= (string)$p['TIPE_PEMBAYARAN'] ?> - Rp <?= number_format((float)$p['TOTAL_HARGA'],0,',','.') ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="id_tiket">Pilih Tiket</label>
                        <select name="id_tiket" id="id_tiket" class="form-control" required>
                            <?php foreach ($tikets as $t): ?>
                                <option value="<?= $t['ID_TIKET'] ?>" <?= $t['ID_TIKET'] == $detail['ID_TIKET'] ? 'selected' : '' ?>>
                                    <?= esc((string)$t['NOMER_TIKET']) ?> - <?= esc((string)$t['NAMA_PENUMPANG']) ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah_bayar">Jumlah yang Dibayarkan (Rp)</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" value="<?= esc((string)$detail['JUMLAH_BAYAR']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="status_pembayaran">Status</label>
                        <select name="status_pembayaran" id="status_pembayaran" class="form-control" required>
                            <option value="Lunas" <?= $detail['STATUS_PEMBAYARAN'] == 'Lunas' ? 'selected' : '' ?>>Lunas</option>
                            <option value="Pending" <?= $detail['STATUS_PEMBAYARAN'] == 'Pending' ? 'selected' : '' ?>>Pending</option>
                            <option value="Gagal" <?= $detail['STATUS_PEMBAYARAN'] == 'Gagal' ? 'selected' : '' ?>>Gagal</option>
                        </select>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Detail
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
