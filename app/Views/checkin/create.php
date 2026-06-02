<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<style>
    /* Seating Map Container */
    .seating-section {
        display: flex;
        flex-direction: column;
        align-items: center;
        overflow-x: auto;
        width: 100%;
    }

    .airplane-hull {
        background: white;
        border: 2px solid #cbd5e1;
        border-radius: 50px 50px 100px 100px;
        padding: 50px 20px;
        box-shadow: var(--shadow-lg);
        min-width: 320px;
        display: flex;
        flex-direction: column;
        align-items: center;
        position: relative;
        border-top: 10px solid #94a3b8;
    }

    .airplane-hull::before {
        content: "COCKPIT";
        font-size: 10px;
        font-weight: 800;
        letter-spacing: 2px;
        color: #94a3b8;
        margin-bottom: 30px;
        border: 1.5px solid #cbd5e1;
        padding: 2px 12px;
        border-radius: 20px;
    }

    /* Legend */
    .legend-container {
        display: flex;
        justify-content: center;
        gap: 16px;
        flex-wrap: wrap;
        background: white;
        padding: 10px 20px;
        border-radius: 100px;
        border: 1px solid var(--border-color);
        box-shadow: var(--shadow-sm);
    }

    .legend-item {
        display: flex;
        align-items: center;
        gap: 6px;
        font-weight: 500;
        font-size: 12px;
    }

    .legend-color {
        width: 14px;
        height: 14px;
        border-radius: 3px;
        border: 1.5px solid #cbd5e1;
    }

    /* Seat Grid Elements */
    .seating-row {
        display: flex;
        align-items: center;
        margin-bottom: 6px;
        gap: 6px;
    }

    .row-label {
        width: 20px;
        text-align: center;
        font-size: 11px;
        font-weight: 700;
        color: var(--text-muted);
    }

    .col-group {
        display: flex;
        gap: 6px;
    }

    .aisle-spacer {
        width: 24px;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 8px;
        font-weight: 700;
        color: #cbd5e1;
        text-transform: uppercase;
    }

    /* Seat Button */
    .seat {
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
        transition: all 0.2s ease;
        border: 1.5px solid;
    }

    .seat-spacer {
        width: 32px;
        height: 32px;
    }

    /* Seat Status Variations */
    /* Dynamic seat class colors are injected by JS */
    .seat-occupied {
        background: #f1f5f9;
        border-color: #cbd5e1;
        color: #94a3b8;
        cursor: not-allowed;
    }

    .seat.selected {
        background: var(--accent-primary) !important;
        border-color: var(--accent-primary) !important;
        color: white !important;
        box-shadow: 0 0 10px var(--accent-primary) !important;
        transform: scale(1.08);
    }
</style>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Proses Check-in Penumpang</h2>
            <a href="<?= base_url('/checkin') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/checkin/store') ?>" method="post">
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

                <div class="form-group" id="seatDropdownContainer">
                    <label for="id_kursi">Pilih Kursi Tersedia</label>
                    <select name="id_kursi" id="id_kursi" class="form-control" required disabled>
                        <option value="">-- Pilih Tiket Terlebih Dahulu --</option>
                    </select>
                    <small id="seatStatus" style="color: var(--text-muted); margin-top: 4px; display: block; font-weight: 500;">
                        * Kursi akan ditampilkan setelah tiket dipilih.
                    </small>
                </div>

                <!-- Visual Seating Map Container -->
                <div id="visualSeatMapSection" style="display:none; margin-top:24px; border-top: 1px solid var(--border-color); padding-top: 24px;">
                    <h3 style="margin-bottom:12px; font-weight:700; color:var(--text-primary); font-size:16px;">Pilih Kursi Secara Visual:</h3>
                    
                    <!-- Dynamic Legend (generated by JS) -->
                    <div class="legend-container" id="dynamicLegendContainer" style="margin-bottom:20px;"></div>

                    <!-- Dynamic seat class styles (injected by JS) -->
                    <style id="dynamicSeatStyles"></style>

                    <!-- Airplane View Section -->
                    <div class="seating-section" style="background:#f8fafc; border:1px solid var(--border-color); border-radius:24px; padding:30px 15px;">
                        <div class="airplane-hull" id="airplaneHullContainer">
                            <!-- Cockpit label & seating rows will be dynamically generated by JS -->
                        </div>
                    </div>
                </div>

                <div style="margin-top: 20px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>
                        <i class="fas fa-check-circle"></i> Selesaikan Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Helper: make a CSS-safe slug from class name
    function toClassSlug(name) {
        return name.toLowerCase().replace(/[^a-z0-9]+/g, '-').replace(/(^-|-$)/g, '');
    }

    document.getElementById('id_tiket').addEventListener('change', function() {
        const idTiket = this.value;
        const seatSelect = document.getElementById('id_kursi');
        const btnSubmit = document.getElementById('btnSubmit');
        const seatStatus = document.getElementById('seatStatus');
        const visualSection = document.getElementById('visualSeatMapSection');
        const airplaneHull = document.getElementById('airplaneHullContainer');

        if (!idTiket) {
            seatSelect.innerHTML = '<option value="">-- Pilih Tiket Terlebih Dahulu --</option>';
            seatSelect.disabled = true;
            btnSubmit.disabled = true;
            visualSection.style.display = 'none';
            return;
        }

        seatStatus.innerText = 'Memuat data kursi pesawat...';
        seatStatus.style.color = 'var(--text-muted)';
        seatSelect.disabled = true;
        visualSection.style.display = 'none';

        fetch('<?= base_url('/checkin/get-available-seats/') ?>' + idTiket)
            .then(response => response.json())
            .then(data => {
                const seats = data.seats || [];
                const occupiedIds = data.occupiedIds || [];
                const classColors = data.classColors || {};

                // --- BUILD DYNAMIC LEGEND ---
                const legendContainer = document.getElementById('dynamicLegendContainer');
                legendContainer.innerHTML = '';
                
                Object.entries(classColors).forEach(([name, color]) => {
                    legendContainer.innerHTML += `
                        <div class="legend-item">
                            <div class="legend-color" style="background:${color}22; border-color:${color};"></div>
                            <span>${name} (Tersedia)</span>
                        </div>`;
                });
                legendContainer.innerHTML += `
                    <div class="legend-item">
                        <div class="legend-color" style="background:#f1f5f9; border-color:#cbd5e1;"></div>
                        <span>Terisi (Check-in)</span>
                    </div>
                    <div class="legend-item">
                        <div class="legend-color" style="background:var(--accent-primary); border-color:var(--accent-primary);"></div>
                        <span>Pilihan Anda</span>
                    </div>`;

                // --- INJECT DYNAMIC CSS FOR SEAT CLASSES ---
                let dynamicCSS = '';
                Object.entries(classColors).forEach(([name, color]) => {
                    const slug = toClassSlug(name);
                    dynamicCSS += `
                        .seat-class-${slug}.seat-available {
                            background: ${color}15;
                            border-color: ${color};
                            color: ${color};
                        }
                        .seat-class-${slug}.seat-available:hover {
                            background: ${color};
                            color: white;
                            transform: translateY(-1px);
                            box-shadow: 0 4px 8px ${color}44;
                        }
                    `;
                });
                document.getElementById('dynamicSeatStyles').textContent = dynamicCSS;

                seatSelect.innerHTML = '<option value="">-- Pilih Kursi --</option>';
                
                if (seats.length === 0) {
                    seatSelect.innerHTML += '<option value="">Tidak ada kursi tersedia</option>';
                    seatStatus.innerText = 'Peringatan: Tidak ada kursi tersedia untuk penerbangan ini.';
                    seatStatus.style.color = 'var(--danger)';
                    btnSubmit.disabled = true;
                    visualSection.style.display = 'none';
                    return;
                }

                // Populate regular dropdown option as fallback
                seats.forEach(seat => {
                    const isOccupied = occupiedIds.includes(parseInt(seat.ID_KURSI));
                    if (!isOccupied) {
                        seatSelect.innerHTML += `<option value="${seat.ID_KURSI}">${seat.NO_KURSI2} (${seat.KELAS_PENERBANAN})</option>`;
                    }
                });

                // Dropdown handler in case they select from dropdown
                seatSelect.onchange = function() {
                    const val = this.value;
                    // Remove selected class from all visual seats
                    document.querySelectorAll('.seat.selected').forEach(el => el.classList.remove('selected'));
                    if (val) {
                        const targetSeat = document.querySelector(`.seat[data-id="${val}"]`);
                        if (targetSeat) {
                            targetSeat.classList.add('selected');
                        }
                        btnSubmit.disabled = false;
                        const selectedOption = this.options[this.selectedIndex];
                        seatStatus.innerHTML = `<span style="color:var(--success); font-weight:700;"><i class="fas fa-check"></i> Terpilih: Kursi ${selectedOption.text}</span>`;
                    } else {
                        btnSubmit.disabled = true;
                        seatStatus.innerText = '* Silahkan pilih kursi dengan mengklik kursi di bawah atau pilih lewat dropdown.';
                        seatStatus.style.color = 'var(--text-muted)';
                    }
                };

                // --- GENERATE VISUAL PLANE MAP ---
                airplaneHull.innerHTML = ''; // Clear previous hull

                // Parse seats to build grid dynamically
                const seatingGrid = {};
                const rows = [];
                const colLetters = [];

                seats.forEach(seat => {
                    const matches = seat.NO_KURSI2.match(/(\d+)([A-Z])/i);
                    if (matches) {
                        const r = parseInt(matches[1]);
                        const c = matches[2].toUpperCase();
                        if (!seatingGrid[r]) seatingGrid[r] = {};
                        seatingGrid[r][c] = seat;
                        if (!rows.includes(r)) rows.push(r);
                        if (!colLetters.includes(c)) colLetters.push(c);
                    }
                });

                rows.sort((a, b) => a - b);
                colLetters.sort();

                const totalCols = colLetters.length;
                let leftCols = ['A', 'B', 'C'];
                let rightCols = ['D', 'E', 'F'];

                if (totalCols > 0) {
                    const splitIndex = Math.ceil(totalCols / 2);
                    leftCols = colLetters.slice(0, splitIndex);
                    rightCols = colLetters.slice(splitIndex);
                }

                if (rows.length === 0) {
                    airplaneHull.innerHTML = '<p style="color:var(--text-muted); padding:20px;">Layout kursi tidak dapat dirender secara visual.</p>';
                } else {
                    rows.forEach(r => {
                        const rowDiv = document.createElement('div');
                        rowDiv.className = 'seating-row';

                        // Row label left
                        const labelLeft = document.createElement('div');
                        labelLeft.className = 'row-label';
                        labelLeft.innerText = r;
                        rowDiv.appendChild(labelLeft);

                        // Left group
                        const leftGroup = document.createElement('div');
                        leftGroup.className = 'col-group';
                        leftCols.forEach(c => {
                            const seat = seatingGrid[r] ? seatingGrid[r][c] : null;
                            const seatEl = createSeatElement(seat, c, occupiedIds, classColors);
                            leftGroup.appendChild(seatEl);
                        });
                        rowDiv.appendChild(leftGroup);

                        // Aisle
                        const aisle = document.createElement('div');
                        aisle.className = 'aisle-spacer';
                        aisle.innerText = 'Aisle';
                        rowDiv.appendChild(aisle);

                        // Right group
                        const rightGroup = document.createElement('div');
                        rightGroup.className = 'col-group';
                        rightCols.forEach(c => {
                            const seat = seatingGrid[r] ? seatingGrid[r][c] : null;
                            const seatEl = createSeatElement(seat, c, occupiedIds, classColors);
                            rightGroup.appendChild(seatEl);
                        });
                        rowDiv.appendChild(rightGroup);

                        // Row label right
                        const labelRight = document.createElement('div');
                        labelRight.className = 'row-label';
                        labelRight.innerText = r;
                        rowDiv.appendChild(labelRight);

                        airplaneHull.appendChild(rowDiv);
                    });
                }

                visualSection.style.display = 'block';
                seatSelect.disabled = false;
                seatStatus.innerText = '* Silahkan pilih kursi dengan mengklik kursi di bawah atau pilih lewat dropdown.';
                seatStatus.style.color = 'var(--text-muted)';
            })
            .catch(err => {
                console.error(err);
                seatStatus.innerText = 'Gagal memuat data kursi.';
                seatStatus.style.color = 'var(--danger)';
                visualSection.style.display = 'none';
            });
    });

    function createSeatElement(seat, colLetter, occupiedIds, classColors) {
        if (!seat) {
            const spacer = document.createElement('div');
            spacer.className = 'seat-spacer';
            return spacer;
        }

        const isOccupied = occupiedIds.includes(parseInt(seat.ID_KURSI));
        const seatEl = document.createElement('div');
        
        seatEl.innerText = colLetter;
        seatEl.setAttribute('data-id', seat.ID_KURSI);
        seatEl.setAttribute('data-no', seat.NO_KURSI2);

        if (isOccupied) {
            seatEl.className = 'seat seat-occupied';
            seatEl.title = `Kursi ${seat.NO_KURSI2} (Terisi)`;
        } else {
            const classSlug = toClassSlug(seat.KELAS_PENERBANAN);
            seatEl.className = `seat seat-available seat-class-${classSlug}`;
            seatEl.title = `Kursi ${seat.NO_KURSI2} (${seat.KELAS_PENERBANAN}) - Klik untuk memilih`;

            // Click listener
            seatEl.addEventListener('click', function() {
                // Remove selected class from all seats
                document.querySelectorAll('.seat.selected').forEach(el => el.classList.remove('selected'));
                
                // Add selected class to this seat
                this.classList.add('selected');

                // Select the option in dropdown
                const seatSelect = document.getElementById('id_kursi');
                seatSelect.value = seat.ID_KURSI;

                // Enable submit button
                document.getElementById('btnSubmit').disabled = false;
                
                const seatStatus = document.getElementById('seatStatus');
                seatStatus.innerHTML = `<span style="color:var(--success); font-weight:700;"><i class="fas fa-check"></i> Terpilih: Kursi ${seat.NO_KURSI2} (${seat.KELAS_PENERBANAN})</span>`;
            });
        }

        return seatEl;
    }
</script>

<?= $this->endSection() ?>
