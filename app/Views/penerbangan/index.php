<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Jadwal Penerbangan</h2>
        <a href="<?= base_url('/penerbangan/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Jadwal
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Maskapai & Pesawat</th>
                        <th>Rute</th>
                        <th>Gate</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penerbangan)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-route"></i>
                                <p>Belum ada jadwal penerbangan.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($penerbangan as $p): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);"><?= date('H:i', strtotime($p['WAKTU_BERANGKAT'])) ?></div>
                                    <div style="font-size: 11px;"><?= date('d M Y', strtotime($p['TANGGAL_BERANGKAT'])) ?></div>
                                </td>
                                <td>
                                    <div style="font-weight: 500;"><?= esc($p['NAMA_MASKAPAI']) ?></div>
                                    <div style="font-size: 12px; color: var(--text-muted);"><?= esc($p['TIPE_PESAWAT']) ?> (<?= esc($p['KODE_MASKAPAI']) ?>)</div>
                                </td>
                                <td>
                                    <div style="display:flex; align-items:center; gap:8px;">
                                        <span><?= esc($p['KOTA_ASAL']) ?></span>
                                        <i class="fas fa-long-arrow-alt-right" style="color: var(--accent-primary);"></i>
                                        <span><?= esc($p['KOTA_TUJUAN']) ?></span>
                                    </div>
                                </td>
                                <td><span class="badge badge-info">Gate <?= esc($p['NOMOR_GATE']) ?></span></td>
                                <td><span class="badge badge-success">On Schedule</span></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/penerbangan/edit/' . $p['ID_PENERBANGAN']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/penerbangan/delete/' . $p['ID_PENERBANGAN']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data penerbangan ini?')">
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
