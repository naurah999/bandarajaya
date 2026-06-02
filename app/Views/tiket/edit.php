<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Tiket</h2>
            <a href="<?= base_url('/tiket') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/tiket/update/' . $tiket['ID_TIKET']) ?>" method="post">
                <div class="form-group">
                    <label for="id_penumpang">Penumpang</label>
                    <select name="id_penumpang" id="id_penumpang" class="form-control" required>
                        <?php foreach ($penumpang as $p): ?>
                            <option value="<?= $p['ID_PENUMPANG'] ?>" <?= $p['ID_PENUMPANG'] == $tiket['ID_PENUMPANG'] ? 'selected' : '' ?>>
                                <?= esc($p['NAMA_PENUMPANG']) ?> (<?= esc($p['NO_IDENTITAS']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_penerbangan">Penerbangan</label>
                    <select name="id_penerbangan" id="id_penerbangan" class="form-control" required>
                        <?php foreach ($penerbangan as $p): ?>
                            <option value="<?= $p['ID_PENERBANGAN'] ?>" <?= $p['ID_PENERBANGAN'] == $tiket['ID_PENERBANGAN'] ? 'selected' : '' ?>>
                                [<?= esc($p['KODE_PENERBANGAN'] ?? '') ?>] <?= date('d M', strtotime($p['TANGGAL_BERANGKAT'])) ?> <?= date('H:i', strtotime($p['WAKTU_BERANGKAT'])) ?> | 
                                <?= esc($p['KOTA_ASAL']) ?> -> <?= esc($p['KOTA_TUJUAN']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas_tiket">Kelas Penerbangan</label>
                        <select name="kelas_tiket" id="kelas_tiket" class="form-control" required>
                            <option value="">-- Memuat kelas... --</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Tiket (Rp)</label>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?= esc($tiket['HARGA'] ?? 0) ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed; font-weight: 700;">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nomer_tiket">Nomor Tiket</label>
                    <input type="text" name="nomer_tiket" id="nomer_tiket" class="form-control" value="<?= esc($tiket['NOMER_TIKET']) ?>" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const flightSelect = document.getElementById('id_penerbangan');
    const classSelect  = document.getElementById('kelas_tiket');
    const priceInput   = document.getElementById('harga');
    const currentClass = '<?= esc($tiket['KELAS_TIKET'] ?? '') ?>';

    async function loadClasses(flightId, preselect) {
        classSelect.innerHTML = '<option value="">-- Memuat kelas... --</option>';
        classSelect.disabled = true;
        
        if (!flightId) {
            classSelect.innerHTML = '<option value="">-- Pilih Penerbangan Dulu --</option>';
            return;
        }

        try {
            const res = await fetch('<?= base_url('/tiket/get-classes/') ?>' + flightId);
            const classes = await res.json();

            classSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            if (classes.length > 0) {
                classes.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.NAMA_KELAS;
                    opt.dataset.harga = c.HARGA_KELAS;
                    opt.textContent = c.NAMA_KELAS + ' — Rp ' + parseFloat(c.HARGA_KELAS || 0).toLocaleString('id-ID');
                    if (preselect && c.NAMA_KELAS === preselect) opt.selected = true;
                    classSelect.appendChild(opt);
                });
                classSelect.disabled = false;
            } else {
                classSelect.innerHTML = '<option value="">(Belum ada kelas di catalog pesawat ini)</option>';
            }
        } catch (err) {
            console.error(err);
            classSelect.innerHTML = '<option value="">-- Gagal memuat kelas --</option>';
        }
    }

    // Load classes for current flight on page load
    if (flightSelect.value) {
        loadClasses(flightSelect.value, currentClass);
    }

    flightSelect.addEventListener('change', function() {
        priceInput.value = '';
        loadClasses(this.value, null);
    });

    classSelect.addEventListener('change', function() {
        const sel = this.options[this.selectedIndex];
        priceInput.value = (sel && sel.value) ? (sel.dataset.harga || 0) : '';
    });
});
</script>

<?= $this->endSection() ?>
