<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* ── Tab Navigation ──────────────────────────────────────── */
    .tabs-navigation {
        display: flex;
        gap: 8px;
        margin-bottom: 24px;
        border-bottom: 2px solid var(--border-color);
        padding-bottom: 0;
    }
    .tab-button {
        background: transparent;
        border: none;
        border-bottom: 3px solid transparent;
        padding: 10px 20px;
        margin-bottom: -2px;
        font-size: 14px;
        font-weight: 600;
        color: var(--text-secondary);
        cursor: pointer;
        border-radius: 8px 8px 0 0;
        transition: var(--transition);
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .tab-button:hover { background:#f1f5f9; color:var(--accent-primary); }
    .tab-button.active {
        background: #eff6ff;
        color: var(--accent-primary);
        border-bottom-color: var(--accent-primary);
    }
    .tab-pane { display: none; }
    .tab-pane.active { display: block; animation: fadeIn 0.3s ease; }

    /* ── Filter Card ─────────────────────────────────────────── */
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
    @media (max-width: 768px) { .filter-grid { grid-template-columns: 1fr; } }

    /* ── Seating Map ─────────────────────────────────────────── */
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

    /* ── Legend ──────────────────────────────────────────────── */
    .legend-container {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
        background: white;
        padding: 12px 24px;
        border-radius: 100px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }
    .legend-item {
        display: flex;
        align-items: center;
        gap: 7px;
        font-size: 12px;
        font-weight: 500;
    }
    .legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
        flex-shrink: 0;
    }

    .airplane-hull {
        user-select: none;
    }

    /* ── Seat Row Grid ───────────────────────────────────────── */
    .seating-row {
        display: flex;
        align-items: center;
        margin-bottom: 7px;
        gap: 7px;
    }
    .row-label {
        width: 22px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
    }
    .col-group { display: flex; gap: 7px; }
    .aisle-spacer {
        width: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        font-weight: 700;
        color: #cbd5e1;
        text-transform: uppercase;
    }

    /* ── Seat Button ─────────────────────────────────────────── */
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
        transition: all 0.2s cubic-bezier(0.4,0,0.2,1);
        border: 1.5px solid;
        user-select: none;
    }
    .seat-spacer { width:36px; height:36px; }
    .seat-occupied {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
    }

    /* ── Tooltip ─────────────────────────────────────────────── */
    .seat .tooltip {
        visibility: hidden;
        width: 200px;
        background: #0f172a;
        color: #fff;
        text-align: left;
        border-radius: 8px;
        padding: 10px 12px;
        position: absolute;
        z-index: 200;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.2s, visibility 0.2s;
        font-size: 11px;
        line-height: 1.6;
        box-shadow: 0 10px 15px -3px rgba(0,0,0,0.3);
        pointer-events: none;
        border: 1px solid #334155;
        font-weight: 400;
    }
    .seat .tooltip::after {
        content: "";
        position: absolute;
        top: 100%; left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #0f172a transparent transparent transparent;
    }
    .seat:hover .tooltip { visibility: visible; opacity: 1; }

    /* ── Stats Board ─────────────────────────────────────────── */
    .stats-board {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 12px;
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
    .stat-number { font-size: 18px; font-weight: 800; color: var(--text-primary); }
    .stat-desc   { font-size: 10px; color: var(--text-muted); text-transform: uppercase; font-weight: 600; margin-top: 2px; }

    /* ── Assign-Class Editor specific ────────────────────────── */
    .assign-toolbar {
        display: flex;
        gap: 12px;
        align-items: center;
        flex-wrap: wrap;
        background: white;
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 16px 20px;
        margin-bottom: 20px;
        box-shadow: var(--shadow-sm);
    }
    .assign-toolbar label { font-size: 13px; font-weight: 600; color: var(--text-secondary); white-space: nowrap; }
    .class-pill {
        display: inline-flex;
        align-items: center;
        gap: 8px;
        padding: 8px 16px;
        border-radius: 100px;
        border: 2px solid transparent;
        font-size: 13px;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.18s ease;
        background: #f1f5f9;
        color: var(--text-secondary);
    }
    .class-pill:hover { opacity: 0.85; transform: translateY(-1px); }
    .class-pill.active-pill { border-color: #0f172a; box-shadow: 0 0 0 3px rgba(15,23,42,0.12); }
    .class-pill .pill-dot {
        width: 12px; height: 12px;
        border-radius: 50%;
        display: inline-block;
        flex-shrink: 0;
    }

    .seat.editor-selected {
        outline: 3px solid #0f172a !important;
        outline-offset: 2px;
        transform: scale(1.1);
        z-index: 10;
    }
    .block-select-mode .seat-available {
        cursor: crosshair !important;
    }
    .selection-hint {
        font-size: 12px;
        color: var(--text-muted);
        margin-left: auto;
        font-weight: 500;
        font-style: italic;
    }

    /* Block-drag highlight overlay */
    .seat.drag-hover {
        outline: 2px dashed #6366f1 !important;
        outline-offset: 2px;
    }

    /* Assign action bar */
    .assign-action-bar {
        display: flex;
        align-items: center;
        gap: 12px;
        background: #eff6ff;
        border: 1px solid #bfdbfe;
        border-radius: 12px;
        padding: 12px 20px;
        margin-top: 16px;
        flex-wrap: wrap;
    }
    .assign-action-bar .selected-count {
        font-weight: 700;
        font-size: 14px;
        color: var(--accent-primary);
    }

    /* Plane selector card */
    .plane-selector-card {
        background: var(--bg-card);
        border: 1px solid var(--border-color);
        border-radius: 16px;
        padding: 20px 24px;
        margin-bottom: 20px;
    }
</style>

<!-- ═══ TAB NAVIGATION ══════════════════════════════════════════════════════ -->
<div class="tabs-navigation">
    <button class="tab-button active" onclick="switchTab('tab-peta', this)" id="btn-tab-peta">
        <i class="fas fa-map"></i> Peta Kursi
    </button>
    <button class="tab-button" onclick="switchTab('tab-atur', this)" id="btn-tab-atur">
        <i class="fas fa-tags"></i> Atur Kelas Kursi
    </button>
</div>

<!-- ═══ TAB 1: PETA KURSI ════════════════════════════════════════════════════ -->
<div id="tab-peta" class="tab-pane active">

    <!-- Filter Card -->
    <div class="filter-card">
        <form method="get" action="<?= base_url('/kursi') ?>" id="flightFilterForm">
            <div class="filter-grid">
                <div class="form-group" style="margin-bottom:0;">
                    <label for="id_penerbangan">Pilih Jadwal Penerbangan:</label>
                    <select name="id_penerbangan" id="id_penerbangan" class="form-control"
                            onchange="document.getElementById('flightFilterForm').submit();">
                        <?php if (empty($flights)): ?>
                            <option value="">-- Tidak ada penerbangan tersedia --</option>
                        <?php else: ?>
                            <?php foreach ($flights as $f): ?>
                                <option value="<?= esc($f['ID_PENERBANGAN']) ?>"
                                    <?= ($f['ID_PENERBANGAN'] == $selectedFlightId) ? 'selected' : '' ?>>
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

    <!-- Airplane View -->
    <?php if (empty($selectedFlightId)): ?>
        <div class="card" style="text-align:center; padding:60px 20px;">
            <i class="fas fa-plane-slash" style="font-size:48px; color:var(--text-muted); opacity:0.3; margin-bottom:16px;"></i>
            <p style="color:var(--text-secondary); font-weight:600;">Jadwal penerbangan belum tersedia atau belum dipilih.</p>
        </div>
    <?php else: ?>
        <div class="seating-section">

            <!-- Dynamic Class Legend -->
            <div class="legend-container">
                <?php foreach ($classColors as $name => $color): ?>
                    <div class="legend-item">
                        <div class="legend-color" style="background:<?= esc($color) ?>22; border-color:<?= esc($color) ?>;"></div>
                        <span><?= esc($name) ?> (Tersedia)</span>
                    </div>
                <?php endforeach; ?>
                <div class="legend-item">
                    <div class="legend-color" style="background:#f1f5f9; border-color:#cbd5e1;"></div>
                    <span>Terisi (Check-in)</span>
                </div>
            </div>

            <!-- Dynamic seat class CSS -->
            <style>
            <?php foreach ($classColors as $name => $color):
                $slug = url_title($name, '-', true);
            ?>
                .seat-class-<?= $slug ?>.seat-available {
                    background: <?= $color ?>15 !important;
                    border-color: <?= $color ?> !important;
                    color: <?= $color ?> !important;
                }
                .seat-class-<?= $slug ?>.seat-available:hover {
                    background: <?= $color ?> !important;
                    color: white !important;
                    box-shadow: 0 4px 10px <?= $color ?>44 !important;
                    transform: translateY(-2px);
                }
            <?php endforeach; ?>
            </style>

            <!-- Plane Hull -->
            <div class="airplane-hull">
                <?php
                $seatingGrid  = [];
                $rows         = [];
                $totalOccupied = count($occupiedMap);
                $totalSeats    = count($seats);

                if (!empty($seats)) {
                    foreach ($seats as $seat) {
                        preg_match('/(\d+)([A-Z])/i', $seat['NO_KURSI2'], $m);
                        if (!empty($m)) {
                            $r = intval($m[1]);
                            $c = strtoupper($m[2]);
                            $seatingGrid[$r][$c] = $seat;
                            if (!in_array($r, $rows)) $rows[] = $r;
                        }
                    }
                    sort($rows);
                }
                ?>

                <?php if (empty($seats)): ?>
                    <div style="text-align:center; padding:40px; color:var(--text-muted);">
                        <i class="fas fa-ban" style="font-size:32px; margin-bottom:12px; opacity:0.5;"></i>
                        <p style="font-size:13px; font-weight:600;">Belum ada kursi untuk pesawat ini.</p>
                        <p style="font-size:11px;">Silakan atur kursi di tab <strong>Atur Kelas Kursi</strong>.</p>
                    </div>
                <?php else: ?>
                    <?php foreach ($rows as $r): ?>
                        <?php
                        $layoutParts = explode('-', $layoutKursi);
                        
                        // Standardize expected letters based on layout
                        $expectedLetters = [];
                        if ($layoutKursi == '2-4-2') {
                            $expectedLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
                        } else if ($layoutKursi == '2-2-2') {
                            $expectedLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
                        } else if ($layoutKursi == '3-3') {
                            $expectedLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
                        } else if ($layoutKursi == '2-2') {
                            $expectedLetters = ['A', 'B', 'C', 'D'];
                        } else if ($layoutKursi == '1-2-1') {
                            $expectedLetters = ['A', 'D', 'G', 'K'];
                        } else {
                            $totalExpected = array_sum($layoutParts);
                            for($i=0; $i<$totalExpected; $i++) {
                                $expectedLetters[] = chr(65 + $i);
                            }
                        }
                        ?>

                        <div class="seating-row">
                            <div class="row-label"><?= $r ?></div>

                            <?php 
                            $letterIdx = 0;
                            foreach ($layoutParts as $groupIndex => $groupSize): 
                                $groupSize = (int)$groupSize;
                            ?>
                                <!-- Group -->
                                <div class="col-group">
                                    <?php for ($i = 0; $i < $groupSize; $i++): ?>
                                        <?php 
                                        $c = $expectedLetters[$letterIdx] ?? 'A';
                                        $letterIdx++;
                                        ?>
                                        <?php if (isset($seatingGrid[$r][$c])): ?>
                                            <?php
                                            $seat       = $seatingGrid[$r][$c];
                                            $isOccupied = isset($occupiedMap[$seat['ID_KURSI']]);
                                            $passenger  = $isOccupied ? $occupiedMap[$seat['ID_KURSI']] : null;
                                            $slug       = url_title($seat['KELAS_PENERBANAN'], '-', true);
                                            $seatColor  = $classColors[$seat['KELAS_PENERBANAN']] ?? '#3b82f6';
                                            $statusCls  = $isOccupied ? 'seat-occupied' : 'seat-available';
                                            ?>
                                            <div class="seat seat-class-<?= $slug ?> <?= $statusCls ?>">
                                                <?= $c ?>
                                                <div class="tooltip">
                                                    <strong style="color:#60a5fa; font-size:13px;"><?= esc($seat['NO_KURSI2']) ?></strong>
                                                    <span class="badge btn-sm" style="float:right;font-size:9px;padding:2px 6px;background:<?= $seatColor ?>;color:white;"><?= esc($seat['KELAS_PENERBANAN']) ?></span>
                                                    <div style="margin-top:8px;border-top:1px solid #334155;padding-top:6px;">
                                                        <strong>Status:</strong>
                                                        <?= $isOccupied ? '<span style="color:#ef4444;font-weight:700;">Terisi</span>' : '<span style="color:#22c55e;font-weight:700;">Tersedia</span>' ?><br>
                                                        <?php if ($isOccupied): ?>
                                                            <strong>Penumpang:</strong> <?= esc($passenger['nama_penumpang']) ?><br>
                                                            <strong>No. Tiket:</strong> <?= esc($passenger['nomer_tiket']) ?>
                                                        <?php else: ?>
                                                            <span style="color:#94a3b8;font-style:italic;">Kursi kosong &amp; siap ditempati.</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <div class="seat-spacer"></div>
                                        <?php endif; ?>
                                    <?php endfor; ?>
                                </div>
                                
                                <?php if ($groupIndex < count($layoutParts) - 1): ?>
                                    <div class="aisle-spacer">Aisle</div>
                                <?php endif; ?>

                            <?php endforeach; ?>

                            <div class="row-label"><?= $r ?></div>
                        </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div><!-- /.airplane-hull -->

            <!-- Stats -->
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

        </div><!-- /.seating-section -->
    <?php endif; ?>
</div><!-- /#tab-peta -->


<!-- ═══ TAB 2: ATUR KELAS KURSI ═════════════════════════════════════════════ -->
<div id="tab-atur" class="tab-pane">

    <!-- Plane Selector -->
    <div class="plane-selector-card">
        <div class="filter-grid">
            <div class="form-group" style="margin-bottom:0;">
                <label for="editorPlaneSelect">Pilih Pesawat:</label>
                <select id="editorPlaneSelect" class="form-control">
                    <option value="">-- Pilih Pesawat --</option>
                    <?php foreach ($allPesawat as $p): ?>
                        <option value="<?= esc($p['ID_PESAWAT']) ?>">
                            <?= esc($p['KODE_PESAWAT']) ?> — <?= esc($p['TIPE_PESAWAT']) ?> (Cap: <?= esc($p['KAPASITAS']) ?>)
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div id="editorPlaneInfo" style="display:none; background:#eff6ff; border:1px solid #bfdbfe; border-radius:12px; padding:12px 18px; text-align:center;">
                <span style="font-size:11px; text-transform:uppercase; font-weight:700; color:#1d4ed8;" id="editorPlaneTipe">—</span>
                <h4 style="margin:2px 0; font-weight:800; color:#1e3a8a;" id="editorPlaneKode">—</h4>
                <span style="font-size:11px; color:#2563eb; font-weight:600;" id="editorPlaneCap">—</span>
            </div>
        </div>
    </div>

    <!-- Editor Loading / Empty state -->
    <div id="editorEmpty" style="text-align:center; padding:60px; color:var(--text-muted);">
        <i class="fas fa-mouse-pointer" style="font-size:40px; opacity:0.25; margin-bottom:16px; display:block;"></i>
        <p style="font-weight:600;">Pilih pesawat di atas untuk mulai mengatur kelas kursi.</p>
    </div>

    <!-- Editor (hidden until plane selected) -->
    <div id="editorPanel" style="display:none;">

        <!-- Class Selector Toolbar -->
        <div class="assign-toolbar">
            <label><i class="fas fa-tags"></i> Pilih Kelas:</label>
            <div id="classPillsContainer" style="display:flex; gap:8px; flex-wrap:wrap;"></div>
            <div class="selection-hint" id="selectionHint">Klik kursi untuk memilih, atau seret untuk blok</div>
        </div>

        <!-- Seat class CSS injected dynamically -->
        <style id="editorDynamicStyles"></style>

        <!-- Legend -->
        <div class="legend-container" id="editorLegend" style="margin-bottom:20px;"></div>

        <!-- Seating Map -->
        <div class="seating-section">
            <div class="airplane-hull" id="editorAirplaneHull"></div>
        </div>

        <!-- Action Bar -->
        <div class="assign-action-bar" id="assignActionBar" style="display:none;">
            <span class="selected-count" id="selectedCount">0 kursi dipilih</span>
            <span style="color:var(--text-muted); font-size:13px;">→ Tetapkan ke kelas:</span>
            <div id="actionClassPills" style="display:flex; gap:8px; flex-wrap:wrap;"></div>
            <button class="btn btn-sm" style="margin-left:auto; background:#f1f5f9; color:var(--text-secondary); border:1px solid var(--border-color);"
                    onclick="clearEditorSelection()">
                <i class="fas fa-times"></i> Batal Pilih
            </button>
        </div>

        <!-- Toast notification -->
        <div id="editorToast" style="display:none; position:fixed; bottom:32px; right:32px; background:#0f172a; color:white; padding:14px 22px; border-radius:16px; font-weight:600; font-size:14px; z-index:9999; box-shadow: 0 10px 30px rgba(0,0,0,0.3); animation:slideInRight 0.3s ease;">
            <i class="fas fa-check-circle" style="color:#22c55e; margin-right:8px;"></i>
            <span id="editorToastMsg"></span>
        </div>
    </div>
</div><!-- /#tab-atur -->


<script>
// ── Tab switching ──────────────────────────────────────────────────────────
function switchTab(tabId, btn) {
    document.querySelectorAll('.tab-pane').forEach(p => p.classList.remove('active'));
    document.querySelectorAll('.tab-button').forEach(b => b.classList.remove('active'));
    document.getElementById(tabId).classList.add('active');
    btn.classList.add('active');
}

// ── Slug helper (mirrors PHP url_title) ──────────────────────────────────
function toSlug(str) {
    return str.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
}

// ── Editor state ─────────────────────────────────────────────────────────
let editorSeats       = [];
let editorClasses     = {};   // name => color
let editorLayoutKursi = '3-3';// global layout
let editorSelected    = new Set();  // selected ID_KURSI (as strings)
let activePillClass   = null;       // currently highlighted class pill
let isDragging        = false;
let dragStartSeat     = null;

// ── Fetch plane data and render editor ───────────────────────────────────
document.getElementById('editorPlaneSelect').addEventListener('change', function () {
    const id = this.value;
    if (!id) {
        document.getElementById('editorEmpty').style.display  = 'block';
        document.getElementById('editorPanel').style.display  = 'none';
        document.getElementById('editorPlaneInfo').style.display = 'none';
        return;
    }
    document.getElementById('editorEmpty').innerHTML =
        '<i class="fas fa-spinner fa-spin" style="font-size:32px; opacity:0.4; margin-bottom:12px; display:block;"></i><p>Memuat data kursi...</p>';
    document.getElementById('editorEmpty').style.display  = 'block';
    document.getElementById('editorPanel').style.display  = 'none';

    fetch('<?= base_url('/kursi/get-plane-seats/') ?>' + id)
        .then(r => r.json())
        .then(data => {
            editorSeats       = data.seats       || [];
            editorClasses     = data.classes     || {};
            editorLayoutKursi = data.layoutKursi || '3-3';
            const pesawat = data.pesawat || {};

            // Plane info badge
            document.getElementById('editorPlaneTipe').textContent = pesawat.TIPE_PESAWAT || '—';
            document.getElementById('editorPlaneKode').textContent = pesawat.KODE_PESAWAT  || '—';
            document.getElementById('editorPlaneCap').textContent  = 'Kapasitas: ' + (pesawat.KAPASITAS || '—');
            document.getElementById('editorPlaneInfo').style.display = 'block';

            buildEditorUI();
            document.getElementById('editorEmpty').style.display = 'none';
            document.getElementById('editorPanel').style.display = 'block';
        })
        .catch(() => {
            document.getElementById('editorEmpty').innerHTML =
                '<i class="fas fa-exclamation-triangle" style="font-size:32px; color:var(--danger); opacity:0.6; margin-bottom:12px; display:block;"></i><p style="color:var(--danger);">Gagal memuat data kursi.</p>';
        });
});

function buildEditorUI() {
    clearEditorSelection();
    buildEditorDynamicCSS();
    buildEditorLegend();
    buildClassPills();
    renderEditorMap();
    updateActionBar();
}

// ── Dynamic CSS ───────────────────────────────────────────────────────────
function buildEditorDynamicCSS() {
    let css = '';
    Object.entries(editorClasses).forEach(([name, color]) => {
        const slug = toSlug(name);
        css += `
            .ec-${slug} { background:${color}15 !important; border-color:${color} !important; color:${color} !important; }
            .ec-${slug}:hover { background:${color} !important; color:white !important; box-shadow:0 4px 10px ${color}44 !important; }
        `;
    });
    document.getElementById('editorDynamicStyles').textContent = css;
}

// ── Legend ────────────────────────────────────────────────────────────────
function buildEditorLegend() {
    const leg = document.getElementById('editorLegend');
    leg.innerHTML = '';
    Object.entries(editorClasses).forEach(([name, color]) => {
        leg.innerHTML += `<div class="legend-item">
            <div class="legend-color" style="background:${color}22;border-color:${color};"></div>
            <span>${name}</span>
        </div>`;
    });
    leg.innerHTML += `<div class="legend-item">
        <div class="legend-color" style="background:#f1f5f9;border-color:#cbd5e1;"></div>
        <span>Belum ditetapkan</span>
    </div>
    <div class="legend-item">
        <div class="legend-color" style="background:#6366f1;border-color:#4f46e5;"></div>
        <span>Terpilih</span>
    </div>`;
}

// ── Class Pills ───────────────────────────────────────────────────────────
function buildClassPills() {
    const container = document.getElementById('classPillsContainer');
    const action    = document.getElementById('actionClassPills');
    container.innerHTML = '';
    action.innerHTML    = '';

    if (Object.keys(editorClasses).length === 0) {
        container.innerHTML = '<span style="color:var(--danger);font-size:13px;"><i class="fas fa-exclamation-triangle"></i> Catalog pesawat ini belum memiliki kelas. Tambahkan di menu Catalog Pesawat.</span>';
        return;
    }

    Object.entries(editorClasses).forEach(([name, color]) => {
        // top toolbar pill
        const pill = document.createElement('span');
        pill.className   = 'class-pill';
        pill.style.background = color + '18';
        pill.style.color      = color;
        pill.style.borderColor = color + '55';
        pill.dataset.class    = name;
        pill.innerHTML = `<span class="pill-dot" style="background:${color};"></span>${name}`;
        pill.addEventListener('click', () => toggleActivePill(pill, name));
        container.appendChild(pill);

        // action bar quick-assign pill
        const aPill = document.createElement('button');
        aPill.className = 'btn btn-sm';
        aPill.style.cssText = `background:${color};color:white;border:none;border-radius:100px;padding:6px 16px;font-weight:700;font-size:12px;cursor:pointer;`;
        aPill.innerHTML = name;
        aPill.addEventListener('click', () => assignSelectedSeats(name));
        action.appendChild(aPill);
    });
}

function toggleActivePill(pill, name) {
    const wasActive = activePillClass === name;
    // deactivate all
    document.querySelectorAll('.class-pill').forEach(p => p.classList.remove('active-pill'));
    if (wasActive) {
        activePillClass = null;
    } else {
        activePillClass = name;
        pill.classList.add('active-pill');
    }
}

// ── Render Editor Map ─────────────────────────────────────────────────────
function renderEditorMap() {
    const hull = document.getElementById('editorAirplaneHull');
    hull.innerHTML = '';

    if (editorSeats.length === 0) {
        hull.innerHTML = '<div style="padding:40px;text-align:center;color:var(--text-muted);"><i class="fas fa-ban" style="font-size:28px;opacity:0.4;margin-bottom:10px;display:block;"></i><p>Belum ada kursi terdaftar untuk pesawat ini.<br><small>Generate kursi otomatis dari menu Pesawat.</small></p></div>';
        return;
    }

    // Build grid
    const grid   = {};
    const rows   = [];
    const cols   = [];

    editorSeats.forEach(s => {
        const m = s.NO_KURSI2.match(/(\d+)([A-Z])/i);
        if (m) {
            const r = parseInt(m[1]), c = m[2].toUpperCase();
            if (!grid[r]) grid[r] = {};
            grid[r][c] = s;
            if (!rows.includes(r)) rows.push(r);
            if (!cols.includes(c)) cols.push(c);
        }
    });
    rows.sort((a,b) => a-b); cols.sort();

    rows.forEach(r => {
        const layoutStr = editorLayoutKursi;
        const layoutParts = layoutStr.split('-');

        // Build expected letters
        let expectedLetters = [];
        if (layoutStr == '2-4-2') {
            expectedLetters = ['A', 'B', 'C', 'D', 'E', 'F', 'G', 'H'];
        } else if (layoutStr == '2-2-2') {
            expectedLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
        } else if (layoutStr == '3-3') {
            expectedLetters = ['A', 'B', 'C', 'D', 'E', 'F'];
        } else if (layoutStr == '2-2') {
            expectedLetters = ['A', 'B', 'C', 'D'];
        } else if (layoutStr == '1-2-1') {
            expectedLetters = ['A', 'D', 'G', 'K'];
        } else {
            const total = layoutParts.reduce((a,b) => parseInt(a)+parseInt(b), 0);
            for (let i=0; i<total; i++) expectedLetters.push(String.fromCharCode(65+i));
        }

        const rowDiv = document.createElement('div');
        rowDiv.className = 'seating-row';
        rowDiv.appendChild(makeRowLabel(r));

        let letterIdx = 0;
        layoutParts.forEach((size, groupIdx) => {
            const grpSize = parseInt(size);
            const colsForGrp = [];
            for (let i=0; i<grpSize; i++) {
                colsForGrp.push(expectedLetters[letterIdx] || 'A');
                letterIdx++;
            }
            rowDiv.appendChild(makeColGroup(colsForGrp, r, grid));

            if (groupIdx < layoutParts.length - 1) {
                const aisle = document.createElement('div');
                aisle.className = 'aisle-spacer';
                aisle.textContent = 'Aisle';
                rowDiv.appendChild(aisle);
            }
        });

        rowDiv.appendChild(makeRowLabel(r));
        hull.appendChild(rowDiv);
    });

    // Block-drag via mousedown/mouseover/mouseup on the hull
    hull.addEventListener('mousedown', onDragStart);
    hull.addEventListener('mouseover', onDragOver);
    window.addEventListener('mouseup', onDragEnd);
}

function makeRowLabel(r) {
    const el = document.createElement('div');
    el.className   = 'row-label';
    el.textContent = r;
    return el;
}

function makeColGroup(colArr, r, grid) {
    const grp = document.createElement('div');
    grp.className = 'col-group';
    colArr.forEach(c => {
        const seat = grid[r] ? grid[r][c] : null;
        grp.appendChild(makeSeatEl(seat, c));
    });
    return grp;
}

function makeSeatEl(seat, colLetter) {
    if (!seat) {
        const sp = document.createElement('div');
        sp.className = 'seat-spacer';
        return sp;
    }

    const color   = editorClasses[seat.KELAS_PENERBANAN] || '#94a3b8';
    const slug    = toSlug(seat.KELAS_PENERBANAN);
    const hasClass = seat.KELAS_PENERBANAN && editorClasses[seat.KELAS_PENERBANAN];

    const el = document.createElement('div');
    el.className = 'seat ec-' + (hasClass ? slug : 'unset');
    if (!hasClass) {
        el.style.cssText = 'background:#f1f5f9;border-color:#cbd5e1;color:#94a3b8;';
    }
    el.textContent = colLetter;
    el.dataset.id    = seat.ID_KURSI;
    el.dataset.no    = seat.NO_KURSI2;
    el.dataset.kelas = seat.KELAS_PENERBANAN || '';
    el.title         = `${seat.NO_KURSI2} — ${seat.KELAS_PENERBANAN || 'Belum ada kelas'}`;

    // Single click toggle select
    el.addEventListener('click', (e) => {
        if (isDragging) return; // handled by drag
        if (editorSelected.has(el.dataset.id)) {
            editorSelected.delete(el.dataset.id);
            el.classList.remove('editor-selected');
        } else {
            editorSelected.add(el.dataset.id);
            el.classList.add('editor-selected');
        }
        // If active class pill set, assign immediately on single click
        if (activePillClass) {
            assignSelectedSeats(activePillClass);
        } else {
            updateActionBar();
        }
    });

    return el;
}

// ── Drag / Block Selection ────────────────────────────────────────────────
let dragTargets = new Set();

function onDragStart(e) {
    const seat = e.target.closest('.seat');
    if (!seat || !seat.dataset.id) return;
    isDragging    = true;
    dragStartSeat = seat;
    dragTargets   = new Set([seat.dataset.id]);
    seat.classList.add('drag-hover');
    e.preventDefault();
}

function onDragOver(e) {
    if (!isDragging) return;
    const seat = e.target.closest('.seat');
    if (!seat || !seat.dataset.id) return;
    // Highlight only the hovered seat during drag
    document.querySelectorAll('.seat.drag-hover').forEach(s => s.classList.remove('drag-hover'));
    seat.classList.add('drag-hover');

    // Find all seats between dragStart and current
    dragTargets = getSeatsBetween(dragStartSeat, seat);
    // Visual feedback
    document.querySelectorAll('#editorAirplaneHull .seat').forEach(s => {
        if (dragTargets.has(s.dataset.id)) {
            s.classList.add('drag-hover');
        }
    });
}

function onDragEnd(e) {
    if (!isDragging) return;
    isDragging = false;

    document.querySelectorAll('.seat.drag-hover').forEach(s => s.classList.remove('drag-hover'));

    if (dragTargets.size > 1) {
        // Add dragged seats to selection
        dragTargets.forEach(id => {
            editorSelected.add(id);
            const el = document.querySelector(`#editorAirplaneHull .seat[data-id="${id}"]`);
            if (el) el.classList.add('editor-selected');
        });

        if (activePillClass) {
            assignSelectedSeats(activePillClass);
        } else {
            updateActionBar();
        }
    }
    dragTargets   = new Set();
    dragStartSeat = null;
}

function getSeatsBetween(startEl, endEl) {
    const allSeats = Array.from(document.querySelectorAll('#editorAirplaneHull .seat[data-id]'));
    const startIdx = allSeats.indexOf(startEl);
    const endIdx   = allSeats.indexOf(endEl);
    if (startIdx === -1 || endIdx === -1) return new Set([startEl.dataset.id, endEl.dataset.id]);
    const lo = Math.min(startIdx, endIdx);
    const hi = Math.max(startIdx, endIdx);
    return new Set(allSeats.slice(lo, hi + 1).map(s => s.dataset.id));
}

// ── Selection helpers ─────────────────────────────────────────────────────
function clearEditorSelection() {
    editorSelected.clear();
    document.querySelectorAll('#editorAirplaneHull .seat.editor-selected').forEach(s => s.classList.remove('editor-selected'));
    updateActionBar();
}

function updateActionBar() {
    const bar   = document.getElementById('assignActionBar');
    const count = document.getElementById('selectedCount');
    if (editorSelected.size > 0) {
        bar.style.display = 'flex';
        count.textContent = editorSelected.size + ' kursi dipilih';
    } else {
        bar.style.display = 'none';
    }
}

// ── Assign class to selected seats ───────────────────────────────────────
function assignSelectedSeats(className) {
    if (editorSelected.size === 0) return;

    const ids = Array.from(editorSelected).map(Number);

    fetch('<?= base_url('/kursi/bulk-assign-class') ?>', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json' },
        body: JSON.stringify({ seat_ids: ids, class_name: className }),
    })
    .then(r => r.json())
    .then(res => {
        if (res.success) {
            // Update local seat data + re-render
            const color = editorClasses[className] || '#94a3b8';
            const slug  = toSlug(className);
            editorSelected.forEach(id => {
                // Update editorSeats array
                const s = editorSeats.find(x => String(x.ID_KURSI) === String(id));
                if (s) s.KELAS_PENERBANAN = className;
                // Update DOM
                const el = document.querySelector(`#editorAirplaneHull .seat[data-id="${id}"]`);
                if (el) {
                    // Remove all ec-* classes
                    el.className = el.className.replace(/\bec-\S+/g, '').trim();
                    el.classList.add('seat', 'ec-' + slug);
                    el.removeAttribute('style');
                    el.dataset.kelas = className;
                    el.title = `${el.dataset.no} — ${className}`;
                    el.classList.remove('editor-selected');
                }
            });
            clearEditorSelection();
            showToast(res.message, 'success');
        } else {
            showToast(res.message || 'Gagal menyimpan.', 'error');
        }
    })
    .catch(() => showToast('Terjadi kesalahan jaringan.', 'error'));
}

// ── Toast ─────────────────────────────────────────────────────────────────
let toastTimer = null;
function showToast(msg, type = 'success') {
    const toast = document.getElementById('editorToast');
    const msgEl = document.getElementById('editorToastMsg');
    msgEl.textContent = msg;
    const icon = toast.querySelector('i');
    if (type === 'error') {
        icon.className = 'fas fa-exclamation-circle';
        icon.style.color = '#ef4444';
    } else {
        icon.className = 'fas fa-check-circle';
        icon.style.color = '#22c55e';
    }
    toast.style.display = 'block';
    if (toastTimer) clearTimeout(toastTimer);
    toastTimer = setTimeout(() => { toast.style.display = 'none'; }, 3000);
}
</script>

<?= $this->endSection() ?>
