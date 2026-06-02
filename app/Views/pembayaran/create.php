<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Catat Transaksi Pembayaran</h2>
            <a href="<?= base_url('/pembayaran') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/pembayaran/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_metode">Metode Pembayaran</label>
                    <select name="id_metode" id="id_metode" class="form-control" required>
                        <option value="">-- Pilih Metode --</option>
                        <?php foreach ($metode as $m): ?>
                            <option value="<?= $m['ID_METODE'] ?>"><?= esc($m['TIPE_PEMBAYARAN']) ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 8px;">
                        <label style="margin-bottom: 0;">Pilih Tiket yang Akan Dibayar</label>
                        <?php if (!empty($tikets)): ?>
                            <div style="display: flex; align-items: center; gap: 6px;">
                                <input type="checkbox" id="selectAllTiket" onchange="toggleAllTikets(this)">
                                <label for="selectAllTiket" style="margin-bottom: 0; font-size: 13px; cursor: pointer; color: var(--accent-primary); font-weight: 600;">Pilih Semua</label>
                            </div>
                        <?php endif; ?>
                    </div>
                    <div style="max-height: 200px; overflow-y: auto; border: 1px solid var(--border-color); padding: 10px; border-radius: 8px;">
                        <?php if (empty($tikets)): ?>
                            <p style="color: var(--text-muted); font-style: italic;">Tidak ada tiket yang perlu dibayar.</p>
                        <?php else: ?>
                            <?php foreach ($tikets as $t): ?>
                                <div style="margin-bottom: 8px; display: flex; align-items: center; gap: 10px;">
                                    <input type="checkbox" name="id_tiket[]" value="<?= $t['ID_TIKET'] ?>" data-harga="<?= $t['HARGA'] ?>" class="tiket-checkbox">
                                    <label style="margin-bottom: 0;">
                                        <strong><?= esc($t['NOMER_TIKET']) ?></strong> - <?= esc($t['NAMA_PENUMPANG']) ?> 
                                        <span style="color: var(--success); font-weight: 700;">(Rp <?= number_format($t['HARGA'], 0, ',', '.') ?>)</span>
                                    </label>
                                </div>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="jumlah_tiket">Jumlah Tiket</label>
                        <input type="number" name="jumlah_tiket" id="jumlah_tiket" class="form-control" readonly>
                    </div>
                    <div class="form-group">
                        <label for="total_harga">Total Harga (Rp)</label>
                        <input type="number" name="total_harga" id="total_harga" class="form-control" readonly>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" <?= empty($tikets) ? 'disabled' : '' ?>>
                        <i class="fas fa-save"></i> Simpan Transaksi
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    const checkboxes = document.querySelectorAll('.tiket-checkbox');
    const inputJumlah = document.getElementById('jumlah_tiket');
    const inputTotal = document.getElementById('total_harga');

    function calculate() {
        let count = 0;
        let total = 0;
        checkboxes.forEach(cb => {
            if (cb.checked) {
                count++;
                total += parseFloat(cb.getAttribute('data-harga'));
            }
        });
        inputJumlah.value = count;
        inputTotal.value = total;
        
        const selectAllCheckbox = document.getElementById('selectAllTiket');
        if (selectAllCheckbox) {
            selectAllCheckbox.checked = count === checkboxes.length && checkboxes.length > 0;
        }
    }

    checkboxes.forEach(cb => {
        cb.addEventListener('change', calculate);
    });

    function toggleAllTikets(source) {
        checkboxes.forEach(cb => {
            cb.checked = source.checked;
        });
        calculate();
    }
</script>

<?= $this->endSection() ?>
