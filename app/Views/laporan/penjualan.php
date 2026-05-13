<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Laporan Penjualan Tiket</h2>
        <div class="header-actions">
            <form action="<?= base_url('/laporan/penjualan') ?>" method="get" style="display:flex; gap:10px; align-items:center;">
                <input type="date" name="start_date" value="<?= $start_date ?>" class="form-control" style="width:auto;">
                <span>s/d</span>
                <input type="date" name="end_date" value="<?= $end_date ?>" class="form-control" style="width:auto;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
            </form>
        </div>
    </div>
    <div class="card-body">
        <?php 
        $totalRevenue = 0;
        foreach($penjualan as $p) {
            $totalRevenue += $p['JUMLAH_BAYAR'];
        }
        ?>
        
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:20px;">
            <div class="card" style="background: linear-gradient(135deg, var(--success), #2ecc71); color: white; border:none;">
                <div class="card-body" style="padding:15px;">
                    <p style="margin:0; font-size:0.9rem; opacity:0.9;">Total Pendapatan</p>
                    <h3 style="margin:5px 0 0 0;">Rp <?= number_format($totalRevenue, 0, ',', '.') ?></h3>
                </div>
            </div>
            <div class="card" style="background: linear-gradient(135deg, var(--accent-primary), #3498db); color: white; border:none;">
                <div class="card-body" style="padding:15px;">
                    <p style="margin:0; font-size:0.9rem; opacity:0.9;">Total Transaksi</p>
                    <h3 style="margin:5px 0 0 0;"><?= count($penjualan) ?> Transaksi</h3>
                </div>
            </div>
        </div>

        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>Tanggal</th>
                        <th>No Tiket</th>
                        <th>Penumpang</th>
                        <th>Metode</th>
                        <th>Jumlah Bayar</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($penjualan)): ?>
                        <tr>
                            <td colspan="6" class="empty-state">Data tidak ditemukan untuk periode ini.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($penjualan as $p): ?>
                            <tr>
                                <td><?= date('d/m/Y H:i', strtotime($p['TGL_BAYAR'])) ?></td>
                                <td style="font-weight:700;"><?= esc($p['NOMER_TIKET']) ?></td>
                                <td><?= esc($p['NAMA_PENUMPANG']) ?></td>
                                <td><span class="badge badge-info"><?= esc($p['TIPE_PEMBAYARAN']) ?></span></td>
                                <td style="font-weight:700; color: var(--success);">Rp <?= number_format($p['JUMLAH_BAYAR'], 0, ',', '.') ?></td>
                                <td><span class="badge badge-success"><?= esc($p['STATUS_PEMBAYARAN']) ?></span></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
