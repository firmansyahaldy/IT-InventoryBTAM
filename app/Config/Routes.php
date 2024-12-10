<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

$routes->get('/', 'AuthController::index');
// Auth group
$routes->get('/auth/login', 'AuthController::index');
$routes->post('/auth/login', 'AuthController::login');
$routes->get('/auth/logout', 'AuthController::logout');

// Cek Maintenance
$routes->get('maintenance/check', 'MaintenanceController::checkMaintenance');

// Group dengan login filter
$routes->group('dashboard', ['filter' => 'loginFilter'], function ($routes) {
    $routes->get('/', 'DashboardController::index');
    $routes->get('user', 'UserController::index');
    $routes->get('barang', 'BarangController::index');
    $routes->get('laporan', 'MaintenanceController::index');
    $routes->get('barang_keluar', 'BarangKeluarController::index');
    $routes->get('data_master', 'MasterController::index');
    $routes->get('cetak_laporan', 'LaporanController::index');

    // user CRUD
    // tambah user
    $routes->post('user/create', 'UserController::create');
    // Ambil data user berdasarkan ID untuk edit    
    $routes->get('user/getUser/(:num)', 'UserController::getUser/$1');
    // Update user setelah edit
    $routes->post('user/update', 'UserController::update');
    // Hapus User
    $routes->post('user/delete/(:num)', 'UserController::delete/$1');

    // barang CRUD
    // tambah barang
    $routes->post('barang/create', 'BarangController::create');
    // Ambil data barang berdasarkan ID untuk edit
    $routes->post('barang/update', 'BarangController::update');
    // Hapus barang
    $routes->post('barang/delete/(:any)', 'BarangController::delete/$1');
    // Ambil data barang
    $routes->get('barang/getBarang/(:any)', 'BarangController::getBarang/$1');

    // Maintenance CRUD
    $routes->get('maintenance/exportRepairPDF', 'MaintenanceController::exportRepairPDF');
    // $routes->post('maintenance/create', 'MaintenanceController::create');
    // Edit maintenance
    $routes->post('maintenance/update', 'MaintenanceController::update');
    // Hapus Maintenance
    $routes->post('maintenance/delete/(:num)', 'MaintenanceController::delete/$1');
    // Ambil data maintenance berdasarkan ID untuk edit
    $routes->get('maintenance/getMaintenance/(:num)', 'MaintenanceController::getMaintenance/$1');

    // barang keluar CRUD
    $routes->post('barang_keluar/save', 'BarangKeluarController::save');
    $routes->get('barang_keluar/getBarangKeluar/(:num)', 'BarangKeluarController::getBarangKeluar/$1');
    $routes->post('barang_keluar/returnItem/(:num)', 'BarangKeluarController::returnItem/$1');
    // $routes->post('barang_keluar/returnItem', 'BarangKeluarController::returnItem');
    $routes->get('barang_keluar/filter', 'BarangKeluarController::filter');
    $routes->get('barang/getStok/(:num)', 'BarangKeluarController::getStok/$1');

    // Master CRUD
    $routes->post('data_master/(:segment)/create', 'MasterController::create/$1');
    $routes->post('data_master/(:segment)/update/(:num)', 'MasterController::update/$1/$2');
    $routes->post('data_master/(:segment)/delete/(:num)', 'MasterController::delete/$1/$2');
    $routes->get('data_master/(:segment)/get/(:num)', 'MasterController::get/$1/$2');

    // Cetak Laporan
    $routes->get('laporancontroller/getData/(:any)', 'LaporanController::getData/$1');
    $routes->get('laporancontroller/export/(:any)/(:any)', 'LaporanController::export/$1/$2');
    $routes->get('cetak_laporan_pengembalian', 'LaporanController::printReturnReport');
});
