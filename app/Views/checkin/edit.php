<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Edit Check-in</h2>
            <a href="<?= base_url('/checkin') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/checkin/update/' . $checkin['ID_CHECKIN']) ?>" method="post">
                <div class="form-group">
                    <label for="id_tiket">Pilih Tiket Penumpang</label>
                    <select name="id_tiket" id="id_tiket" class="form-control" required>
                        <?php foreach ($tikets as $t): ?>
                            <option value="<?= $t['ID_TIKET'] ?>" <?= $t['ID_TIKET'] == $checkin['ID_TIKET'] ? 'selected' : '' ?>>
                                <?= esc($t['NOMER_TIKET']) ?> - <?= esc($t['NAMA_PENUMPANG']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-group">
                    <label for="id_kursi">Pilih Kursi Tersedia</label>
                    <select name="id_kursi" id="id_kursi" class="form-control" required>
                        <?php foreach ($kursi as $k): ?>
                            <option value="<?= $k['ID_KURSI'] ?>" <?= $k['ID_KURSI'] == $checkin['ID_KURSI'] ? 'selected' : '' ?>>
                                <?= esc($k['NO_KURSI2']) ?> (<?= esc($k['KELAS_PENERBANAN']) ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary">
                        <i class="fas fa-save"></i> Perbarui Check-in
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<?= $this->endSection() ?>
