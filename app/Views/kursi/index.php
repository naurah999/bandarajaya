<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Data Kursi Pesawat</h2>
        <a href="<?= base_url('/kursi/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Kursi
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maskapai</th>
                        <th>Tipe Pesawat</th>
                        <th>Kelas</th>
                        <th>No. Kursi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($kursi)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-chair"></i>
                                <p>Data kursi masih kosong.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($kursi as $k): ?>
                            <tr>
                                <td><?= esc($k['ID_KURSI']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($k['NAMA_MASKAPAI']) ?></td>
                                <td><?= esc($k['TIPE_PESAWAT']) ?></td>
                                <td><span class="badge badge-info"><?= esc($k['KELAS_PENERBANAN']) ?></span></td>
                                <td><span class="badge badge-success"><?= esc($k['NO_KURSI2']) ?></span></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/kursi/edit/' . $k['ID_KURSI']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/kursi/delete/' . $k['ID_KURSI']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data kursi ini?')">
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
