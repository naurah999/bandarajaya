<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Boarding Pass Penumpang</h2>
        <a href="<?= base_url('/boardingpass/create') ?>" class="btn btn-primary">
            <i class="fas fa-id-card"></i> Cetak Boarding Pass
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu Boarding</th>
                        <th>Penumpang</th>
                        <th>No. Tiket</th>
                        <th>Gate</th>
                        <th>Kursi</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($boarding)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">
                                <i class="fas fa-id-card"></i>
                                <p>Belum ada boarding pass yang dicetak.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($boarding as $b): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 700; color: var(--accent-primary);"><?= date('H:i', strtotime($b['WAKTU_BOARDING'])) ?></div>
                                </td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($b['NAMA_PENUMPANG']) ?></td>
                                <td><span class="badge badge-info"><?= esc($b['NOMER_TIKET']) ?></span></td>
                                <td><span class="badge badge-warning">Gate <?= esc($b['NOMOR_GATE']) ?> (T<?= esc($b['TERMINAL']) ?>)</span></td>
                                <td><span class="badge badge-success"><?= esc($b['NO_KURSI2']) ?> (<?= esc($b['KELAS_PENERBANAN']) ?>)</span></td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/boardingpass/edit/' . $b['ID_BOARDING']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/boardingpass/delete/' . $b['ID_BOARDING']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus boarding pass ini?')">
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
