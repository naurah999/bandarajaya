<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Visual Seat Picker Styles */
    .checkin-layout {
        display: grid;
        grid-template-columns: 1fr;
        gap: 24px;
        max-width: 900px;
        margin: 0 auto;
    }

    .seat-picker-container {
        background: #f8fafc;
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 28px 20px;
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-x: auto;
        display: none;
    }

    .seat-picker-container.visible {
        display: flex;
        animation: fadeIn 0.5s ease;
    }

    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .plane-body {
        background: white;
        border: 2px solid #cbd5e1;
        border-radius: 40px 40px 80px 80px;
        padding: 50px 24px 40px;
        box-shadow: 0 8px 30px -10px rgba(0,0,0,0.1);
        min-width: 380px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        border-top: 8px solid #94a3b8;
    }

    .plane-body::before {
        content: "COCKPIT";
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #94a3b8;
        margin-bottom: 30px;
        border: 1.5px solid #cbd5e1;
        padding: 3px 14px;
        border-radius: 20px;
    }

    .seat-legend {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        margin-bottom: 24px;
        background: white;
        padding: 12px 22px;
        border-radius: 100px;
        border: 1px solid var(--border-color);
        box-shadow: 0 1px 3px rgba(0,0,0,0.05);
    }

    .seat-legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-size: 12px;
        font-weight: 500;
    }

    .seat-legend-color {
        width: 16px;
        height: 16px;
        border-radius: 4px;
        border: 1.5px solid #cbd5e1;
    }

    .seat-row {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
        gap: 6px;
    }

    .seat-row-label {
        width: 22px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
    }

    .seat-col-group {
        display: flex;
        gap: 6px;
    }

    .seat-aisle {
        width: 28px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        font-weight: 700;
        letter-spacing: 0.5px;
        color: #cbd5e1;
    }

    .seat-col-header {
        display: flex;
        align-items: center;
        margin-bottom: 8px;
        gap: 6px;
    }

    .seat-col-header span {
        width: 32px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: #94a3b8;
    }

    /* Seat Element */
    .s {
        width: 32px;
        height: 32px;
        border-radius: 6px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 10px;
        font-weight: 700;
        cursor: pointer;
        position: relative;
        transition: all 0.2s cubic-bezier(0.4, 0, 0.2, 1);
        border: 1.5px solid;
    }

    .s-eco {
        background: #f0f9ff;
        border-color: #3b82f6;
        color: #1d4ed8;
    }
    .s-eco:hover {
        background: #3b82f6;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(59, 130, 246, 0.3);
    }

    .s-biz {
        background: #fffbeb;
        border-color: #f59e0b;
        color: #b45309;
    }
    .s-biz:hover {
        background: #f59e0b;
        color: white;
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(245, 158, 11, 0.3);
    }

    .s-occ {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
    }
    .s-occ:hover {
        transform: none;
        box-shadow: none;
    }

    .s-selected {
        background: #059669 !important;
        border-color: #047857 !important;
        color: white !important;
        transform: scale(1.15) !important;
        box-shadow: 0 0 16px rgba(5, 150, 105, 0.5) !important;
        z-index: 10;
    }

    /* Tooltip */
    .s .s-tip {
        visibility: hidden;
        width: 160px;
        background: #0f172a;
        color: #fff;
        text-align: left;
        border-radius: 8px;
        padding: 10px;
        position: absolute;
        z-index: 100;
        bottom: 125%;
        left: 50%;
        transform: translateX(-50%);
        opacity: 0;
        transition: opacity 0.2s, visibility 0.2s;
        font-size: 11px;
        line-height: 1.6;
        box-shadow: 0 8px 15px rgba(0,0,0,0.3);
        pointer-events: none;
        border: 1px solid #334155;
    }
    .s .s-tip::after {
        content: "";
        position: absolute;
        top: 100%;
        left: 50%;
        margin-left: -5px;
        border-width: 5px;
        border-style: solid;
        border-color: #0f172a transparent transparent transparent;
    }
    .s:hover .s-tip {
        visibility: visible;
        opacity: 1;
    }

    /* Selected Seat Info Box */
    .selected-seat-info {
        margin-top: 16px;
        padding: 14px 20px;
        background: #ecfdf5;
        border: 1px solid #a7f3d0;
        border-radius: 12px;
        display: none;
        align-items: center;
        gap: 12px;
        animation: fadeIn 0.3s ease;
    }

    .selected-seat-info.visible {
        display: flex;
    }

    .selected-seat-info i {
        color: #059669;
        font-size: 20px;
    }

    .selected-seat-info .info-text {
        font-size: 14px;
        font-weight: 600;
        color: #065f46;
    }

    .selected-seat-info .info-text small {
        font-weight: 500;
        color: #047857;
        display: block;
        font-size: 12px;
    }

    /* Loading Spinner */
    .seat-loading {
        text-align: center;
        padding: 40px 20px;
        color: var(--text-muted);
    }
    .seat-loading i {
        font-size: 32px;
        margin-bottom: 12px;
        animation: spin 1s linear infinite;
    }
    @keyframes spin {
        from { transform: rotate(0deg); }
        to { transform: rotate(360deg); }
    }

    /* Empty placeholder */
    .seat-empty-state {
        text-align: center;
        padding: 40px 20px;
    }
    .seat-empty-state i {
        font-size: 40px;
        color: #cbd5e1;
        margin-bottom: 12px;
    }
    .seat-empty-state p {
        color: var(--text-muted);
        font-weight: 600;
    }
</style>

<div class="checkin-layout">
    <div class="card">
        <div class="card-header">
            <h2>Proses Check-in Penumpang</h2>
            <a href="<?= base_url('/checkin') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/checkin/store') ?>" method="post" id="checkinForm">
                <div class="form-group">
                    <label for="id_tiket">Pilih Tiket Penumpang</label>
                    <select name="id_tiket" id="id_tiket" class="form-control" required>
                        <option value="">-- Pilih Tiket --</option>
                        <?php foreach ($tikets as $t): ?>
                            <option value="<?= $t['ID_TIKET'] ?>">
                                <?= esc($t['NOMER_TIKET']) ?> - <?= esc($t['NAMA_PENUMPANG']) ?> (<?= esc($t['KOTA_ASAL']) ?> -> <?= esc($t['KOTA_TUJUAN']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <!-- Hidden input for selected seat -->
                <input type="hidden" name="id_kursi" id="id_kursi">

                <!-- Visual Seat Picker -->
                <div class="form-group">
                    <label><i class="fas fa-chair" style="margin-right:6px;"></i> Pilih Kursi</label>
                    
                    <div id="seatPickerPlaceholder" class="seat-empty-state" style="background:#f8fafc; border:1px solid var(--border-color); border-radius:16px; padding:40px 20px;">
                        <i class="fas fa-ticket-alt"></i>
                        <p>Pilih tiket penumpang terlebih dahulu untuk menampilkan peta kursi.</p>
                    </div>

                    <div id="seatLoading" class="seat-loading" style="display:none; background:#f8fafc; border:1px solid var(--border-color); border-radius:16px;">
                        <i class="fas fa-spinner"></i>
                        <p style="font-weight:600;">Memuat peta kursi pesawat...</p>
                    </div>

                    <div id="seatPickerContainer" class="seat-picker-container">
                        <div class="seat-legend">
                            <div class="seat-legend-item">
                                <div class="seat-legend-color" style="background:#f0f9ff; border-color:#3b82f6;"></div>
                                <span>Ekonomi</span>
                            </div>
                            <div class="seat-legend-item">
                                <div class="seat-legend-color" style="background:#fffbeb; border-color:#f59e0b;"></div>
                                <span>Bisnis</span>
                            </div>
                            <div class="seat-legend-item">
                                <div class="seat-legend-color" style="background:#f1f5f9; border-color:#cbd5e1;"></div>
                                <span>Terisi</span>
                            </div>
                            <div class="seat-legend-item">
                                <div class="seat-legend-color" style="background:#059669; border-color:#047857;"></div>
                                <span>Dipilih</span>
                            </div>
                        </div>

                        <div class="plane-body" id="planeBody">
                            <!-- Seats rendered via JS -->
                        </div>

                        <div id="selectedSeatInfo" class="selected-seat-info">
                            <i class="fas fa-check-circle"></i>
                            <div class="info-text">
                                Kursi <strong id="selectedSeatLabel">-</strong> dipilih
                                <small id="selectedSeatClass">-</small>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>
                        <i class="fas fa-check-circle"></i> Selesaikan Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    let selectedSeatId = null;

    document.getElementById('id_tiket').addEventListener('change', function() {
        const idTiket = this.value;
        const placeholder = document.getElementById('seatPickerPlaceholder');
        const loading = document.getElementById('seatLoading');
        const container = document.getElementById('seatPickerContainer');
        const btnSubmit = document.getElementById('btnSubmit');

        // Reset selection
        selectedSeatId = null;
        document.getElementById('id_kursi').value = '';
        btnSubmit.disabled = true;
        document.getElementById('selectedSeatInfo').classList.remove('visible');

        if (!idTiket) {
            placeholder.style.display = 'block';
            loading.style.display = 'none';
            container.classList.remove('visible');
            return;
        }

        // Show loading
        placeholder.style.display = 'none';
        loading.style.display = 'block';
        container.classList.remove('visible');

        fetch('<?= base_url('/checkin/get-all-seats/') ?>' + idTiket)
            .then(r => r.json())
            .then(seats => {
                loading.style.display = 'none';

                if (seats.length === 0) {
                    placeholder.style.display = 'block';
                    placeholder.querySelector('p').textContent = 'Tidak ada kursi tersedia untuk penerbangan ini.';
                    return;
                }

                renderSeatMap(seats);
                container.classList.add('visible');
            })
            .catch(err => {
                console.error(err);
                loading.style.display = 'none';
                placeholder.style.display = 'block';
                placeholder.querySelector('p').textContent = 'Gagal memuat peta kursi.';
            });
    });

    function renderSeatMap(seats) {
        const planeBody = document.getElementById('planeBody');
        planeBody.innerHTML = '';

        // Group seats by row
        const grid = {};

        seats.forEach(seat => {
            const match = seat.NO_KURSI2.match(/^(\d+)([A-F])$/i);
            if (match) {
                const row = parseInt(match[1]);
                const col = match[2].toUpperCase();
                if (!grid[row]) grid[row] = {};
                grid[row][col] = seat;
            }
        });

        const rowNumbers = Object.keys(grid).map(Number).sort((a,b) => a - b);

        // Column header
        const headerDiv = document.createElement('div');
        headerDiv.className = 'seat-col-header';
        const headerLabels = ['', 'A', 'B', 'C', '', 'D', 'E', 'F', ''];
        headerLabels.forEach((lbl, i) => {
            const sp = document.createElement('span');
            sp.textContent = lbl;
            if (i === 0 || i === 8) sp.style.width = '22px';
            if (i === 4) sp.style.width = '28px';
            headerDiv.appendChild(sp);
        });
        planeBody.appendChild(headerDiv);

        // Render each row
        rowNumbers.forEach(r => {
            const rowDiv = document.createElement('div');
            rowDiv.className = 'seat-row';

            // Left row label
            const leftLabel = document.createElement('div');
            leftLabel.className = 'seat-row-label';
            leftLabel.textContent = r;
            rowDiv.appendChild(leftLabel);

            // Left group (A, B, C)
            const leftGroup = document.createElement('div');
            leftGroup.className = 'seat-col-group';
            ['A','B','C'].forEach(c => {
                leftGroup.appendChild(createSeatElement(grid[r], c));
            });
            rowDiv.appendChild(leftGroup);

            // Aisle
            const aisle = document.createElement('div');
            aisle.className = 'seat-aisle';
            rowDiv.appendChild(aisle);

            // Right group (D, E, F)
            const rightGroup = document.createElement('div');
            rightGroup.className = 'seat-col-group';
            ['D','E','F'].forEach(c => {
                rightGroup.appendChild(createSeatElement(grid[r], c));
            });
            rowDiv.appendChild(rightGroup);

            // Right row label
            const rightLabel = document.createElement('div');
            rightLabel.className = 'seat-row-label';
            rightLabel.textContent = r;
            rowDiv.appendChild(rightLabel);

            planeBody.appendChild(rowDiv);
        });
    }

    function createSeatElement(rowData, col) {
        const seat = rowData ? rowData[col] : null;

        if (!seat) {
            const spacer = document.createElement('div');
            spacer.style.width = '32px';
            spacer.style.height = '32px';
            return spacer;
        }

        const div = document.createElement('div');
        const isOccupied = seat.occupied;
        const isBusiness = seat.KELAS_PENERBANAN === 'Bisnis';

        if (isOccupied) {
            div.className = 's s-occ';
        } else if (isBusiness) {
            div.className = 's s-biz';
        } else {
            div.className = 's s-eco';
        }

        div.textContent = col;
        div.dataset.id = seat.ID_KURSI;
        div.dataset.no = seat.NO_KURSI2;
        div.dataset.class = seat.KELAS_PENERBANAN;
        div.dataset.occupied = isOccupied ? 'true' : 'false';

        // Tooltip
        const tip = document.createElement('div');
        tip.className = 's-tip';
        tip.innerHTML = `<strong style="color:#60a5fa;">${seat.NO_KURSI2}</strong>
            <span style="float:right; font-size:9px; padding:2px 6px; border-radius:4px; background:${isBusiness ? '#fef3c7' : '#dbeafe'}; color:${isBusiness ? '#92400e' : '#1e40af'}; font-weight:700;">${seat.KELAS_PENERBANAN}</span>
            <div style="margin-top:6px; border-top:1px solid #334155; padding-top:5px;">
                ${isOccupied ? '<span style="color:#ef4444;font-weight:700;">Terisi</span>' : '<span style="color:#22c55e;font-weight:700;">Tersedia</span>'}
            </div>`;
        div.appendChild(tip);

        if (!isOccupied) {
            div.addEventListener('click', function() {
                selectSeat(this);
            });
        }

        return div;
    }

    function selectSeat(element) {
        // Remove previous selection
        document.querySelectorAll('.s-selected').forEach(el => el.classList.remove('s-selected'));

        // Select this seat
        element.classList.add('s-selected');
        selectedSeatId = element.dataset.id;

        // Update hidden input
        document.getElementById('id_kursi').value = selectedSeatId;

        // Update info box
        document.getElementById('selectedSeatLabel').textContent = element.dataset.no;
        document.getElementById('selectedSeatClass').textContent = 'Kelas: ' + element.dataset.class;
        document.getElementById('selectedSeatInfo').classList.add('visible');

        // Enable submit
        document.getElementById('btnSubmit').disabled = false;
    }

    // Form validation
    document.getElementById('checkinForm').addEventListener('submit', function(e) {
        if (!selectedSeatId) {
            e.preventDefault();
            alert('Silahkan pilih kursi terlebih dahulu.');
        }
    });
</script>

<?= $this->endSection() ?>
