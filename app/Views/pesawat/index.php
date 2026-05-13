<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Daftar Armada Pesawat</h2>
        <a href="<?= base_url('/pesawat/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Pesawat
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Maskapai</th>
                        <th>Kode</th>
                        <th>Pesawat</th>
                        <th>Kapasitas</th>
                        <th>Tahun</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($pesawat)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-plane"></i>
                                <p>Data pesawat masih kosong.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($pesawat as $p): ?>
                            <tr>
                                <td><?= esc($p['ID_PESAWAT']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($p['NAMA_MASKAPAI']) ?></td>
                                <td><span class="badge badge-info"><?= esc($p['KODE_PESAWAT'] ?? '-') ?></span></td>
                                <td style="font-weight: 500;"><?= esc($p['TIPE_PESAWAT']) ?></td>
                                <td><?= esc($p['KAPASITAS']) ?> Kursi</td>
                                <td><?= esc($p['TAHUN_PRODUKSI']) ?></td>
                                <td>
                                    <?php 
                                    $status = $p['STATUS_PESAWAT'] ?? 'Ready';
                                    $badgeClass = ($status == 'Ready') ? 'badge-success' : (($status == 'Maintenance') ? 'badge-warning' : 'badge-info');
                                    ?>
                                    <span class="badge <?= $badgeClass ?>"><?= esc($status) ?></span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/pesawat/edit/' . $p['ID_PESAWAT']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/pesawat/delete/' . $p['ID_PESAWAT']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data pesawat ini?')">
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
