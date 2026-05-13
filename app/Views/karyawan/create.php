<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card" style="max-width: 600px; margin: 0 auto;">
    <div class="card-header">
        <h2>Tambah Karyawan Baru</h2>
    </div>
    <div class="card-body">
        <form action="<?= base_url('/karyawan/store') ?>" method="post">
            <div class="form-group">
                <label for="nama_karyawan">Nama Lengkap</label>
                <input type="text" name="nama_karyawan" id="nama_karyawan" class="form-control" required placeholder="Contoh: Budi Santoso">
            </div>
            <div class="form-group">
                <label for="jabatan">Jabatan / Role</label>
                <select name="jabatan" id="jabatan" class="form-control" required>
                    <option value="">-- Pilih Jabatan --</option>
                    <option value="Pilot">Pilot</option>
                    <option value="Co-Pilot">Co-Pilot</option>
                    <option value="Staf Bandara">Staf Bandara</option>
                    <option value="Teknisi">Teknisi</option>
                    <option value="Security">Security</option>
                    <option value="Kebersihan">Kebersihan</option>
                </select>
            </div>
            <div class="form-group">
                <label for="no_telp">Nomor Telepon</label>
                <input type="text" name="no_telp" id="no_telp" class="form-control" placeholder="0812xxxx">
            </div>
            <div class="form-group">
                <label for="status_kerja">Status Kerja</label>
                <select name="status_kerja" id="status_kerja" class="form-control">
                    <option value="Aktif">Aktif</option>
                    <option value="Cuti">Cuti</option>
                    <option value="Resign">Resign</option>
                </select>
            </div>
            <div style="margin-top: 20px; display: flex; gap: 10px;">
                <button type="submit" class="btn btn-primary">Simpan Data</button>
                <a href="<?= base_url('/karyawan') ?>" class="btn btn-secondary">Batal</a>
            </div>
        </form>
    </div>
</div>

<?= $this->endSection() ?>
