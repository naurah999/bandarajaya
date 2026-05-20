<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Tabs styling */
    .tabs-navigation {
        display: flex;
        gap: 12px;
        margin-bottom: 24px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 12px;
    }

    .tab-button {
        background: transparent;
        border: none;
        padding: 10px 20px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        border-radius: 8px;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }

    .tab-button:hover {
        background: #f1f5f9;
        color: var(--accent-primary);
    }

    .tab-button.active {
        background: #eff6ff;
        color: var(--accent-primary);
        box-shadow: var(--shadow-sm);
    }

    .tab-pane {
        display: none;
    }

    .tab-pane.active {
        display: block;
        animation: fadeIn 0.4s ease;
    }

    /* Filter & Info Section */
    .filter-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 24px;
        margin-bottom: 24px;
    }

    .filter-grid {
        display: grid;
        grid-template-columns: 2fr 1fr;
        gap: 24px;
        align-items: center;
    }

    @media (max-width: 768px) {
        .filter-grid {
            grid-template-columns: 1fr;
        }
    }

    /* Seating Map Container */
    .seating-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 24px;
        padding: 40px 24px;
        overflow-x: auto;
    }

    .airplane-hull {
        background: white;
        border: 2px solid #cbd5e1;
        border-radius: 50px 50px 100px 100px;
        padding: 60px 30px;
        box-shadow: var(--shadow-lg);
        min-width: 480px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        border-top: 10px solid #94a3b8;
    }

    .airplane-hull::before {
        content: "COCKPIT";
        font-size: 11px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #94a3b8;
        margin-bottom: 40px;
        border: 1.5px solid #cbd5e1;
        padding: 4px 16px;
        border-radius: 20px;
    }

    /* Legend */
    .legend-container {
        display: flex;
        justify-content: center;
        gap: 20px;
        flex-wrap: wrap;
        margin-bottom: 30px;
        background: white;
        padding: 14px 28px;
        border-radius: 100px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 13px;
        font-weight: 500;
    }

    .legend-color {
        width: 18px;
        height: 18px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
    }

    /* Seat Grid Elements */
    .seating-row {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        gap: 8px;
    }

    .row-label {
        width: 24px;
        text-align: center;
        font-size: 12px;
        font-weight: 700;
        color: var(--text-muted);
    }

    .col-group {
        display: flex;
        gap: 8px;
    }

    .aisle-spacer {
        width: 32px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 9px;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #cbd5e1;
        text-transform: uppercase;
    }

    /* Seat Button */
    .seat {
        width: 36px;
        height: 36px;
        border-radius: 8px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 11px;
        font-weight: 700;
        cursor: pointer;
        position: relative;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1.5px solid;
    }

    .seat-spacer {
        width: 36px;
        height: 36px;
    }

    /* Seat Status Variations */
    .seat-available.seat-economy {
        background: #f0f9ff;
        border-color: #3b82f6;
        color: #1d4ed8;
    }
    .seat-available.seat-economy:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }

    .seat-available.seat-business {
        background: #fffbeb;
        border-color: #f59e0b;
        color: #b45309;
    }
    .seat-available.seat-business:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .seat-occupied {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* Tooltip */
    .seat .tooltip {
        visibility: hidden;
        width: 220px;
        background-color: #0f172a;
        color: #fff;
        text-align: left;
        border-radius: 8px;
        padding: 12px;
        position: absolute;
        z-index: 100;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.25s, visibility 0.25s;
        font-size: 11.5px;
        line-height: 1.6;
        box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.3);
        pointer-events: none;
        border: 1px solid #334155;
    }

    .seat .tooltip::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #0f172a transparent transparent transparent;
    }

    .seat:hover .tooltip {
        visibility: visible;
        opacity: 1;
    }

    /* Stats Board */
    .stats-board {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 16px;
        margin-top: 24px;
        width: 100%;
        max-width: 600px;
    }

    .stat-box {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        padding: 12px;
        border-radius: 12px;
        text-align: center;
    }

    .stat-number {
        font-size: 18px;
        font-weight: 800;
        color: var(--text-primary);
    }

    .stat-desc {
        font-size: 10px;
        color: var(--text-muted);
        text-transform: uppercase;
        font-weight: 600;
        margin-top: 2px;
    }
</style>

<!-- Tabs Navigation -->
<div class="tabs-navigation">
    <button class="tab-button active" onclick="switchTab(this, 'peta-kursi')">
        <i class="fas fa-map"></i> Visual Peta Kursi
    </button>
    <button class="tab-button" onclick="switchTab(this, 'kelola-data')">
        <i class="fas fa-tasks"></i> Kelola Data Kursi (CRUD)
    </button>
</div>

<!-- Tab Content: Visual Seating Map -->
<div id="peta-kursi" class="tab-pane active">
    <!-- Filter Card -->
    <div class="filter-card">
        <form method="get" action="<?= base_url('/kursi') ?>" id="flightFilterForm">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom: 0;">
                    <label for="id_penerbangan">Pilih Jadwal Penerbangan:</label>
                    <select name="id_penerbangan" id="id_penerbangan" class="form-control" onchange="document.getElementById('flightFilterForm').submit();">
                        <?php if (empty($flights)): ?>
                            <option value="">-- Tidak ada penerbangan tersedia --</option>
                        <?php else: ?>
                            <?php foreach ($flights as $f): ?>
                                <option value="<?= esc($f['ID_PENERBANGAN']) ?>" <?= ($f['ID_PENERBANGAN'] == $selectedFlightId) ? 'selected' : '' ?>>
                                    <?= esc($f['NAMA_MASKAPAI']) ?> (<?= esc($f['KODE_MASKAPAI']) ?>-<?= esc($f['ID_PENERBANGAN']) ?>) | 
                                    <?= esc($f['KOTA_ASAL']) ?> → <?= esc($f['KOTA_TUJUAN']) ?> | 
                                    <?= date('d M Y', strtotime($f['TANGGAL_BERANGKAT'])) ?> (<?= esc($f['WAKTU_BERANGKAT']) ?>)
                                </option>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </select>
                </div>
                
                <?php if ($pesawat): ?>
                    <div style="background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:12px 18px; text-align:center;">
                        <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:#1d4ed8;">Informasi Armada</span>
                        <h4 style="margin:2px 0; font-weight:800; color:#1e3a8a;"><?= esc($pesawat['TIPE_PESAWAT']) ?></h4>
                        <span style="font-size:11px; color:#2563eb; font-weight:600;"><?= esc($pesawat['KODE_PESAWAT']) ?> (Cap: <?= esc($pesawat['KAPASITAS']) ?>)</span>
                    </div>
                <?php endif; ?>
            </div>
        </form>
    </div>

    <!-- Airplane View Section -->
    <?php if (empty($selectedFlightId)): ?>
        <div class="card" style="text-align:center; padding:60px 20px;">
            <i class="fas fa-plane-slash" style="font-size:48px; color:var(--text-muted); opacity:0.3; margin-bottom:16px;"></i>
            <p style="color:var(--text-secondary); font-weight:600;">Jadwal penerbangan belum tersedia atau belum dipilih.</p>
        </div>
    <?php else: ?>
        <div class="seating-section">
            <!-- Seating Legend -->
            <div class="legend-container">
                <div class="legend-item">
                    <div class="legend-color" style="background:#f0f9ff; border-color:#3b82f6;"></div>
                    <span>Ekonomi (Tersedia)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background:#fffbeb; border-color:#f59e0b;"></div>
                    <span>Bisnis (Tersedia)</span>
                </div>
                <div class="legend-item">
                    <div class="legend-color" style="background:#f1f5f9; border-color:#cbd5e1;"></div>
                    <span>Terisi (Check-in)</span>
                </div>
            </div>

            <!-- Plane Hull Rendering -->
            <div class="airplane-hull">
                <?php
                // Group seats by row and column
                $seatingGrid = [];
                $rows = [];
                $columns = ['A', 'B', 'C', 'D', 'E', 'F'];
                
                $totalOccupied = count($occupiedMap);
                $totalSeats = count($seats);
                $businessSeats = 0;
                $economySeats = 0;

                if (!empty($seats)) {
                    foreach ($seats as $seat) {
                        preg_match('/(\d+)([A-F])/i', $seat['NO_KURSI2'], $matches);
                        if (!empty($matches)) {
                            $rowNum = intval($matches[1]);
                            $colLetter = strtoupper($matches[2]);
                            $seatingGrid[$rowNum][$colLetter] = $seat;
                            if (!in_array($rowNum, $rows)) {
                                $rows[] = $rowNum;
                            }
                        } else {
                            $seatingGrid[99][$seat['NO_KURSI2']] = $seat;
                            if (!in_array(99, $rows)) {
                                $rows[] = 99;
                            }
                        }

                        if ($seat['KELAS_PENERBANAN'] == 'Bisnis') {
                            $businessSeats++;
                        } else {
                            $economySeats++;
                        }
                    }
                    sort($rows);
                }
                ?>

                <?php if (empty($seats)): ?>
                    <div style="text-align:center; padding:40px 20px; color:var(--text-muted);">
                        <i class="fas fa-ban" style="font-size:32px; margin-bottom:12px; opacity:0.5;"></i>
                        <p style="font-size:13px; font-weight:600;">Belum ada kursi yang terdaftar untuk pesawat ini.</p>
                        <p style="font-size:11px; margin-top:4px;">Silakan buat otomatis kursi lewat menu Pesawat, atau tambahkan manual di tab Kelola Data.</p>
                    </div>
                <?php else: ?>
                    <!-- Draw Seating Grid -->
                    <?php foreach ($rows as $r): ?>
                        <div class="seating-row">
                            <div class="row-label"><?= $r ?></div>
                            
                            <!-- Left Group (A, B, C) -->
                            <div class="col-group">
                                <?php foreach (['A', 'B', 'C'] as $c): ?>
                                    <?php if (isset($seatingGrid[$r][$c])): ?>
                                        <?php 
                                        $seat = $seatingGrid[$r][$c];
                                        $isOccupied = isset($occupiedMap[$seat['ID_KURSI']]);
                                        $passenger = $isOccupied ? $occupiedMap[$seat['ID_KURSI']] : null;
                                        $classClass = ($seat['KELAS_PENERBANAN'] == 'Bisnis') ? 'seat-business' : 'seat-economy';
                                        $statusClass = $isOccupied ? 'seat-occupied' : 'seat-available';
                                        ?>
                                        <div class="seat <?= $classClass ?> <?= $statusClass ?>">
                                            <?= $c ?>
                                            
                                            <!-- Tooltip details -->
                                            <div class="tooltip">
                                                <strong style="color:#60a5fa; font-size:13px;"><?= esc($seat['NO_KURSI2']) ?></strong>
                                                <span class="badge <?= ($seat['KELAS_PENERBANAN'] == 'Bisnis') ? 'badge-warning' : 'badge-info' ?> btn-sm" style="float:right; font-size:9px; padding:2px 6px;"><?= esc($seat['KELAS_PENERBANAN']) ?></span>
                                                <div style="margin-top: 8px; border-top: 1px solid #334155; padding-top: 6px;">
                                                    <strong>Status:</strong> <?= $isOccupied ? '<span style="color:#ef4444;font-weight:700;">Terisi</span>' : '<span style="color:#22c55e;font-weight:700;">Tersedia</span>' ?><br>
                                                    <?php if ($isOccupied): ?>
                                                        <strong>Penumpang:</strong> <?= esc($passenger['nama_penumpang']) ?><br>
                                                        <strong>No. Tiket:</strong> <?= esc($passenger['nomer_tiket']) ?>
                                                    <?php else: ?>
                                                        <span style="color:#94a3b8; font-style:italic;">Kursi kosong & siap untuk ditempati penumpang.</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="seat-spacer"></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <!-- Aisle -->
                            <div class="aisle-spacer">Aisle</div>

                            <!-- Right Group (D, E, F) -->
                            <div class="col-group">
                                <?php foreach (['D', 'E', 'F'] as $c): ?>
                                    <?php if (isset($seatingGrid[$r][$c])): ?>
                                        <?php 
                                        $seat = $seatingGrid[$r][$c];
                                        $isOccupied = isset($occupiedMap[$seat['ID_KURSI']]);
                                        $passenger = $isOccupied ? $occupiedMap[$seat['ID_KURSI']] : null;
                                        $classClass = ($seat['KELAS_PENERBANAN'] == 'Bisnis') ? 'seat-business' : 'seat-economy';
                                        $statusClass = $isOccupied ? 'seat-occupied' : 'seat-available';
                                        ?>
                                        <div class="seat <?= $classClass ?> <?= $statusClass ?>">
                                            <?= $c ?>
                                            
                                            <!-- Tooltip details -->
                                            <div class="tooltip">
                                                <strong style="color:#60a5fa; font-size:13px;"><?= esc($seat['NO_KURSI2']) ?></strong>
                                                <span class="badge <?= ($seat['KELAS_PENERBANAN'] == 'Bisnis') ? 'badge-warning' : 'badge-info' ?> btn-sm" style="float:right; font-size:9px; padding:2px 6px;"><?= esc($seat['KELAS_PENERBANAN']) ?></span>
                                                <div style="margin-top: 8px; border-top: 1px solid #334155; padding-top: 6px;">
                                                    <strong>Status:</strong> <?= $isOccupied ? '<span style="color:#ef4444;font-weight:700;">Terisi</span>' : '<span style="color:#22c55e;font-weight:700;">Tersedia</span>' ?><br>
                                                    <?php if ($isOccupied): ?>
                                                        <strong>Penumpang:</strong> <?= esc($passenger['nama_penumpang']) ?><br>
                                                        <strong>No. Tiket:</strong> <?= esc($passenger['nomer_tiket']) ?>
                                                    <?php else: ?>
                                                        <span style="color:#94a3b8; font-style:italic;">Kursi kosong & siap untuk ditempati penumpang.</span>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        </div>
                                    <?php else: ?>
                                        <div class="seat-spacer"></div>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </div>

                            <div class="row-label"><?= $r ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>

            <!-- Seating Stats Board -->
            <?php if (!empty($seats)): ?>
                <div class="stats-board">
                    <div class="stat-box">
                        <div class="stat-number"><?= $totalSeats ?> / <?= esc($pesawat['KAPASITAS']) ?></div>
                        <div class="stat-desc">Terdaftar</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number"><?= $totalSeats - $totalOccupied ?></div>
                        <div class="stat-desc" style="color:#059669;">Tersedia</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number"><?= $totalOccupied ?></div>
                        <div class="stat-desc" style="color:#dc2626;">Terisi</div>
                    </div>
                    <div class="stat-box">
                        <div class="stat-number"><?= ($totalSeats > 0) ? round(($totalOccupied / $totalSeats) * 100) : 0 ?>%</div>
                        <div class="stat-desc">Okupansi</div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    <?php endif; ?>
</div>

<!-- Tab Content: Seating CRUD Table Management -->
<div id="kelola-data" class="tab-pane">
    <div class="card">
        <div class="card-header">
            <h2>Data Kursi Pesawat (Manajemen CRUD)</h2>
            <a href="<?= base_url('/kursi/create') ?>" class="btn btn-primary">
                <i class="fas fa-plus"></i> Tambah Kursi
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Maskapai</th>
                            <th>Tipe Pesawat</th>
                            <th>Kelas</th>
                            <th>No. Kursi</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (empty($kursi)): ?>
                            <tr>
                                <td colspan="6" class="empty-state">
                                    <i class="fas fa-chair"></i>
                                    <p>Data kursi masih kosong.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($kursi as $k): ?>
                                <tr>
                                    <td><?= esc($k['ID_KURSI']) ?></td>
                                    <td style="font-weight: 600; color: var(--text-primary);"><?= esc($k['NAMA_MASKAPAI']) ?></td>
                                    <td><?= esc($k['TIPE_PESAWAT']) ?> (<?= esc($k['KODE_PESAWAT']) ?>)</td>
                                    <td>
                                        <span class="badge <?= ($k['KELAS_PENERBANAN'] == 'Bisnis') ? 'badge-warning' : 'badge-info' ?>">
                                            <?= esc($k['KELAS_PENERBANAN']) ?>
                                        </span>
                                    </td>
                                    <td><span class="badge badge-success"><?= esc($k['NO_KURSI2']) ?></span></td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="<?= base_url('/kursi/edit/' . $k['ID_KURSI']) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <form action="<?= base_url('/kursi/delete/' . $k['ID_KURSI']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Hapus data kursi ini?')">
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
</div>

<script>
    // Tab switching function
    function switchTab(button, tabId) {
        // Remove active class from all buttons and panes
        document.querySelectorAll('.tab-button').forEach(btn => btn.classList.remove('active'));
        document.querySelectorAll('.tab-pane').forEach(pane => pane.classList.remove('active'));

        // Add active class to selected button and pane
        button.classList.add('active');
        document.getElementById(tabId).classList.add('active');
        
        // Save selected tab in localStorage
        localStorage.setItem('activeKursiTab', tabId);
    }
    
    // Restore tab on reload
    document.addEventListener("DOMContentLoaded", function() {
        const savedTab = localStorage.getItem('activeKursiTab');
        if (savedTab) {
            const btn = Array.from(document.querySelectorAll('.tab-button')).find(
                b => b.getAttribute('onclick').includes(savedTab)
            );
            if (btn) {
                switchTab(btn, savedTab);
            }
        }
    });
</script>

<?= $this->endSection() ?>
