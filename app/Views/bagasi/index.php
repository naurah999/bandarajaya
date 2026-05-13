<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Data Bagasi Penumpang</h2>
        <a href="<?= base_url('/bagasi/create') ?>" class="btn btn-primary">
            <i class="fas fa-suitcase-rolling"></i> Tambah Bagasi
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Penumpang</th>
                        <th>No. Tiket</th>
                        <th>Berat (Kg)</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($bagasi)): ?>
                        <tr>
                            <td colspan="5" class="empty-state">
                                <i class="fas fa-suitcase-rolling"></i>
                                <p>Belum ada data bagasi.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($bagasi as $b): ?>
                            <tr>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc((string)($b['NAMA_PENUMPANG'] ?? '-')) ?></td>
                                <td><span class="badge badge-info"><?= esc((string)($b['NOMER_TIKET'] ?? '-')) ?></span></td>
                                <td style="font-weight: 700;"><?= number_format((float)$b['BERAT_BAGASI'], 1, ',', '.') ?> Kg</td>
                                <td>
                                    <span class="badge <?= $b['STATUS_BAGASI'] == 'Diterima' ? 'badge-success' : ($b['STATUS_BAGASI'] == 'Dalam Proses' ? 'badge-warning' : 'badge-info') ?>">
                                        <?= esc((string)$b['STATUS_BAGASI']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/bagasi/edit/' . $b['ID_BAGASI']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/bagasi/delete/' . $b['ID_BAGASI']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data bagasi ini?')">
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
