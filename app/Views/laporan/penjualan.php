<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Laporan Penjualan Tiket</h2>
        <div class="header-actions">
            <form action="<?= base_url('/laporan/penjualan') ?>" method="get" style="display:flex; gap:10px; align-items:center;" class="no-print">
                <input type="date" name="start_date" value="<?= $start_date ?>" class="form-control" style="width:auto;">
                <span>s/d</span>
                <input type="date" name="end_date" value="<?= $end_date ?>" class="form-control" style="width:auto;">
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-filter"></i> Filter
                </button>
                <button type="button" class="btn btn-info" onclick="window.print()" style="margin-left:10px;">
                    <i class="fas fa-print"></i> Cetak PDF
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
        
        <div class="print-header">
            <div class="print-header-top">
                <div class="print-company">
                    <h2><?= esc($maskapai['NAMA_MASKAPAI']) ?></h2>
                </div>
                <div class="print-title">
                    <span style="font-weight: 700; color: #64748b; letter-spacing: 1px; font-size: 14px;">LAPORAN PENJUALAN</span>
                </div>
            </div>
            
            <div class="print-header-details">
                <div class="print-address">
                    <strong>Kantor Pusat <?= esc($maskapai['NAMA_MASKAPAI']) ?></strong><br>
                    Kantor Pusat Maskapai<br>
                    <?= esc($maskapai['NEGARA_ASAL']) ?><br>
                    Tlp: <?= esc($maskapai['NO_KONTAK']) ?><br>
                    Kode: <?= esc($maskapai['KODE_MASKAPAI']) ?>
                </div>
                <div class="print-period">
                    <strong>Periode Laporan</strong><br>
                    <?= date('d M Y', strtotime($start_date)) ?> - <?= date('d M Y', strtotime($end_date)) ?>
                </div>
            </div>
            
            <div class="print-summary">
                <div class="summary-item">
                    <span>Total Transaksi</span>
                    <strong><?= count($penjualan) ?></strong>
                </div>
                <div class="summary-item">
                    <span>Total Pendapatan (IDR)</span>
                    <strong>Rp <?= number_format($totalRevenue, 0, ',', '.') ?></strong>
                </div>
            </div>
        </div>
        
        <div style="display:grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap:20px; margin-bottom:20px;" class="no-print">
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
</div>

<style>
    .print-header { display: none; }
    
    @media print {
        @page { size: A4; margin: 10mm; }
        body { background: white !important; font-family: 'Arial', sans-serif; -webkit-print-color-adjust: exact; print-color-adjust: exact; }
        .sidebar, .header, .navbar, .no-print, .card-header, .header-actions, .alert { display: none !important; }
        .main-content { margin: 0 !important; padding: 0 !important; width: 100% !important; }
        .card { border: none !important; box-shadow: none !important; }
        .card-body { padding: 0 !important; }
        
        .print-header { 
            display: block; 
            margin-bottom: 30px; 
            background: #f8fafc;
            padding: 30px;
            border-radius: 8px;
            -webkit-print-color-adjust: exact;
            print-color-adjust: exact;
        }
        
        .print-header-top { display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 40px; }
        .print-company h2 { margin: 0; font-size: 24px; color: #0f172a; font-weight: 800; }
        
        .print-header-details { display: flex; justify-content: space-between; margin-bottom: 30px; font-size: 12px; color: #334155; line-height: 1.6; }
        .print-period { text-align: right; }
        
        .print-summary {
            display: flex;
            justify-content: flex-start;
            gap: 40px;
            padding-top: 20px;
            border-top: 2px solid #e2e8f0;
        }
        .summary-item { display: flex; flex-direction: column; }
        .summary-item span { font-size: 11px; color: #64748b; font-weight: 700; text-transform: uppercase; margin-bottom: 4px; }
        .summary-item strong { font-size: 18px; color: #0f172a; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th { border-bottom: 2px solid #0f172a; border-top: none; padding: 12px 8px; text-align: left; color: #0f172a; font-weight: 700; text-transform: uppercase; font-size: 11px; }
        td { border-bottom: 1px solid #e2e8f0; padding: 10px 8px; color: #334155; }
        .badge { background: none !important; color: #0f172a !important; padding: 0; border: none; font-weight: normal; }
    }
</style>

<?= $this->endSection() ?>
