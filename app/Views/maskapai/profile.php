<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card" style="box-shadow: var(--shadow-md); border-top: 4px solid var(--accent-primary);">
        <div class="card-header" style="padding: 30px; display: flex; justify-content: space-between; align-items: flex-start; border-bottom: none;">
            <div style="display: flex; gap: 24px; align-items: center;">
                <div style="width: 80px; height: 80px; background: var(--bg-primary); border-radius: 20px; display: flex; align-items: center; justify-content: center; font-size: 40px; color: var(--accent-primary); border: 2px solid rgba(99, 102, 241, 0.1);">
                    <i class="fas fa-plane-departure"></i>
                </div>
                <div>
                    <h2 style="font-size: 28px; font-weight: 800; margin-bottom: 8px; color: var(--text-primary);">
                        <?= esc($maskapai['NAMA_MASKAPAI']) ?>
                    </h2>
                    <span class="badge badge-info" style="font-size: 14px; padding: 6px 12px;">
                        <i class="fas fa-tag"></i> Kode IATA: <?= esc($maskapai['KODE_MASKAPAI']) ?>
                    </span>
                </div>
            </div>
            <a href="<?= base_url('/maskapai/edit') ?>" class="btn btn-primary">
                <i class="fas fa-edit"></i> Edit Profil
            </a>
        </div>
        
        <div class="card-body" style="padding: 0 30px 30px 30px;">
            <div style="background: #f8fafc; border-radius: 16px; padding: 24px; border: 1px solid var(--border-color);">
                <h3 style="font-size: 14px; font-weight: 700; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 20px;">
                    Informasi Perusahaan
                </h3>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 24px;">
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--accent-secondary); box-shadow: var(--shadow-sm);">
                            <i class="fas fa-globe-asia"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 12px; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Negara Asal</span>
                            <span style="font-size: 15px; font-weight: 600; color: var(--text-primary);"><?= esc($maskapai['NEGARA_ASAL']) ?></span>
                        </div>
                    </div>
                    
                    <div style="display: flex; gap: 16px; align-items: flex-start;">
                        <div style="width: 40px; height: 40px; background: white; border-radius: 10px; display: flex; align-items: center; justify-content: center; color: var(--accent-secondary); box-shadow: var(--shadow-sm);">
                            <i class="fas fa-phone-alt"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 12px; color: var(--text-muted); font-weight: 600; margin-bottom: 4px;">Nomor Kontak</span>
                            <span style="font-size: 15px; font-weight: 600; color: var(--text-primary);"><?= esc($maskapai['NO_KONTAK']) ?></span>
                        </div>
                    </div>
                </div>
            </div>
            
            <div style="margin-top: 30px; display: grid; grid-template-columns: repeat(3, 1fr); gap: 16px;">
                <a href="<?= base_url('/pesawat') ?>" style="text-decoration: none;">
                    <div style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 12px; transition: all 0.2s;">
                        <div style="width: 36px; height: 36px; background: var(--info-bg); color: var(--info); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-plane"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 14px; font-weight: 700; color: var(--text-primary);">Armada</span>
                            <span style="font-size: 12px; color: var(--text-muted);">Kelola Pesawat</span>
                        </div>
                    </div>
                </a>
                
                <a href="<?= base_url('/penerbangan') ?>" style="text-decoration: none;">
                    <div style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 12px; transition: all 0.2s;">
                        <div style="width: 36px; height: 36px; background: var(--success-bg); color: var(--success); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-route"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 14px; font-weight: 700; color: var(--text-primary);">Penerbangan</span>
                            <span style="font-size: 12px; color: var(--text-muted);">Jadwal Rute</span>
                        </div>
                    </div>
                </a>
                
                <a href="<?= base_url('/catalog-pesawat') ?>" style="text-decoration: none;">
                    <div style="background: white; border: 1px solid var(--border-color); border-radius: 12px; padding: 16px; display: flex; align-items: center; gap: 12px; transition: all 0.2s;">
                        <div style="width: 36px; height: 36px; background: var(--warning-bg); color: var(--warning); border-radius: 8px; display: flex; align-items: center; justify-content: center;">
                            <i class="fas fa-book"></i>
                        </div>
                        <div>
                            <span style="display: block; font-size: 14px; font-weight: 700; color: var(--text-primary);">Catalog</span>
                            <span style="font-size: 12px; color: var(--text-muted);">Template Pesawat</span>
                        </div>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<style>
    a > div:hover {
        border-color: var(--accent-primary) !important;
        transform: translateY(-2px);
        box-shadow: var(--shadow-sm);
    }
</style>

<?= $this->endSection() ?>
