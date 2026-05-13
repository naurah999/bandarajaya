<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Laporan Manifest Penumpang</h2>
        <div class="header-actions">
            <form action="<?= base_url('/laporan/manifest') ?>" method="get" style="display:flex; gap:10px; align-items:center;">
                <select name="id_penerbangan" class="form-control" style="width:300px;" required>
                    <option value="">-- Pilih Jadwal Penerbangan --</option>
                    <?php foreach ($penerbangan as $f): ?>
                        <option value="<?= $f['ID_PENERBANGAN'] ?>" <?= (isset($_GET['id_penerbangan']) && $_GET['id_penerbangan'] == $f['ID_PENERBANGAN']) ? 'selected' : '' ?>>
                            <?= esc($f['NAMA_MASKAPAI']) ?> (<?= esc($f['KODE_MASKAPAI']) ?>) - <?= esc($f['KOTA_ASAL']) ?> -> <?= esc($f['KOTA_TUJUAN']) ?> [<?= date('d/m/Y', strtotime($f['TANGGAL_BERANGKAT'])) ?>]
                        </option>
                    <?php endforeach; ?>
                </select>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-search"></i> Lihat Manifest
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <?php if ($selectedFlight): ?>
            <div style="background: var(--bg-secondary); padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid var(--accent-primary);">
                <div style="display:grid; grid-template-columns: 1fr 1fr; gap:10px;">
                    <div>
                        <p style="margin:0; font-size:0.85rem; color:var(--text-muted);">Pesawat / Maskapai</p>
                        <p style="margin:0; font-weight:700;"><?= esc($selectedFlight['TIPE_PESAWAT']) ?> (<?= esc($selectedFlight['NAMA_MASKAPAI']) ?>)</p>
                    </div>
                    <div>
                        <p style="margin:0; font-size:0.85rem; color:var(--text-muted);">Jadwal</p>
                        <p style="margin:0; font-weight:700;"><?= date('d F Y', strtotime($selectedFlight['TANGGAL_BERANGKAT'])) ?> | <?= $selectedFlight['WAKTU_BERANGKAT'] ?></p>
                    </div>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Nama Penumpang</th>
                            <th>No Identitas</th>
                            <th>L/P</th>
                            <th>Status Check-in</th>
                            <th>No Kursi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($manifest)): ?>
                            <tr>
                                <td colspan="6" class="empty-state">Belum ada penumpang untuk penerbangan ini.</td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($manifest as $index => $m): ?>
                                <tr>
                                    <td><?= $index + 1 ?></td>
                                    <td style="font-weight:600;"><?= esc($m['NAMA_PENUMPANG']) ?></td>
                                    <td><?= esc($m['NO_IDENTITAS']) ?></td>
                                    <td><?= esc($m['JENIS_KELAMIN']) ?></td>
                                    <td>
                                        <?php if ($m['WAKTU_CHECKIN']): ?>
                                            <span class="badge badge-success">Sudah Check-in</span>
                                            <br><small><?= date('d/m/Y H:i', strtotime($m['WAKTU_CHECKIN'])) ?></small>
                                        <?php else: ?>
                                            <span class="badge badge-warning">Belum Check-in</span>
                                        <?php endif; ?>
                                    </td>
                                    <td>
                                        <?php if ($m['NO_KURSI2']): ?>
                                            <span class="badge badge-info" style="font-size:1rem;"><?= esc($m['NO_KURSI2']) ?></span>
                                        <?php else: ?>
                                            -
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <div class="empty-state" style="padding: 60px;">
                <i class="fas fa-file-alt" style="font-size: 3rem; margin-bottom: 15px; opacity: 0.3;"></i>
                <p>Silahkan pilih jadwal penerbangan untuk melihat daftar manifest penumpang.</p>
            </div>
        <?php endif; ?>
    </div>
</div>

<?= $this->endSection() ?>
