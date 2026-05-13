<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Data Penumpang</h2>
        <a href="<?= base_url('/penumpang/create') ?>" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Penumpang
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Penumpang</th>
                        <th>No. Identitas</th>
                        <th>Jenis Kelamin</th>
                        <th>Tgl Lahir</th>
                        <th>No. Telp</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penumpang)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>Data penumpang masih kosong.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($penumpang as $p): ?>
                            <tr>
                                <td><?= esc($p['ID_PENUMPANG']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($p['NAMA_PENUMPANG']) ?></td>
                                <td><?= esc($p['NO_IDENTITAS']) ?></td>
                                <td><span class="badge badge-info"><?= esc($p['JENIS_KELAMIN']) ?></span></td>
                                <td><?= date('d M Y', strtotime($p['TANGGAL_LAHIR'])) ?></td>
                                <td><?= esc($p['NO_TELP']) ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/penumpang/edit/' . $p['ID_PENUMPANG']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/penumpang/delete/' . $p['ID_PENUMPANG']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data penumpang ini?')">
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
