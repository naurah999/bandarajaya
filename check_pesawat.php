<?php
$db = new mysqli('127.0.0.1', 'root', '', 'bandarajaya', 3306);
$res = $db->query('SELECT ID_PESAWAT, ID_CATALOG FROM PESAWAT');
while($r = $res->fetch_assoc()) print_r($r);
