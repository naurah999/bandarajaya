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
                <?php if ($selectedFlight): ?>
                    <button type="button" class="btn btn-info no-print" onclick="window.print()" style="margin-left:10px;">
                        <i class="fas fa-print"></i> Cetak PDF
                    </button>
                <?php endif; ?>
            </form>
        </div>
    </div>
    <div class="card-body">
        <?php if ($selectedFlight): ?>
            
            <div class="print-header">
                <div class="print-header-top">
                    <div class="print-company">
                        <h2><?= esc($maskapai['NAMA_MASKAPAI']) ?></h2>
                    </div>
                    <div class="print-title">
                        <span style="font-weight: 700; color: #64748b; letter-spacing: 1px; font-size: 14px;">PASSENGER MANIFEST</span>
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
                        <strong>Detail Penerbangan</strong><br>
                        <?= esc($selectedFlight['TIPE_PESAWAT']) ?> (<?= esc($selectedFlight['NAMA_MASKAPAI']) ?>)<br>
                        <?= esc($selectedFlight['KOTA_ASAL']) ?> &rarr; <?= esc($selectedFlight['KOTA_TUJUAN']) ?><br>
                        <?= date('d M Y', strtotime($selectedFlight['TANGGAL_BERANGKAT'])) ?> | <?= $selectedFlight['WAKTU_BERANGKAT'] ?>
                    </div>
                </div>
            </div>

            <div style="background: var(--bg-secondary); padding: 15px; border-radius: 8px; margin-bottom: 20px; border-left: 4px solid var(--accent-primary);" class="no-print">
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
        
        .print-header-details { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 12px; color: #334155; line-height: 1.6; }
        .print-period { text-align: right; }

        table { width: 100%; border-collapse: collapse; margin-top: 20px; font-size: 12px; }
        th { border-bottom: 2px solid #0f172a; border-top: none; padding: 12px 8px; text-align: left; color: #0f172a; font-weight: 700; text-transform: uppercase; font-size: 11px; }
        td { border-bottom: 1px solid #e2e8f0; padding: 10px 8px; color: #334155; }
        .badge { background: none !important; color: #0f172a !important; padding: 0; border: none; font-weight: normal; }
        small { color: #64748b !important; }
    }
</style>

<?= $this->endSection() ?>
