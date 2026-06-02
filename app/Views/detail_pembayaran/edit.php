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
                        <label>ID Transaksi Induk</label>
                        <input type="text" class="form-control" value="TRX-<?= (string)$detail['ID_PEMBAYARAN'] ?>" readonly>
                        <input type="hidden" name="id_pembayaran" value="<?= $detail['ID_PEMBAYARAN'] ?>">
                    </div>
                    <div class="form-group">
                        <label>Tiket Terkait</label>
                        <?php 
                        $tiketTerkait = '';
                        foreach($tikets as $t) {
                            if($t['ID_TIKET'] == $detail['ID_TIKET']) {
                                $tiketTerkait = $t['NOMER_TIKET'] . ' - ' . $t['NAMA_PENUMPANG'];
                            }
                        }
                        ?>
                        <input type="text" class="form-control" value="<?= esc($tiketTerkait) ?>" readonly>
                        <input type="hidden" name="id_tiket" value="<?= $detail['ID_TIKET'] ?>">
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah_bayar">Jumlah yang Dibayarkan (Rp)</label>
                        <input type="number" name="jumlah_bayar" id="jumlah_bayar" class="form-control" value="<?= esc((string)$detail['JUMLAH_BAYAR']) ?>" readonly>
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
