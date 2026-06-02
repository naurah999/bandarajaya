<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Daftar Catalog Pesawat</h2>
        <a href="<?= base_url('/catalog-pesawat/create') ?>" class="btn btn-primary">
            <i class="fas fa-plus"></i> Tambah Catalog Baru
        </a>
    </div>
    <div class="card-body">
        <div class="table-responsive">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tipe Pesawat</th>
                        <th>Kode</th>
                        <th>Kategori</th>
                        <th>Kapasitas</th>
                        <th>Konfigurasi Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($catalogs)): ?>
                        <tr>
                            <td colspan="7" class="empty-state">
                                <i class="fas fa-book"></i>
                                <p>Data catalog pesawat masih kosong.</p>
                            </td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($catalogs as $c): ?>
                            <tr>
                                <td><?= esc($c['ID_CATALOG']) ?></td>
                                <td style="font-weight: 600; color: var(--text-primary);"><?= esc($c['TIPE_PESAWAT']) ?></td>
                                <td><span class="badge badge-info"><?= esc($c['KODE_TIPE']) ?></span></td>
                                <td><?= esc($c['KATEGORI']) ?></td>
                                <td style="font-weight: 700;"><?= esc($c['TOTAL_KAPASITAS']) ?> Kursi</td>
                                <td>
                                    <?php if(!empty($c['kelas'])): ?>
                                        <div style="display: flex; flex-wrap: wrap; gap: 6px;">
                                            <?php foreach($c['kelas'] as $kelas): ?>
                                                <span style="font-size: 11px; font-weight: 600; padding: 2px 8px; border-radius: 20px; background: <?= esc($kelas['WARNA_KELAS'] ?? '#3b82f6') ?>22; color: <?= esc($kelas['WARNA_KELAS'] ?? '#3b82f6') ?>; border: 1px solid <?= esc($kelas['WARNA_KELAS'] ?? '#3b82f6') ?>66;">
                                                    <?= esc($kelas['NAMA_KELAS']) ?> — Rp <?= number_format($kelas['HARGA_KELAS'] ?? 0, 0, ',', '.') ?>
                                                </span>
                                            <?php endforeach; ?>
                                        </div>
                                    <?php else: ?>
                                        <span style="color: var(--danger); font-size: 12px;">Belum dikonfigurasi</span>
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <div class="action-btns">
                                        <a href="<?= base_url('/catalog-pesawat/show/' . $c['ID_CATALOG']) ?>" class="btn btn-info btn-sm" style="background: var(--info-bg); color: var(--info); border: 1px solid rgba(6,182,212,0.2);">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="<?= base_url('/catalog-pesawat/edit/' . $c['ID_CATALOG']) ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form action="<?= base_url('/catalog-pesawat/delete/' . $c['ID_CATALOG']) ?>" method="post" style="display:inline;" onsubmit="return confirm('Apakah Anda yakin ingin menghapus catalog ini?')">
                                            <button type="submit" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
