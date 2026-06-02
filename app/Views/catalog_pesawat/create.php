<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 1000px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Tambah Catalog Pesawat Baru</h2>
            <a href="<?= base_url('/catalog-pesawat') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/catalog-pesawat/store') ?>" method="post" id="catalogForm">
                
                <h3 style="font-size: 15px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color);">Informasi Utama</h3>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="tipe_pesawat">Tipe Pesawat <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="tipe_pesawat" id="tipe_pesawat" class="form-control" placeholder="Contoh: Boeing 737-800" required>
                    </div>
                    <div class="form-group">
                        <label for="kode_tipe">Kode Tipe <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="kode_tipe" id="kode_tipe" class="form-control" placeholder="Contoh: B738" required>
                    </div>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="kategori">Kategori <span style="color:var(--danger)">*</span></label>
                        <select name="kategori" id="kategori" class="form-control" required>
                            <option value="Narrow-body">Narrow-body (Lorong Tunggal)</option>
                            <option value="Wide-body">Wide-body (Lorong Ganda)</option>
                            <option value="Turboprop">Turboprop (Baling-baling)</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="deskripsi">Deskripsi</label>
                        <input type="text" name="deskripsi" id="deskripsi" class="form-control" placeholder="Catatan opsional">
                    </div>
                </div>

                <h3 style="font-size: 15px; margin-top: 24px; margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                    Konfigurasi Kelas & Kursi
                    <button type="button" class="btn btn-success btn-sm" id="btnTambahKelas">
                        <i class="fas fa-plus"></i> Tambah Kelas
                    </button>
                </h3>
                
                <div id="kelasContainer">
                    <!-- Template Baris Kelas -->
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
                                <input type="number" name="baris_mulai[]" class="form-control" value="1" min="1" required>
                            </div>
                            <div>
                                <label style="font-size: 11px;">Row Akhir</label>
                                <input type="number" name="baris_akhir[]" class="form-control" value="30" min="1" required>
                            </div>
                            <div>
                                <label style="font-size: 11px;">Huruf Kursi</label>
                                <input type="text" name="huruf_kursi[]" class="form-control" value="ABCDEF" required>
                            </div>
                        </div>
                    </div>
                </div>

                <div style="background: var(--info-bg); border: 1px solid rgba(6,182,212,0.2); border-radius: 12px; padding: 16px; margin-bottom: 24px;">
                    <h4 style="font-size: 13px; color: var(--info); margin-bottom: 8px;"><i class="fas fa-info-circle"></i> Info Panduan Layout</h4>
                    <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">- <strong>3-3</strong> (Narrow-body): Gunakan huruf <strong>ABCDEF</strong></p>
                    <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">- <strong>2-2</strong> (Business/ATR): Gunakan huruf <strong>ABCD</strong></p>
                    <p style="font-size: 12px; color: var(--text-secondary); margin-bottom: 4px;">- <strong>2-4-2</strong> (Wide-body): Gunakan huruf <strong>ABCDEFGH</strong></p>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Simpan Catalog
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
    let kelasCount = 1;

    btnTambah.addEventListener('click', function() {
        kelasCount++;
        const template = `
            <div class="kelas-row" style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color); margin-bottom: 16px; display: none;">
                <div style="display: flex; justify-content: space-between; margin-bottom: 12px;">
                    <strong style="font-size: 13px; color: var(--text-primary);">Kelas #${kelasCount}</strong>
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
                        <input type="number" name="baris_mulai[]" class="form-control" value="" min="1" required>
                    </div>
                    <div>
                        <label style="font-size: 11px;">Row Akhir</label>
                        <input type="number" name="baris_akhir[]" class="form-control" value="" min="1" required>
                    </div>
                    <div>
                        <label style="font-size: 11px;">Huruf Kursi</label>
                        <input type="text" name="huruf_kursi[]" class="form-control" value="" required>
                    </div>
                </div>
            </div>
        `;
        
        container.insertAdjacentHTML('beforeend', template);
        
        // Animasi fade in
        const newRow = container.lastElementChild;
        newRow.style.display = 'block';
        newRow.style.opacity = '0';
        setTimeout(() => {
            newRow.style.transition = 'opacity 0.3s ease';
            newRow.style.opacity = '1';
        }, 10);

        updateDeleteButtons();
    });

    container.addEventListener('click', function(e) {
        if (e.target.closest('.btn-hapus-kelas')) {
            const row = e.target.closest('.kelas-row');
            row.style.opacity = '0';
            setTimeout(() => {
                row.remove();
                updateDeleteButtons();
                updateLabels();
            }, 300);
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
        if (rows.length > 1) {
            btns.forEach(btn => btn.style.display = 'inline-block');
        } else {
            btns.forEach(btn => btn.style.display = 'none');
        }
    }

    function updateLabels() {
        const rows = document.querySelectorAll('.kelas-row');
        rows.forEach((row, index) => {
            row.querySelector('strong').textContent = `Kelas #${index + 1}`;
        });
        kelasCount = rows.length;
    }
});
</script>

<?= $this->endSection() ?>
