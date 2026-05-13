<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="card">
        <div class="card-header">
            <h2>Cetak Boarding Pass</h2>
            <a href="<?= base_url('/boardingpass') ?>" class="btn btn-back">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
        <div class="card-body">
            <form action="<?= base_url('/boardingpass/store') ?>" method="post">
                <div class="form-group">
                    <label for="id_checkin">Pilih Data Check-in</label>
                    <select name="id_checkin" id="id_checkin" class="form-control" required>
                        <option value="">-- Pilih Penumpang --</option>
                        <?php foreach ($checkins as $c): ?>
                            <option value="<?= $c['ID_CHECKIN'] ?>" data-gate-id="<?= $c['ID_GATE'] ?>" data-gate-name="<?= esc($c['NOMOR_GATE']) ?>">
                                <?= esc($c['NAMA_PENUMPANG']) ?> (Tiket: <?= esc($c['NOMER_TIKET']) ?>) - Kursi: <?= esc($c['NO_KURSI2']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label>Gate Boarding (Otomatis)</label>
                        <input type="hidden" name="id_gate" id="id_gate">
                        <input type="text" id="gate_display" class="form-control" readonly placeholder="Pilih penumpang dahulu..." style="background: var(--bg-primary);">
                    </div>
                    <div class="form-group">
                        <label for="waktu_boarding">Waktu Boarding</label>
                        <input type="time" name="waktu_boarding" id="waktu_boarding" class="form-control" required>
                    </div>
                </div>

                <div style="margin-top: 10px; display: flex; justify-content: flex-end;">
                    <button type="submit" class="btn btn-primary" id="btnSubmit" disabled>
                        <i class="fas fa-print"></i> Cetak Boarding Pass
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('id_checkin').addEventListener('change', function() {
        const selected = this.options[this.selectedIndex];
        const gateId = selected.getAttribute('data-gate-id');
        const gateName = selected.getAttribute('data-gate-name');
        
        const gateInput = document.getElementById('id_gate');
        const gateDisplay = document.getElementById('gate_display');
        const btnSubmit = document.getElementById('btnSubmit');

        if (gateId) {
            gateInput.value = gateId;
            gateDisplay.value = 'Gate ' + gateName;
            btnSubmit.disabled = false;
        } else {
            gateInput.value = '';
            gateDisplay.value = '';
            btnSubmit.disabled = true;
        }
    });
</script>

<?= $this->endSection() ?>
