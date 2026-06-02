<?php
require 'vendor/autoload.php';
$app = require_once 'system/bootstrap.php';
$db = \Config\Database::connect();
$res = $db->query('SELECT ID_PESAWAT, ID_CATALOG, KODE_PESAWAT, TIPE_PESAWAT, KAPASITAS FROM PESAWAT')->getResultArray();
print_r($res);
