<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 600px; margin: 40px auto; text-align: center;">
    <div class="empty-state" style="padding-bottom: 20px;">
        <i class="fas fa-plane-departure" style="font-size: 64px; color: var(--accent-primary); opacity: 1; margin-bottom: 24px;"></i>
        <h2 style="font-size: 24px; font-weight: 800; color: var(--text-primary); margin-bottom: 12px;">Selamat Datang di Sistem Manajemen Maskapai</h2>
        <p style="font-size: 15px; color: var(--text-secondary); line-height: 1.6;">
            Sistem ini dikhususkan untuk mengelola operasional satu maskapai. <br>
            Silakan lengkapi profil maskapai Anda untuk memulai.
        </p>
    </div>

    <div class="card" style="text-align: left; box-shadow: var(--shadow-md);">
        <div class="card-header" style="background: rgba(99, 102, 241, 0.05);">
            <h3 style="font-size: 16px; font-weight: 700; color: var(--accent-primary);">
                <i class="fas fa-id-card"></i> Setup Profil Maskapai
            </h3>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/maskapai/setup') ?>" method="post">
                <div class="form-group">
                    <label for="nama_maskapai">Nama Maskapai <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="nama_maskapai" id="nama_maskapai" class="form-control" placeholder="Contoh: Garuda Indonesia" required>
                </div>
                
                <div class="form-group">
                    <label for="kode_maskapai">Kode Maskapai (IATA) <span style="color:var(--danger)">*</span></label>
                    <input type="text" name="kode_maskapai" id="kode_maskapai" class="form-control" placeholder="Contoh: GA" required>
                    <small style="color: var(--text-muted); font-size: 12px; margin-top: 4px; display: block;">Kode 2 huruf standar IATA.</small>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="negara_asal">Negara Asal <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="negara_asal" id="negara_asal" class="form-control" placeholder="Contoh: Indonesia" required>
                    </div>
                    <div class="form-group">
                        <label for="no_kontak">Nomor Kontak <span style="color:var(--danger)">*</span></label>
                        <input type="text" name="no_kontak" id="no_kontak" class="form-control" placeholder="Contoh: 021-23519999" required>
                    </div>
                </div>

                <div style="margin-top: 24px; display: flex; justify-content: center;">
                    <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center; padding: 14px; font-size: 15px;">
                        <i class="fas fa-rocket"></i> Simpan & Mulai Menggunakan Sistem
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
