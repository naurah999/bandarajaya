<?php
/**
 * @var array $detail
 */
?>
<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Detail Pelunasan Pembayaran</h2>
        <a href="<?= base_url('/detail-pembayaran/create') ?>" class="btn btn-primary">
            <i class="fas fa-receipt"></i> Catat Pelunasan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tgl Bayar</th>
                        <th>Penumpang</th>
                        <th>No. Tiket</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($detail)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-receipt"></i>
                                <p>Belum ada detail pelunasan.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($detail as $d): ?>
                            <tr>
                                <td><?= date('d M Y H:i', strtotime((string)$d['TGL_BAYAR'])) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc((string)$d['NAMA_PENUMPANG']) ?></td>
                                <td><span class="badge badge-info"><?= esc((string)$d['NOMER_TIKET']) ?></span></td>
                                <td style="font-weight: 700; color: var(--info);">Rp <?= number_format((float)$d['JUMLAH_BAYAR'], 0, ',', '.') ?></td>
                                <td>
                                    <span class="badge <?= (string)$d['STATUS_PEMBAYARAN'] == 'Lunas' ? 'badge-success' : 'badge-warning' ?>">
                                        <?= esc((string)$d['STATUS_PEMBAYARAN']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/detail-pembayaran/edit/' . (string)$d['ID_MEMBAYAR']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="<?= base_url('/detail-pembayaran/delete/' . (string)$d['ID_MEMBAYAR']) ?>" class="btn btn-danger btn-sm" onclick="return confirm('Hapus detail ini?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
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
