<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 1000px; margin: 0 auto;">
    <div class="card" style="margin-bottom: 24px;">
        <div class="card-header" style="display: flex; justify-content: space-between; align-items: center;">
            <div style="display: flex; align-items: center; gap: 16px;">
                <div style="width: 48px; height: 48px; background: var(--bg-primary); border-radius: 12px; display: flex; align-items: center; justify-content: center; font-size: 24px; color: var(--accent-primary);">
                    <i class="fas fa-book"></i>
                </div>
                <div>
                    <h2 style="margin-bottom: 4px;"><?= esc($catalog['TIPE_PESAWAT']) ?></h2>
                    <span class="badge badge-info"><?= esc($catalog['KODE_TIPE']) ?></span>
                </div>
            </div>
            <div>
                <a href="<?= base_url('/catalog-pesawat/edit/' . $catalog['ID_CATALOG']) ?>" class="btn btn-warning">
                    <i class="fas fa-edit"></i> Edit
                </a>
                <a href="<?= base_url('/catalog-pesawat') ?>" class="btn btn-back">
                    <i class="fas fa-arrow-left"></i> Kembali
                </a>
            </div>
        </div>
        
        <div class="card-body">
            <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 20px; margin-bottom: 30px;">
                <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color);">
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; display: block; margin-bottom: 4px;">Kategori</span>
                    <span style="font-size: 16px; font-weight: 700; color: var(--text-primary);"><?= esc($catalog['KATEGORI']) ?></span>
                </div>
                <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color);">
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; display: block; margin-bottom: 4px;">Total Kapasitas</span>
                    <span style="font-size: 16px; font-weight: 700; color: var(--text-primary);"><?= esc($catalog['TOTAL_KAPASITAS']) ?> Kursi</span>
                </div>
                <div style="background: #f8fafc; padding: 16px; border-radius: 12px; border: 1px solid var(--border-color);">
                    <span style="font-size: 12px; color: var(--text-muted); font-weight: 600; display: block; margin-bottom: 4px;">Jumlah Kelas</span>
                    <span style="font-size: 16px; font-weight: 700; color: var(--text-primary);"><?= count($catalog['kelas']) ?> Kelas</span>
                </div>
            </div>

            <?php if(!empty($catalog['DESKRIPSI'])): ?>
                <div style="margin-bottom: 30px;">
                    <h3 style="font-size: 14px; font-weight: 700; color: var(--text-secondary); margin-bottom: 8px;">Deskripsi</h3>
                    <p style="font-size: 14px; color: var(--text-primary); line-height: 1.6; background: #fff; padding: 16px; border-radius: 8px; border: 1px solid var(--border-color);">
                        <?= esc($catalog['DESKRIPSI']) ?>
                    </p>
                </div>
            <?php endif; ?>

            <h3 style="font-size: 16px; font-weight: 700; color: var(--text-primary); margin-bottom: 16px; padding-bottom: 8px; border-bottom: 1px solid var(--border-color);">Konfigurasi Kelas & Layout</h3>

            <div style="display: grid; gap: 16px;">
                <?php foreach($catalog['kelas'] as $kelas): ?>
                    <div style="border: 1px solid var(--border-color); border-radius: 12px; overflow: hidden;">
                        <div style="background: rgba(99, 102, 241, 0.05); padding: 12px 16px; border-bottom: 1px solid var(--border-color); display: flex; justify-content: space-between; align-items: center;">
                            <strong style="color: var(--accent-primary); font-size: 14px;">
                                <i class="fas fa-couch"></i> Kelas <?= esc($kelas['NAMA_KELAS']) ?>
                            </strong>
                            <span class="badge badge-info">Layout: <?= esc($kelas['LAYOUT_KURSI']) ?></span>
                        </div>
                        <div style="padding: 16px; display: flex; justify-content: space-between; align-items: center;">
                            <div>
                                <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Rentang Baris (Row)</div>
                                <div style="font-size: 15px; font-weight: 600;">Row <?= esc($kelas['BARIS_MULAI']) ?> sampai Row <?= esc($kelas['BARIS_AKHIR']) ?></div>
                            </div>
                            <div style="text-align: right;">
                                <div style="font-size: 12px; color: var(--text-muted); margin-bottom: 4px;">Huruf Kursi</div>
                                <div style="font-size: 15px; font-weight: 600; letter-spacing: 2px;"><?= esc($kelas['HURUF_KURSI']) ?></div>
                            </div>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
