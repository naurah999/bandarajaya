<?php
$db = new mysqli('127.0.0.1', 'root', '', 'bandarajaya', 3306);
$db->query("UPDATE PESAWAT SET ID_CATALOG = 1 WHERE TIPE_PESAWAT LIKE '%Boeing%'");
$db->query("UPDATE PESAWAT SET ID_CATALOG = 4 WHERE TIPE_PESAWAT LIKE '%Airbus%'");
echo "Updated PESAWAT ID_CATALOG: " . $db->affected_rows . "\n";
