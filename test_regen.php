<?php
require 'vendor/autoload.php';
$app = Config\Services::codeigniter(new Config\App());
$app->initialize();
$controller = new \App\Controllers\Pesawat();
$controller->initController($app->getRequest(), $app->getResponse(), \Config\Services::logger());
$controller->regenerateSeats(1);
echo "Done";
