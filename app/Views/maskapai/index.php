<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Daftar Maskapai</h2>
        <a href="<?= base_url('/maskapai/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Maskapai
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Maskapai</th>
                        <th>Kode</th>
                        <th>Negara Asal</th>
                        <th>Kontak</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($maskapai)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-building"></i>
                                <p>Data maskapai masih kosong.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($maskapai as $m): ?>
                            <tr>
                                <td><?= esc($m['ID_MASKAPAI']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($m['NAMA_MASKAPAI']) ?></td>
                                <td><span class="badge badge-info"><?= esc($m['KODE_MASKAPAI']) ?></span></td>
                                <td><?= esc($m['NEGARA_ASAL']) ?></td>
                                <td><?= esc($m['NO_KONTAK']) ?></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/maskapai/edit/' . $m['ID_MASKAPAI']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/maskapai/delete/' . $m['ID_MASKAPAI']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus data ini?')">
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
