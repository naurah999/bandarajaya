<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--info-bg); color: var(--info);">
            <i class="fas fa-building"></i>
        </div>
        <div class="stat-value"><?= esc($total_maskapai) ?></div>
        <div class="stat-label">Total Maskapai</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--success-bg); color: var(--success);">
            <i class="fas fa-plane"></i>
        </div>
        <div class="stat-value"><?= esc($total_pesawat) ?></div>
        <div class="stat-label">Armada Pesawat</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--warning-bg); color: var(--warning);">
            <i class="fas fa-route"></i>
        </div>
        <div class="stat-value"><?= esc($total_penerbangan) ?></div>
        <div class="stat-label">Penerbangan Aktif</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--info-bg); color: var(--info);">
            <i class="fas fa-users"></i>
        </div>
        <div class="stat-value"><?= esc($total_penumpang) ?></div>
        <div class="stat-label">Total Penumpang</div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h2>Jadwal Penerbangan Terbaru</h2>
        <a href="<?= base_url('/penerbangan') ?>" class="btn btn-primary btn-sm">Lihat Semua</a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Waktu</th>
                        <th>Maskapai</th>
                        <th>Pesawat</th>
                        <th>Asal</th>
                        <th>Tujuan</th>
                        <th>Gate</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penerbangan_terbaru)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-plane-slash"></i>
                                <p>Belum ada jadwal penerbangan.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach (array_slice($penerbangan_terbaru, 0, 5) as $p): ?>
                            <tr>
                                <td>
                                    <div style="font-weight: 600; color: var(--text-primary);"><?= date('H:i', strtotime($p['WAKTU_BERANGKAT'])) ?></div>
                                    <div style="font-size: 11px;"><?= date('d M Y', strtotime($p['TANGGAL_BERANGKAT'])) ?></div>
                                </td>
                                <td><?= esc($p['NAMA_MASKAPAI']) ?> (<?= esc($p['KODE_MASKAPAI']) ?>)</td>
                                <td><?= esc($p['TIPE_PESAWAT']) ?></td>
                                <td><?= esc($p['KOTA_ASAL']) ?></td>
                                <td><?= esc($p['KOTA_TUJUAN']) ?></td>
                                <td><span class="badge badge-info">Gate <?= esc($p['NOMOR_GATE']) ?></span></td>
                                <td><span class="badge badge-success">On Schedule</span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="stats-grid" style="grid-template-columns: repeat(auto-fill, minmax(200px, 1fr));">
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--info-bg); color: var(--info);">
            <i class="fas fa-door-open"></i>
        </div>
        <div class="stat-value"><?= esc($total_gate) ?></div>
        <div class="stat-label">Gate Tersedia</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--success-bg); color: var(--success);">
            <i class="fas fa-ticket-alt"></i>
        </div>
        <div class="stat-value"><?= esc($total_tiket) ?></div>
        <div class="stat-label">Tiket Terjual</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--warning-bg); color: var(--warning);">
            <i class="fas fa-clipboard-check"></i>
        </div>
        <div class="stat-value"><?= esc($total_checkin) ?></div>
        <div class="stat-label">Sudah Check-in</div>
    </div>
    <div class="stat-card">
        <div class="stat-icon" style="background: var(--accent-gradient); color: white;">
            <i class="fas fa-id-card"></i>
        </div>
        <div class="stat-value"><?= esc($total_boarding) ?></div>
        <div class="stat-label">Sudah Boarding</div>
    </div>
</div>

<?= $this->endSection() ?>
