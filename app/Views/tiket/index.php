<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Daftar Tiket Penumpang</h2>
        <a href="<?= base_url('/tiket/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Buat Tiket
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>No. Tiket</th>
                        <th>Nama Penumpang</th>
                        <th>Penerbangan</th>
                        <th>Kelas</th>
                        <th>Asal -> Tujuan</th>
                        <th>Harga</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($tikets)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-ticket-alt"></i>
                                <p>Belum ada tiket yang terbit.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($tikets as $t): ?>
                            <tr>
                                <td style="font-weight: 700; color: var(--accent-primary);"><?= esc($t['NOMER_TIKET']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($t['NAMA_PENUMPANG']) ?></td>
                                <td><?= esc($t['NAMA_MASKAPAI']) ?></td>
                                <td><span class="badge badge-info"><?= esc($t['KELAS_TIKET'] ?? '-') ?></span></td>
                                <td>
                                    <div style="font-size: 13px;">
                                        <?= esc($t['KOTA_ASAL']) ?> <i class="fas fa-arrow-right" style="font-size: 10px; margin: 0 4px;"></i> <?= esc($t['KOTA_TUJUAN']) ?>
                                    </div>
                                    <div style="font-size: 11px; color: var(--text-muted);">
                                        <?= date('d M Y', strtotime($t['TANGGAL_BERANGKAT'])) ?>
                                    </div>
                                </td>
                                <td>Rp <?= number_format($t['HARGA'], 0, ',', '.') ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/tiket/edit/' . $t['ID_TIKET']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/tiket/delete/' . $t['ID_TIKET']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus tiket ini?')">
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
