<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 1000px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Catalog Pesawat</h2>
            <a href="<?= base_url('/catalog-pesawat') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/catalog-pesawat/update/' . $catalog['ID_CATALOG']) ?>" method="post" id="catalogForm">
                
                <h3 style="font-size: 15px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color);">Informasi Utama</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipe_pesawat">Tipe Pesawat <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="tipe_pesawat" id="tipe_pesawat" class="form-control" value="<?= esc($catalog['TIPE_PESAWAT']) ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_tipe">Kode Tipe <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="kode_tipe" id="kode_tipe" class="form-control" value="<?= esc($catalog['KODE_TIPE']) ?>" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kategori">Kategori <span style="color:var(--danger)">*</span></label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="Narrow-body" <?= $catalog['KATEGORI'] == 'Narrow-body' ? 'selected' : '' ?>>Narrow-body (Lorong Tunggal)</option>
                            <option value="Wide-body" <?= $catalog['KATEGORI'] == 'Wide-body' ? 'selected' : '' ?>>Wide-body (Lorong Ganda)</option>
                            <option value="Turboprop" <?= $catalog['KATEGORI'] == 'Turboprop' ? 'selected' : '' ?>>Turboprop (Baling-baling)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" value="<?= esc($catalog['DESKRIPSI']) ?>">
                    </div>
                </div>

                <h3 style="font-size: 15px; margin-top: 24px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                    Konfigurasi Kelas & Kursi
                    <button type="button" class="btn btn-success btn-sm" id="btnTambahKelas">
                        <i class="fas fa-plus"></i> Tambah Kelas
                    </button>
                </h3>
                
                <div id="kelasContainer">
                    <?php if(empty($catalog['kelas'])): ?>
                        <!-- Jika tidak ada kelas sebelumnya -->
                        <div class="kelas-row" style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color); margin-bottom: 16px;">
                            <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                <strong style="font-size: 13px; color: var(--text-primary);">Kelas #1</strong>
                                <button type="button" class="btn btn-danger btn-sm btn-hapus-kelas" style="padding: 4px 8px; display: none;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            <div style="display: grid; grid-template-columns: 2fr 0.8fr 1fr 1fr 1fr 1.2fr; gap: 12px;">
                                <div>
                                    <label style="font-size: 11px;">Nama Kelas</label>
                                    <select name="nama_kelas[]" class="form-control select-nama-kelas" required onchange="handleClassChange(this)">
                                        <option value="Ekonomi">Ekonomi</option>
                                        <option value="Bisnis">Bisnis</option>
                                        <option value="First Class">First Class</option>
                                        <option value="Premium Economy">Premium Economy</option>
                                        <option value="NEW">[Tambah Kelas Baru...]</option>
                                    </select>
                                    <input type="text" name="custom_nama_kelas[]" class="form-control input-custom-kelas" style="display: none; margin-top: 4px;" placeholder="Nama kelas baru...">
                                </div>
                                <div>
                                    <label style="font-size: 11px;">Warna</label>
                                    <input type="color" name="warna_kelas[]" class="form-control input-warna-kelas" style="padding: 2px; height: 38px; cursor: pointer;" value="#3b82f6" title="Pilih warna untuk kelas ini">
                                </div>
                                <div>
                                    <label style="font-size: 11px;">Layout</label>
                                    <select name="layout_kursi[]" class="form-control" required>
                                        <option value="3-3">3-3</option>
                                        <option value="2-2">2-2</option>
                                        <option value="2-4-2">2-4-2</option>
                                        <option value="2-2-2">2-2-2</option>
                                        <option value="1-2-1">1-2-1</option>
                                    </select>
                                </div>
                                <div>
                                    <label style="font-size: 11px;">Row Mulai</label>
                                    <input type="number" name="baris_mulai[]" class="form-control" min="1" required>
                                </div>
                                <div>
                                    <label style="font-size: 11px;">Row Akhir</label>
                                    <input type="number" name="baris_akhir[]" class="form-control" min="1" required>
                                </div>
                                <div>
                                    <label style="font-size: 11px;">Huruf Kursi</label>
                                    <input type="text" name="huruf_kursi[]" class="form-control" required>
                                </div>
                            </div>
                        </div>
                    <?php else: ?>
                        <!-- Render existing classes -->
                        <?php foreach($catalog['kelas'] as $index => $kelas): ?>
                            <?php 
                            $standardClasses = ['Ekonomi', 'Bisnis', 'First Class', 'Premium Economy'];
                            $isCustom = !in_array($kelas['NAMA_KELAS'], $standardClasses);
                            ?>
                            <div class="kelas-row" style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color); margin-bottom: 16px;">
                                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                                    <strong style="font-size: 13px; color: var(--text-primary);">Kelas #<?= $index + 1 ?></strong>
                                    <button type="button" class="btn btn-danger btn-sm btn-hapus-kelas" style="padding: 4px 8px; <?= count($catalog['kelas']) <= 1 ? 'display: none;' : '' ?>">
                                        <i class="fas fa-times"></i> Hapus
                                    </button>
                                </div>
                                <div style="display: grid; grid-template-columns: 2fr 0.8fr 1fr 1fr 1fr 1.2fr; gap: 12px;">
                                    <div>
                                        <label style="font-size: 11px;">Nama Kelas</label>
                                        <select name="nama_kelas[]" class="form-control select-nama-kelas" required onchange="handleClassChange(this)">
                                            <option value="Ekonomi" <?= $kelas['NAMA_KELAS'] == 'Ekonomi' ? 'selected' : '' ?>>Ekonomi</option>
                                            <option value="Bisnis" <?= $kelas['NAMA_KELAS'] == 'Bisnis' ? 'selected' : '' ?>>Bisnis</option>
                                            <option value="First Class" <?= $kelas['NAMA_KELAS'] == 'First Class' ? 'selected' : '' ?>>First Class</option>
                                            <option value="Premium Economy" <?= $kelas['NAMA_KELAS'] == 'Premium Economy' ? 'selected' : '' ?>>Premium Economy</option>
                                            <option value="NEW" <?= $isCustom ? 'selected' : '' ?>>[Tambah Kelas Baru...]</option>
                                        </select>
                                        <input type="text" name="custom_nama_kelas[]" class="form-control input-custom-kelas" style="<?= $isCustom ? 'display: block;' : 'display: none;' ?> margin-top: 4px;" value="<?= $isCustom ? esc($kelas['NAMA_KELAS']) : '' ?>" placeholder="Nama kelas baru...">
                                    </div>
                                    <div>
                                        <label style="font-size: 11px;">Warna</label>
                                        <input type="color" name="warna_kelas[]" class="form-control input-warna-kelas" style="padding: 2px; height: 38px; cursor: pointer;" value="<?= esc($kelas['WARNA_KELAS'] ?? '#3b82f6') ?>" title="Pilih warna untuk kelas ini">
                                    </div>
                                    <div>
                                        <label style="font-size: 11px;">Layout</label>
                                        <select name="layout_kursi[]" class="form-control" required>
                                            <option value="3-3" <?= $kelas['LAYOUT_KURSI'] == '3-3' ? 'selected' : '' ?>>3-3</option>
                                            <option value="2-2" <?= $kelas['LAYOUT_KURSI'] == '2-2' ? 'selected' : '' ?>>2-2</option>
                                            <option value="2-4-2" <?= $kelas['LAYOUT_KURSI'] == '2-4-2' ? 'selected' : '' ?>>2-4-2</option>
                                            <option value="2-2-2" <?= $kelas['LAYOUT_KURSI'] == '2-2-2' ? 'selected' : '' ?>>2-2-2</option>
                                            <option value="1-2-1" <?= $kelas['LAYOUT_KURSI'] == '1-2-1' ? 'selected' : '' ?>>1-2-1</option>
                                        </select>
                                    </div>
                                    <div>
                                        <label style="font-size: 11px;">Row Mulai</label>
                                        <input type="number" name="baris_mulai[]" class="form-control" value="<?= esc($kelas['BARIS_MULAI']) ?>" min="1" required>
                                    </div>
                                    <div>
                                        <label style="font-size: 11px;">Row Akhir</label>
                                        <input type="number" name="baris_akhir[]" class="form-control" value="<?= esc($kelas['BARIS_AKHIR']) ?>" min="1" required>
                                    </div>
                                    <div>
                                        <label style="font-size: 11px;">Huruf Kursi</label>
                                        <input type="text" name="huruf_kursi[]" class="form-control" value="<?= esc($kelas['HURUF_KURSI']) ?>" required>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Catalog
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
function handleClassChange(select) {
    const row = select.closest('.kelas-row');
    const customInput = row.querySelector('.input-custom-kelas');
    const colorInput = row.querySelector('.input-warna-kelas');
    
    if (select.value === 'NEW') {
        customInput.style.display = 'block';
        customInput.required = true;
        customInput.focus();
    } else {
        customInput.style.display = 'none';
        customInput.required = false;
        customInput.value = '';
        
        // Auto set default colors
        if (select.value === 'Ekonomi') {
            colorInput.value = '#3b82f6';
        } else if (select.value === 'Bisnis') {
            colorInput.value = '#f59e0b';
        } else if (select.value === 'First Class') {
            colorInput.value = '#8b5cf6';
        } else if (select.value === 'Premium Economy') {
            colorInput.value = '#10b981';
        }
    }
}

document.addEventListener('DOMContentLoaded', function() {
    const container = document.getElementById('kelasContainer');
    const btnTambah = document.getElementById('btnTambahKelas');

    btnTambah.addEventListener('click', function() {
        const rows = document.querySelectorAll('.kelas-row');
        const count = rows.length + 1;
        const template = `
            <div class="kelas-row" style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color); margin-bottom: 16px; display: none;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <strong style="font-size: 13px; color: var(--text-primary);">Kelas #${count}</strong>
                    <button type="button" class="btn btn-danger btn-sm btn-hapus-kelas" style="padding: 4px 8px;">
                        <i class="fas fa-times"></i> Hapus
                    </button>
                </div>
                <div style="display: grid; grid-template-columns: 2fr 0.8fr 1fr 1fr 1fr 1.2fr; gap: 12px;">
                    <div>
                        <label style="font-size: 11px;">Nama Kelas</label>
                        <select name="nama_kelas[]" class="form-control select-nama-kelas" required onchange="handleClassChange(this)">
                            <option value="Ekonomi">Ekonomi</option>
                            <option value="Bisnis">Bisnis</option>
                            <option value="First Class">First Class</option>
                            <option value="Premium Economy">Premium Economy</option>
                            <option value="NEW">[Tambah Kelas Baru...]</option>
                        </select>
                        <input type="text" name="custom_nama_kelas[]" class="form-control input-custom-kelas" style="display: none; margin-top: 4px;" placeholder="Nama kelas baru...">
                    </div>
                    <div>
                        <label style="font-size: 11px;">Warna</label>
                        <input type="color" name="warna_kelas[]" class="form-control input-warna-kelas" style="padding: 2px; height: 38px; cursor: pointer;" value="#3b82f6" title="Pilih warna untuk kelas ini">
                    </div>
                    <div>
                        <label style="font-size: 11px;">Layout</label>
                        <select name="layout_kursi[]" class="form-control" required>
                            <option value="3-3">3-3</option>
                            <option value="2-2">2-2</option>
                            <option value="2-4-2">2-4-2</option>
                            <option value="2-2-2">2-2-2</option>
                            <option value="1-2-1">1-2-1</option>
                        </select>
                    </div>
                    <div>
                        <label style="font-size: 11px;">Row Mulai</label>
                        <input type="number" name="baris_mulai[]" class="form-control" min="1" required>
                    </div>
                    <div>
                        <label style="font-size: 11px;">Row Akhir</label>
                        <input type="number" name="baris_akhir[]" class="form-control" min="1" required>
                    </div>
                    <div>
                        <label style="font-size: 11px;">Huruf Kursi</label>
                        <input type="text" name="huruf_kursi[]" class="form-control" required>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', template);
        const newRow = container.lastElementChild;
        newRow.style.display = 'block';
        newRow.style.opacity = '0';
        setTimeout(() => { newRow.style.transition = 'opacity 0.3s ease'; newRow.style.opacity = '1'; }, 10);
        updateDeleteButtons();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-hapus-kelas')) {
            const row = e.target.closest('.kelas-row');
            row.style.opacity = '0';
            setTimeout(() => { row.remove(); updateDeleteButtons(); updateLabels(); }, 300);
        }
    });

    // Auto update huruf_kursi based on layout selection
    container.addEventListener('change', function(e) {
        if (e.target.name === 'layout_kursi[]') {
            const row = e.target.closest('.kelas-row');
            const hurufInput = row.querySelector('input[name="huruf_kursi[]"]');
            const layout = e.target.value;
            
            if (layout === '3-3' || layout === '2-2-2') hurufInput.value = 'ABCDEF';
            else if (layout === '2-2') hurufInput.value = 'ABCD';
            else if (layout === '2-4-2') hurufInput.value = 'ABCDEFGH';
            else if (layout === '1-2-1') hurufInput.value = 'ADGK';
        }
    });

    function updateDeleteButtons() {
        const rows = document.querySelectorAll('.kelas-row');
        const btns = document.querySelectorAll('.btn-hapus-kelas');
        if (rows.length > 1) { btns.forEach(btn => btn.style.display = 'inline-block'); } 
        else { btns.forEach(btn => btn.style.display = 'none'); }
    }

    function updateLabels() {
        const rows = document.querySelectorAll('.kelas-row');
        rows.forEach((row, index) => { row.querySelector('strong').textContent = `Kelas #${index + 1}`; });
    }
});
</script>

<?= $this->endSection() ?>
