<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Metode Pembayaran</h2>
        <a href="<?= base_url('/metode-pembayaran/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Metode
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipe Pembayaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($metode)): ?>
                        <tr>
                            <td colspan="3" class="empty-state">
                                <i class="fas fa-wallet"></i>
                                <p>Belum ada metode pembayaran.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($metode as $m): ?>
                            <tr>
                                <td><?= esc($m['ID_METODE']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($m['TIPE_PEMBAYARAN']) ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/metode-pembayaran/edit/' . $m['ID_METODE']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/metode-pembayaran/delete/' . $m['ID_METODE']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus metode ini?')">
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
