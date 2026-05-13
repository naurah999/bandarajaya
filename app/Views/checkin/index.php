<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Riwayat Check-in</h2>
        <a href="<?= base_url('/checkin/create') ?>" class="btn btn-primary">
            <i class="fas fa-clipboard-check"></i> Proses Check-in
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu Check-in</th>
                        <th>Nama Penumpang</th>
                        <th>No. Tiket</th>
                        <th>Rute</th>
                        <th>No. Kursi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($checkins)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-clipboard-check"></i>
                                <p>Belum ada penumpang yang check-in.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($checkins as $c): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 500;"><?= date('H:i', strtotime($c['WAKTU_CHECKIN'])) ?></div>
                                    <div style="font-size: 11px; color: var(--text-muted);"><?= date('d M Y', strtotime($c['WAKTU_CHECKIN'])) ?></div>
                                </td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($c['NAMA_PENUMPANG']) ?></td>
                                <td><span class="badge badge-info"><?= esc($c['NOMER_TIKET']) ?></span></td>
                                <td><?= esc($c['KOTA_ASAL']) ?> <i class="fas fa-arrow-right" style="font-size: 10px;"></i> <?= esc($c['KOTA_TUJUAN']) ?></td>
                                <td>
                                    <span class="badge badge-success"><?= esc($c['NO_KURSI2']) ?> (<?= esc($c['KELAS_PENERBANAN']) ?>)</span>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/checkin/edit/' . $c['ID_CHECKIN']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/checkin/delete/' . $c['ID_CHECKIN']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data check-in ini?')">
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
