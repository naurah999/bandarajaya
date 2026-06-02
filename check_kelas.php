<?php
$db = new mysqli('127.0.0.1', 'root', '', 'bandarajaya', 3306);
$res = $db->query('SELECT * FROM CATALOG_KELAS');
while($r = $res->fetch_assoc()) print_r($r);
