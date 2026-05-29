<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>


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

    /* Bulk Edit Styles */
    .seat.selected {
        outline: 3px solid #3b82f6 !important;
        outline-offset: 2px !important;
        transform: scale(1.1) !important;
        z-index: 10 !important;
        box-shadow: 0 0 15px rgba(59, 130, 246, 0.6) !important;
    }

    .bulk-bar {
        position: fixed;
        bottom: 24px;
        left: 50%;
        transform: translateX(-50%) translateY(120px);
        background: #0f172a;
        color: white;
        padding: 14px 24px;
        border-radius: 16px;
        box-shadow: 0 10px 25px -5px rgba(0, 0, 0, 0.4), 0 8px 10px -6px rgba(0, 0, 0, 0.4);
        display: flex;
        align-items: center;
        gap: 20px;
        z-index: 1000;
        border: 1px solid #334155;
        transition: transform 0.4s cubic-bezier(0.16, 1, 0.3, 1), opacity 0.3s;
        opacity: 0;
        pointer-events: none;
    }
    
    .bulk-bar.show {
        transform: translateX(-50%) translateY(0);
        opacity: 1;
        pointer-events: auto;
    }

    .bulk-info {
        display: flex;
        align-items: center;
        gap: 10px;
        font-size: 13.5px;
        font-weight: 500;
    }

    .bulk-info i {
        color: #3b82f6;
        font-size: 16px;
    }

    .bulk-actions {
        display: flex;
        gap: 8px;
    }

    .bulk-actions .btn {
        padding: 6px 12px;
        font-size: 12px;
        font-weight: 600;
    }

    .switch-container {
        display: flex;
        align-items: center;
        gap: 10px;
        background: white;
        padding: 8px 18px;
        border-radius: 100px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
        cursor: pointer;
        user-select: none;
    }

    .switch-label {
        font-size: 12px;
        font-weight: 700;
        color: var(--text-secondary);
        text-transform: uppercase;
        letter-spacing: 0.5px;
    }

    .switch {
        position: relative;
        display: inline-block;
        width: 38px;
        height: 20px;
        margin-bottom: 0;
    }

    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }

    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #cbd5e1;
        transition: .3s;
        border-radius: 34px;
    }

    .slider:before {
        position: absolute;
        content: "";
        height: 14px;
        width: 14px;
        left: 3px;
        bottom: 3px;
        background-color: white;
        transition: .3s;
        border-radius: 50%;
    }

    input:checked + .slider {
        background-color: #3b82f6;
    }

    input:checked + .slider:before {
        transform: translateX(18px);
    }
</style>

<!-- Content: Visual Seating Map -->
<div>
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
            <!-- Seating Legend & Controls -->
            <div style="display:flex; justify-content:center; align-items:center; gap:20px; margin-bottom:30px; flex-wrap:wrap; width:100%;">
                <div class="legend-container" style="margin-bottom:0;">
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

                <label class="switch-container">
                    <span class="switch-label">Mode Blok / Seleksi Massal</span>
                    <span class="switch">
                        <input type="checkbox" id="bulkModeToggle" onchange="toggleBulkMode(this)">
                        <span class="slider"></span>
                    </span>
                </label>
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
                                        <div class="seat <?= $classClass ?> <?= $statusClass ?>"
                                             data-id="<?= $seat['ID_KURSI'] ?>"
                                             data-no="<?= esc($seat['NO_KURSI2']) ?>"
                                             data-class="<?= esc($seat['KELAS_PENERBANAN']) ?>"
                                             data-occupied="<?= $isOccupied ? 'true' : 'false' ?>"
                                             onclick="toggleSeatClass(this)">
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
                                        <div class="seat <?= $classClass ?> <?= $statusClass ?>"
                                             data-id="<?= $seat['ID_KURSI'] ?>"
                                             data-no="<?= esc($seat['NO_KURSI2']) ?>"
                                             data-class="<?= esc($seat['KELAS_PENERBANAN']) ?>"
                                             data-occupied="<?= $isOccupied ? 'true' : 'false' ?>"
                                             onclick="toggleSeatClass(this)">
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

<!-- Bulk Edit Floating Bar -->
<div id="bulk-edit-bar" class="bulk-bar">
    <div class="bulk-info">
        <i class="fas fa-th"></i>
        <span><strong id="selected-count">0</strong> kursi terpilih</span>
    </div>
    <div class="bulk-actions">
        <button class="btn btn-warning btn-sm" onclick="applyBulkClass('Bisnis')"><i class="fas fa-crown"></i> Set Bisnis</button>
        <button class="btn btn-info btn-sm" style="color: white; background: #3b82f6; border-color: #3b82f6;" onclick="applyBulkClass('Ekonomi')"><i class="fas fa-chair"></i> Set Ekonomi</button>
        <button class="btn btn-secondary btn-sm" onclick="cancelBulkSelection()"><i class="fas fa-times"></i> Batal</button>
    </div>
</div>

<script>
    // Toast notification function
    function showToast(message, type = 'success') {
        const toast = document.createElement('div');
        toast.style.position = 'fixed';
        toast.style.top = '24px';
        toast.style.right = '24px';
        toast.style.padding = '14px 24px';
        toast.style.borderRadius = '12px';
        toast.style.background = type === 'success' ? 'var(--success-bg, #ecfdf5)' : 'var(--danger-bg, #fef2f2)';
        toast.style.color = type === 'success' ? 'var(--success, #059669)' : 'var(--danger, #dc2626)';
        toast.style.border = '1px solid ' + (type === 'success' ? 'rgba(16, 185, 129, 0.2)' : 'rgba(239, 68, 68, 0.2)');
        toast.style.boxShadow = 'var(--shadow-lg)';
        toast.style.zIndex = '9999';
        toast.style.fontSize = '14px';
        toast.style.fontWeight = '600';
        toast.style.display = 'flex';
        toast.style.alignItems = 'center';
        toast.style.gap = '10px';
        toast.style.fontFamily = 'Inter, sans-serif';
        toast.style.animation = 'slideDown 0.3s ease forwards';

        const icon = document.createElement('i');
        icon.className = type === 'success' ? 'fas fa-check-circle' : 'fas fa-exclamation-circle';
        toast.appendChild(icon);

        const text = document.createTextNode(message);
        toast.appendChild(text);

        document.body.appendChild(toast);

        setTimeout(() => {
            toast.style.transition = 'opacity 0.5s ease, transform 0.5s ease';
            toast.style.opacity = '0';
            toast.style.transform = 'translateY(-20px)';
            setTimeout(() => toast.remove(), 500);
        }, 3000);
    }

    // Bulk selection state variables
    let bulkMode = false;
    let selectedSeats = [];

    function toggleBulkMode(checkbox) {
        bulkMode = checkbox.checked;
        if (!bulkMode) {
            cancelBulkSelection();
        }
    }

    function cancelBulkSelection() {
        document.querySelectorAll('.seat.selected').forEach(s => s.classList.remove('selected'));
        selectedSeats = [];
        updateBulkBar();
    }

    function updateBulkBar() {
        const bar = document.getElementById('bulk-edit-bar');
        const countSpan = document.getElementById('selected-count');
        
        if (selectedSeats.length > 0) {
            countSpan.textContent = selectedSeats.length;
            bar.classList.add('show');
        } else {
            bar.classList.remove('show');
        }
    }

    function applyBulkClass(newClass) {
        if (selectedSeats.length === 0) return;

        if (!confirm(`Ubah kelas ${selectedSeats.length} kursi terpilih menjadi ${newClass}?`)) {
            return;
        }

        // Send AJAX request for bulk update
        fetch(`<?= base_url('/kursi/bulk-update-class') ?>`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            },
            body: JSON.stringify({
                ids: selectedSeats,
                kelas: newClass
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                showToast(data.message, 'success');
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                showToast(data.message || 'Gagal mengubah kelas kursi.', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan koneksi.', 'danger');
        });
    }

    // Toggle seat class function
    function toggleSeatClass(element) {
        const isOccupied = element.getAttribute('data-occupied') === 'true';
        if (isOccupied) {
            showToast('Kursi ini sudah terisi, kelas tidak dapat diubah.', 'danger');
            return;
        }

        const seatId = parseInt(element.getAttribute('data-id'));
        const seatNo = element.getAttribute('data-no');

        // Check if bulk mode is active
        if (bulkMode) {
            const index = selectedSeats.indexOf(seatId);
            if (index > -1) {
                // Deselect seat
                selectedSeats.splice(index, 1);
                element.classList.remove('selected');
            } else {
                // Select seat
                selectedSeats.push(seatId);
                element.classList.add('selected');
            }
            updateBulkBar();
            return;
        }

        // Normal single click toggle mode
        const currentClass = element.getAttribute('data-class');
        const newClass = currentClass === 'Bisnis' ? 'Ekonomi' : 'Bisnis';

        if (!confirm(`Ubah kelas kursi ${seatNo} menjadi ${newClass}?`)) {
            return;
        }

        // Send AJAX request
        fetch(`<?= base_url('/kursi/toggle-class/') ?>${seatId}`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-Requested-With': 'XMLHttpRequest'
            }
        })
        .then(response => response.json())
        .then(data => {
            if (data.status === 'success') {
                // Update element attributes immediately for instant feedback
                element.setAttribute('data-class', data.new_class);
                
                element.classList.remove('seat-business', 'seat-economy');
                if (data.new_class === 'Bisnis') {
                    element.classList.add('seat-business');
                } else {
                    element.classList.add('seat-economy');
                }

                const badge = element.querySelector('.badge');
                if (badge) {
                    badge.textContent = data.new_class;
                    badge.classList.remove('badge-warning', 'badge-info');
                    if (data.new_class === 'Bisnis') {
                        badge.classList.add('badge-warning');
                    } else {
                        badge.classList.add('badge-info');
                    }
                }

                showToast(`Kelas kursi ${seatNo} berhasil diubah menjadi ${data.new_class}.`, 'success');
                
                // Reload after 800ms to synchronize all data (stats and CRUD table)
                setTimeout(() => {
                    window.location.reload();
                }, 800);
            } else {
                showToast(data.message || 'Gagal mengubah kelas kursi.', 'danger');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showToast('Terjadi kesalahan koneksi.', 'danger');
        });
    }


</script>

<?= $this->endSection() ?>
