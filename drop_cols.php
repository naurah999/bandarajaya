<?php
$db = new mysqli('127.0.0.1', 'root', '', 'bandarajaya', 3306);

// Remove unused columns from CATALOG_KELAS
$cols = ['LAYOUT_KURSI', 'BARIS_MULAI', 'BARIS_AKHIR', 'HURUF_KURSI'];
foreach ($cols as $col) {
    $db->query("ALTER TABLE CATALOG_KELAS DROP COLUMN $col");
    echo "Dropped $col: " . ($db->error ?: 'OK') . "\n";
}
echo "Done.\n";
