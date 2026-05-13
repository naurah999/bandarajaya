<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Riwayat Pembayaran</h2>
        <div class="action-btns">
            <a href="<?= base_url('/metode-pembayaran') ?>" class="btn btn-info">
                <i class="fas fa-wallet"></i> Kelola Metode
            </a>
            <a href="<?= base_url('/pembayaran/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Catat Pembayaran
            </a>
        </div>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID Transaksi</th>
                        <th>Metode</th>
                        <th>Jumlah Tiket</th>
                        <th>Total Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pembayaran)): ?>
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fas fa-credit-card"></i>
                                <p>Belum ada data pembayaran.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pembayaran as $p): ?>
                            <tr>
                                <td style="font-weight: 700; color: var(--accent-primary);">TRX-<?= esc((string)$p['ID_PEMBAYARAN']) ?></td>
                                <td>
                                    <span class="badge badge-info"><?= esc((string)($p['TIPE_PEMBAYARAN'] ?? '-')) ?></span>
                                </td>
                                <td style="font-weight: 600;"><?= esc((string)$p['JUMLAH_TIKET']) ?> tiket</td>
                                <td style="font-weight: 700; color: var(--success);">Rp <?= number_format((float)$p['TOTAL_HARGA'], 0, ',', '.') ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/detail-pembayaran') ?>?pembayaran=<?= $p['ID_PEMBAYARAN'] ?>" class="btn btn-info btn-sm" title="Lihat Detail Tiket">
                                            <i class="fas fa-receipt"></i>
                                        </a>
                                        <a href="<?= base_url('/pembayaran/edit/' . $p['ID_PEMBAYARAN']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/pembayaran/delete/' . $p['ID_PEMBAYARAN']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus transaksi ini?')">
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
