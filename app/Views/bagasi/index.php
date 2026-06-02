<?= $this->extend('layouts/main') ?>

<?= $this->section('content') ?>

<div class="card">
    <div class="card-header">
        <h2>Data Bagasi Penumpang</h2>
        <a href="<?= base_url('/bagasi/create') ?>" class="btn btn-primary">
            <i class="fas fa-suitcase-rolling"></i> Tambah Bagasi
        </a>
    </div>
    
    <div class="card-body">
        <?php 
            $uniqueFlights = [];
            $uniqueStatuses = [];
            foreach($bagasi as $b) {
                $code = $b['KODE_PENERBANGAN'] ?? 'Tanpa Penerbangan';
                $uniqueFlights[$code] = $code;
                $uniqueStatuses[$b['STATUS_BAGASI']] = $b['STATUS_BAGASI'];
            }
            sort($uniqueFlights);
            ksort($uniqueStatuses);
        ?>

        <!-- Toolbar Filter Section -->
        <div style="display: flex; flex-wrap: wrap; gap: 12px; align-items: center; padding: 14px 16px; background: #f8fafc; border-radius: 10px; border: 1px solid var(--border-color); margin-bottom: 16px;">
            <!-- Search -->
            <div style="flex: 1; min-width: 200px; position: relative;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 13px;"></i>
                <input type="text" id="searchInput" class="form-control" placeholder="Cari nama penumpang, no. tiket..." 
                    style="padding-left: 36px; height: 38px; font-size: 13px;" oninput="applyFilters()">
            </div>
            <!-- Flight Filter -->
            <div style="min-width: 180px;">
                <select id="flightFilter" class="form-control" style="height: 38px; font-size: 13px;" onchange="applyFilters()">
                    <option value="">Semua Penerbangan</option>
                    <?php foreach($uniqueFlights as $f): ?>
                        <option value="<?= esc($f) ?>"><?= esc($f) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Status Filter -->
            <div style="min-width: 150px;">
                <select id="statusFilter" class="form-control" style="height: 38px; font-size: 13px;" onchange="applyFilters()">
                    <option value="">Semua Status</option>
                    <?php foreach($uniqueStatuses as $s): ?>
                        <option value="<?= esc($s) ?>"><?= esc($s) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Result count -->
            <div id="resultCount" style="font-size: 12px; color: var(--text-muted); white-space: nowrap;">
                <?= count($bagasi) ?> data
            </div>
        </div>

        <form id="bulkStatusForm" action="<?= base_url('/bagasi/bulk-update-status') ?>" method="post">
            <input type="hidden" name="bagasi_ids" id="bagasi_ids_input">
            
            <!-- Bulk Action Bar -->
            <div id="bulkActionBar" style="display: none; background: linear-gradient(135deg, #e0f2fe, #f0f9ff); border: 1px solid #bae6fd; padding: 12px 16px; border-radius: 10px; margin-bottom: 16px; align-items: center; justify-content: space-between;">
                <div style="font-weight: 600; color: #0369a1; font-size: 14px;">
                    <i class="fas fa-check-circle"></i> <span id="selectedCount">0</span> bagasi terpilih
                </div>
                <div style="display: flex; gap: 10px; align-items: center;">
                    <select name="bulk_status" class="form-control" style="width: auto; padding: 4px 12px; height: 34px; font-size: 13px;" required>
                        <option value="">-- Pilih Status --</option>
                        <option value="Diterima">Diterima</option>
                        <option value="Dalam Proses">Dalam Proses</option>
                        <option value="Dimuat">Dimuat</option>
                        <option value="Sampai Tujuan">Sampai Tujuan</option>
                    </select>
                    <button type="submit" class="btn btn-primary btn-sm" onclick="return processBulkAction(event)">
                        <i class="fas fa-save"></i> Terapkan
                    </button>
                </div>
            </div>

            <div class="table-responsive">
                <table>
                    <thead>
                        <tr>
                            <th style="width: 40px; text-align: center;">
                                <input type="checkbox" id="selectAll" onclick="toggleAll(this)">
                            </th>
                            <th>Penerbangan</th>
                            <th>Penumpang</th>
                            <th>No. Tiket</th>
                            <th>Berat (Kg)</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="bagasiTableBody">
                        <?php if (empty($bagasi)): ?>
                            <tr id="emptyRow">
                                <td colspan="7" class="empty-state">
                                    <i class="fas fa-suitcase-rolling"></i>
                                    <p>Belum ada data bagasi.</p>
                                </td>
                            </tr>
                        <?php else: ?>
                            <?php foreach ($bagasi as $b): ?>
                                <?php $kode = esc((string)($b['KODE_PENERBANGAN'] ?? 'Tanpa Penerbangan')); ?>
                                <tr class="bagasi-row" data-flight="<?= $kode ?>" data-status="<?= esc($b['STATUS_BAGASI']) ?>" data-search="<?= esc(strtolower(($b['NAMA_PENUMPANG'] ?? '') . ' ' . ($b['NOMER_TIKET'] ?? '') . ' ' . $kode)) ?>">
                                    <td style="text-align: center;">
                                        <input type="checkbox" class="row-checkbox" value="<?= esc($b['ID_BAGASI']) ?>" onchange="updateSelection()">
                                    </td>
                                    <td style="font-weight: 600; color: var(--text-secondary);"><i class="fas fa-plane-departure" style="font-size: 10px; margin-right: 4px;"></i> <?= $kode ?></td>
                                    <td style="font-weight: 600; color: var(--text-primary);"><?= esc((string)($b['NAMA_PENUMPANG'] ?? '-')) ?></td>
                                    <td><span class="badge badge-info"><?= esc((string)($b['NOMER_TIKET'] ?? '-')) ?></span></td>
                                    <td style="font-weight: 700;"><?= number_format((float)$b['BERAT_BAGASI'], 1, ',', '.') ?> Kg</td>
                                    <td>
                                        <span class="badge <?= $b['STATUS_BAGASI'] == 'Diterima' ? 'badge-success' : ($b['STATUS_BAGASI'] == 'Dalam Proses' ? 'badge-warning' : ($b['STATUS_BAGASI'] == 'Dimuat' ? 'badge-info' : 'badge-success')) ?>">
                                            <?= esc((string)$b['STATUS_BAGASI']) ?>
                                        </span>
                                    </td>
                                    <td>
                                        <div class="action-btns">
                                            <a href="<?= base_url('/bagasi/edit/' . $b['ID_BAGASI']) ?>" class="btn btn-warning btn-sm">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" onclick="deleteBagasi(<?= $b['ID_BAGASI'] ?>)" class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </form>
        
        <!-- Hidden delete forms -->
        <?php foreach ($bagasi as $b): ?>
            <form id="deleteForm_<?= $b['ID_BAGASI'] ?>" action="<?= base_url('/bagasi/delete/' . $b['ID_BAGASI']) ?>" method="post" style="display:none;"></form>
        <?php endforeach; ?>
    </div>
</div>

<script>
function deleteBagasi(id) {
    if (confirm('Hapus data bagasi ini?')) {
        document.getElementById('deleteForm_' + id).submit();
    }
}

function applyFilters() {
    const flight = document.getElementById('flightFilter').value;
    const status = document.getElementById('statusFilter').value;
    const search = document.getElementById('searchInput').value.toLowerCase().trim();
    const rows = document.querySelectorAll('.bagasi-row');
    
    // Clear selection when filtering
    document.getElementById('selectAll').checked = false;
    document.querySelectorAll('.row-checkbox').forEach(cb => cb.checked = false);
    updateSelection();
    
    let visibleCount = 0;
    rows.forEach(row => {
        const matchFlight = !flight || row.getAttribute('data-flight') === flight;
        const matchStatus = !status || row.getAttribute('data-status') === status;
        const matchSearch = !search || row.getAttribute('data-search').includes(search);
        
        if (matchFlight && matchStatus && matchSearch) {
            row.style.display = '';
            visibleCount++;
        } else {
            row.style.display = 'none';
        }
    });
    
    document.getElementById('resultCount').textContent = visibleCount + ' / ' + rows.length + ' data';
}

function toggleAll(source) {
    const checkboxes = document.querySelectorAll('.row-checkbox');
    checkboxes.forEach(cb => {
        const row = cb.closest('tr');
        if (row.style.display !== 'none') {
            cb.checked = source.checked;
        } else {
            cb.checked = false;
        }
    });
    updateSelection();
}

function updateSelection() {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    const actionBar = document.getElementById('bulkActionBar');
    const countSpan = document.getElementById('selectedCount');
    
    const count = checkboxes.length;
    countSpan.textContent = count;
    actionBar.style.display = count > 0 ? 'flex' : 'none';
    
    // Update selectAll checkbox state
    const visibleCheckboxes = Array.from(document.querySelectorAll('.bagasi-row')).filter(r => r.style.display !== 'none').map(r => r.querySelector('.row-checkbox'));
    const allChecked = visibleCheckboxes.length > 0 && visibleCheckboxes.every(cb => cb.checked);
    document.getElementById('selectAll').checked = allChecked;
}

function processBulkAction(e) {
    const checkboxes = document.querySelectorAll('.row-checkbox:checked');
    if (checkboxes.length === 0) {
        e.preventDefault();
        alert('Pilih setidaknya satu bagasi.');
        return false;
    }
    
    const ids = Array.from(checkboxes).map(cb => cb.value);
    document.getElementById('bagasi_ids_input').value = ids.join(',');
    
    return confirm(`Apakah Anda yakin ingin mengubah status ${ids.length} bagasi terpilih?`);
}
</script>

<?= $this->endSection() ?>
