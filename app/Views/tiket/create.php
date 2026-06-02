<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Buat Tiket Baru</h2>
            <a href="<?= base_url('/tiket') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/tiket/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_penumpang">Penumpang</label>
                    <select name="id_penumpang" id="id_penumpang" class="form-control" required>
                        <option value="">-- Pilih Penumpang --</option>
                        <?php foreach ($penumpang as $p): ?>
                            <option value="<?= $p['ID_PENUMPANG'] ?>">
                                <?= esc($p['NAMA_PENUMPANG']) ?> (<?= esc($p['NO_IDENTITAS']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_penerbangan">Penerbangan</label>
                    <select name="id_penerbangan" id="id_penerbangan" class="form-control" required>
                        <option value="">-- Pilih Penerbangan --</option>
                        <?php foreach ($penerbangan as $p): ?>
                            <option value="<?= $p['ID_PENERBANGAN'] ?>">
                                [<?= esc($p['KODE_PENERBANGAN'] ?? '') ?>] <?= date('d M', strtotime($p['TANGGAL_BERANGKAT'])) ?> <?= date('H:i', strtotime($p['WAKTU_BERANGKAT'])) ?> | 
                                <?= esc($p['KOTA_ASAL']) ?> -> <?= esc($p['KOTA_TUJUAN']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kelas_tiket">Kelas Penerbangan</label>
                        <select name="kelas_tiket" id="kelas_tiket" class="form-control" required disabled>
                            <option value="">-- Pilih Penerbangan Dulu --</option>
                        </select>
                        <small style="color: var(--text-muted); font-size: 11px;">Pilih penerbangan terlebih dahulu, kelas & harga otomatis muncul.</small>
                    </div>
                    <div class="form-group">
                        <label for="harga">Harga Tiket (Rp)</label>
                        <input type="number" name="harga" id="harga" class="form-control" readonly style="background-color: #f1f5f9; cursor: not-allowed; font-weight: 700;" placeholder="Otomatis dari kelas">
                    </div>
                </div>

                <div class="form-group">
                    <label for="nomer_tiket">Nomor Tiket</label>
                    <input type="text" name="nomer_tiket" id="nomer_tiket" class="form-control" placeholder="(Dihasilkan Otomatis)" readonly style="background-color: #f1f5f9; cursor: not-allowed;">
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Tiket
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto generate ticket number
    const dateStr = new Date().toISOString().slice(0, 10).replace(/-/g, '');
    const randomChars = Math.random().toString(36).substring(2, 6).toUpperCase();
    document.getElementById('nomer_tiket').value = 'TKT-' + dateStr + '-' + randomChars;

    const flightSelect = document.getElementById('id_penerbangan');
    const classSelect  = document.getElementById('kelas_tiket');
    const priceInput   = document.getElementById('harga');

    flightSelect.addEventListener('change', async function() {
        classSelect.innerHTML = '<option value="">-- Memuat kelas... --</option>';
        classSelect.disabled = true;
        priceInput.value = '';

        if (!this.value) {
            classSelect.innerHTML = '<option value="">-- Pilih Penerbangan Dulu --</option>';
            return;
        }

        try {
            const res = await fetch('<?= base_url('/tiket/get-classes/') ?>' + this.value);
            const classes = await res.json();

            classSelect.innerHTML = '<option value="">-- Pilih Kelas --</option>';
            if (classes.length > 0) {
                classes.forEach(c => {
                    const opt = document.createElement('option');
                    opt.value = c.NAMA_KELAS;
                    opt.dataset.harga = c.HARGA_KELAS;
                    opt.textContent = c.NAMA_KELAS + ' — Rp ' + parseFloat(c.HARGA_KELAS || 0).toLocaleString('id-ID');
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
    });

    classSelect.addEventListener('change', function() {
        const sel = this.options[this.selectedIndex];
        priceInput.value = (sel && sel.value) ? (sel.dataset.harga || 0) : '';
    });
});
</script>

<?= $this->endSection() ?>
