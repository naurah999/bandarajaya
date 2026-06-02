<?php
$db = new mysqli('127.0.0.1', 'root', '', 'bandarajaya', 3306);

// 1. Add LAYOUT_KURSI to CATALOG_PESAWAT
$db->query("ALTER TABLE CATALOG_PESAWAT ADD COLUMN LAYOUT_KURSI VARCHAR(10) NOT NULL DEFAULT '3-3' AFTER KATEGORI");
echo "1. Added LAYOUT_KURSI to CATALOG_PESAWAT: " . ($db->error ?: 'OK') . "\n";

// 2. Copy existing layouts from first kelas row to catalog level
$res = $db->query("SELECT ID_CATALOG, LAYOUT_KURSI FROM CATALOG_KELAS GROUP BY ID_CATALOG");
while ($r = $res->fetch_assoc()) {
    $db->query("UPDATE CATALOG_PESAWAT SET LAYOUT_KURSI = '{$r['LAYOUT_KURSI']}' WHERE ID_CATALOG = {$r['ID_CATALOG']}");
}
echo "2. Copied layouts to catalog level: OK\n";

// 3. Verify
$res = $db->query("SELECT ID_CATALOG, TIPE_PESAWAT, LAYOUT_KURSI, TOTAL_KAPASITAS FROM CATALOG_PESAWAT");
while ($r = $res->fetch_assoc()) {
    echo "   Catalog #{$r['ID_CATALOG']}: {$r['TIPE_PESAWAT']} | Layout: {$r['LAYOUT_KURSI']} | Cap: {$r['TOTAL_KAPASITAS']}\n";
}

echo "Done.\n";
