<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Daftar Gate Terminal</h2>
        <a href="<?= base_url('/gate/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Gate
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nomor Gate</th>
                        <th>Terminal</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($gates)): ?>
                        <tr>
                            <td colspan="4" class="empty-state">
                                <i class="fas fa-door-open"></i>
                                <p>Data gate masih kosong.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($gates as $g): ?>
                            <tr>
                                <td><?= esc($g['ID_GATE']) ?></td>
                                <td><span class="badge badge-info">Gate <?= esc($g['NOMOR_GATE']) ?></span></td>
                                <td>Terminal <?= esc($g['TERMINAL']) ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/gate/edit/' . $g['ID_GATE']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/gate/delete/' . $g['ID_GATE']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus gate ini?')">
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
