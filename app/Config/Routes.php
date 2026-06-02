<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// Default Route (Maskapai)
$routes->get('/', 'Maskapai::index');
$routes->get('/migrate', 'MigrateDb::index');

// Maskapai
$routes->get('/maskapai', 'Maskapai::index');
$routes->get('/maskapai/edit', 'Maskapai::edit');
$routes->post('/maskapai/update', 'Maskapai::update');
$routes->post('/maskapai/setup', 'Maskapai::setup');

// Catalog Pesawat
$routes->get('/catalog-pesawat', 'CatalogPesawat::index');
$routes->get('/catalog-pesawat/create', 'CatalogPesawat::create');
$routes->post('/catalog-pesawat/store', 'CatalogPesawat::store');
$routes->get('/catalog-pesawat/show/(:num)', 'CatalogPesawat::show/$1');
$routes->get('/catalog-pesawat/edit/(:num)', 'CatalogPesawat::edit/$1');
$routes->post('/catalog-pesawat/update/(:num)', 'CatalogPesawat::update/$1');
$routes->post('/catalog-pesawat/delete/(:num)', 'CatalogPesawat::delete/$1');

// Pesawat
$routes->get('/pesawat', 'Pesawat::index');
$routes->get('/pesawat/create', 'Pesawat::create');
$routes->post('/pesawat/store', 'Pesawat::store');
$routes->get('/pesawat/edit/(:num)', 'Pesawat::edit/$1');
$routes->post('/pesawat/update/(:num)', 'Pesawat::update/$1');
$routes->post('/pesawat/delete/(:num)', 'Pesawat::delete/$1');
$routes->post('/pesawat/regenerate-seats/(:num)', 'Pesawat::regenerateSeats/$1');

// Gate
$routes->get('/gate', 'Gate::index');
$routes->get('/gate/create', 'Gate::create');
$routes->post('/gate/store', 'Gate::store');
$routes->get('/gate/edit/(:num)', 'Gate::edit/$1');
$routes->post('/gate/update/(:num)', 'Gate::update/$1');
$routes->post('/gate/delete/(:num)', 'Gate::delete/$1');

// Penerbangan
$routes->get('/penerbangan', 'Penerbangan::index');
$routes->get('/penerbangan/create', 'Penerbangan::create');
$routes->post('/penerbangan/store', 'Penerbangan::store');
$routes->get('/penerbangan/edit/(:num)', 'Penerbangan::edit/$1');
$routes->post('/penerbangan/update/(:num)', 'Penerbangan::update/$1');
$routes->post('/penerbangan/delete/(:num)', 'Penerbangan::delete/$1');

// Penumpang
$routes->get('/penumpang', 'Penumpang::index');
$routes->get('/penumpang/create', 'Penumpang::create');
$routes->post('/penumpang/store', 'Penumpang::store');
$routes->get('/penumpang/edit/(:num)', 'Penumpang::edit/$1');
$routes->post('/penumpang/update/(:num)', 'Penumpang::update/$1');
$routes->post('/penumpang/delete/(:num)', 'Penumpang::delete/$1');

// Tiket
$routes->get('/tiket', 'Tiket::index');
$routes->get('/tiket/create', 'Tiket::create');
$routes->post('/tiket/store', 'Tiket::store');
$routes->get('/tiket/edit/(:num)', 'Tiket::edit/$1');
$routes->post('/tiket/update/(:num)', 'Tiket::update/$1');
$routes->post('/tiket/delete/(:num)', 'Tiket::delete/$1');
$routes->get('/tiket/get-classes/(:num)', 'Tiket::getClasses/$1');

$routes->get('/checkin/get-available-seats/(:num)', 'Checkin::getAvailableSeats/$1');
$routes->get('/checkin', 'Checkin::index');
$routes->get('/checkin/create', 'Checkin::create');
$routes->post('/checkin/store', 'Checkin::store');
$routes->get('/checkin/edit/(:num)', 'Checkin::edit/$1');
$routes->post('/checkin/update/(:num)', 'Checkin::update/$1');
$routes->post('/checkin/delete/(:num)', 'Checkin::delete/$1');

// Kursi
$routes->get('/kursi', 'Kursi::index');
$routes->get('/kursi/create', 'Kursi::create');
$routes->post('/kursi/store', 'Kursi::store');
$routes->get('/kursi/edit/(:num)', 'Kursi::edit/$1');
$routes->post('/kursi/update/(:num)', 'Kursi::update/$1');
$routes->post('/kursi/delete/(:num)', 'Kursi::delete/$1');
$routes->get('/kursi/get-plane-seats/(:num)', 'Kursi::getPlaneSeats/$1');
$routes->post('/kursi/bulk-assign-class', 'Kursi::bulkAssignClass');

// Bagasi
$routes->get('/bagasi', 'Bagasi::index');
$routes->get('/bagasi/create', 'Bagasi::create');
$routes->post('/bagasi/store', 'Bagasi::store');
$routes->get('/bagasi/edit/(:num)', 'Bagasi::edit/$1');
$routes->post('/bagasi/update/(:num)', 'Bagasi::update/$1');
$routes->post('/bagasi/delete/(:num)', 'Bagasi::delete/$1');

$routes->post('/bagasi/bulk-update-status', 'Bagasi::bulkUpdateStatus');
// Boarding Pass
$routes->get('/boardingpass', 'BoardingPass::index');
$routes->get('/boardingpass/create', 'BoardingPass::create');
$routes->post('/boardingpass/store', 'BoardingPass::store');
$routes->get('/boardingpass/edit/(:num)', 'BoardingPass::edit/$1');
$routes->post('/boardingpass/update/(:num)', 'BoardingPass::update/$1');
$routes->post('/boardingpass/delete/(:num)', 'BoardingPass::delete/$1');

// Pembayaran
$routes->get('/pembayaran', 'Pembayaran::index');
$routes->get('/pembayaran/create', 'Pembayaran::create');
$routes->post('/pembayaran/store', 'Pembayaran::store');
$routes->get('/pembayaran/edit/(:num)', 'Pembayaran::edit/$1');
$routes->post('/pembayaran/update/(:num)', 'Pembayaran::update/$1');
$routes->post('/pembayaran/delete/(:num)', 'Pembayaran::delete/$1');

// Metode Pembayaran
$routes->get('/metode-pembayaran', 'MetodePembayaran::index');
$routes->get('/metode-pembayaran/create', 'MetodePembayaran::create');
$routes->post('/metode-pembayaran/store', 'MetodePembayaran::store');
$routes->get('/metode-pembayaran/edit/(:num)', 'MetodePembayaran::edit/$1');
$routes->post('/metode-pembayaran/update/(:num)', 'MetodePembayaran::update/$1');
$routes->post('/metode-pembayaran/delete/(:num)', 'MetodePembayaran::delete/$1');

// Detail Pembayaran
$routes->get('/detail-pembayaran', 'DetailPembayaran::index');
$routes->get('/detail-pembayaran/create', 'DetailPembayaran::create');
$routes->post('/detail-pembayaran/store', 'DetailPembayaran::store');
$routes->get('/detail-pembayaran/edit/(:num)', 'DetailPembayaran::edit/$1');
$routes->post('/detail-pembayaran/update/(:num)', 'DetailPembayaran::update/$1');
$routes->post('/detail-pembayaran/delete/(:num)', 'DetailPembayaran::delete/$1');

// Laporan
$routes->get('/laporan/penjualan', 'Laporan::penjualan');
$routes->get('/laporan/manifest', 'Laporan::manifest');


