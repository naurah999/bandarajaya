<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Data Karyawan & Crew</h2>
        <a href="<?= base_url('/karyawan/create') ?>" class="btn btn-primary">
            <i class="fas fa-user-plus"></i> Tambah Karyawan
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Nama Karyawan</th>
                        <th>Jabatan</th>
                        <th>No Telepon</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($karyawan)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-users"></i>
                                <p>Belum ada data karyawan.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($karyawan as $k): ?>
                            <tr>
                                <td><?= esc($k['ID_KARYAWAN']) ?></td>
                                <td style="font-weight: 600;"><?= esc($k['NAMA_KARYAWAN']) ?></td>
                                <td>
                                    <?php 
                                    $jabatan = esc($k['JABATAN']);
                                    $jBadge = (str_contains(strtolower($jabatan), 'pilot')) ? 'badge-primary' : 'badge-info';
                                    ?>
                                    <span class="badge <?= $jBadge ?>"><?= $jabatan ?></span>
                                </td>
                                <td><?= esc($k['NO_TELP'] ?? '-') ?></td>
                                <td>
                                    <span class="badge <?= ($k['STATUS_KERJA'] == 'Aktif') ? 'badge-success' : 'badge-danger' ?>">
                                        <?= esc($k['STATUS_KERJA']) ?>
                                    </span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/karyawan/edit/' . $k['ID_KARYAWAN']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/karyawan/delete/' . $k['ID_KARYAWAN']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data karyawan ini?')">
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
