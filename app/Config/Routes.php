<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

/*
|--------------------------------------------------------------------------
| DEFAULT ROUTE
|--------------------------------------------------------------------------
*/
$routes->get('/', 'Home::index');


/*
|--------------------------------------------------------------------------
| MENU PELANGGAN
|--------------------------------------------------------------------------
*/
$routes->get('menu', 'Menu::index');
$routes->post('menu/tambah', 'Menu::tambah');


/*
|--------------------------------------------------------------------------
| KERANJANG
|--------------------------------------------------------------------------
*/
$routes->get('menu/keranjang', 'Menu::keranjang');

$routes->get('menu/keranjang/tambah/(:num)/(:num)', 'Menu::tambahQty/$1/$2');
$routes->get('menu/keranjang/kurang/(:num)/(:num)', 'Menu::kurangQty/$1/$2');
$routes->get('menu/keranjang/hapus/(:num)/(:num)', 'Menu::hapusItem/$1/$2');


/*
|--------------------------------------------------------------------------
| CHECKOUT / PEMBAYARAN
|--------------------------------------------------------------------------
*/
$routes->post('menu/struk', 'Menu::struk');

$routes->get('menu/pembayaran/(:num)', 'Menu::pembayaran/$1');
$routes->post('menu/bayar', 'Menu::bayar');

$routes->get('menu/sukses/(:num)', 'Menu::sukses/$1');


/*
|--------------------------------------------------------------------------
| ADMIN AUTH
|--------------------------------------------------------------------------
*/
$routes->get('admin/login', 'Admin::login');
$routes->post('admin/loginProcess', 'Admin::loginProcess');
$routes->get('admin/profile', 'Admin::profile');
$routes->get('admin/edit-profile', 'Admin::editProfile');
$routes->post('admin/update-profile', 'Admin::updateProfile');
$routes->get('admin/logout', 'Admin::logout');
$routes->get('admin/register', 'Admin::register');
$routes->post('admin/registerProcess', 'Admin::registerProcess');


/*
|--------------------------------------------------------------------------
| ADMIN DASHBOARD
|--------------------------------------------------------------------------
*/
$routes->get('admin/dashboard', 'Admin::dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN TRANSAKSI
|--------------------------------------------------------------------------
*/
$routes->get('admin/transaksi', 'Admin::transaksi');
$routes->get('admin/detail/(:num)', 'Admin::detail/$1');
$routes->get('admin/konfirmasi/(:num)', 'Admin::konfirmasi/$1');


/*
|--------------------------------------------------------------------------
| ADMIN MANAJEMEN MENU
|--------------------------------------------------------------------------
*/
$routes->get('admin/menu', 'Admin::menu');

$routes->get('admin/menu/tambah', 'Admin::tambahMenu');
$routes->post('admin/menu/simpan', 'Admin::simpanMenu');

$routes->get('admin/menu/edit/(:num)', 'Admin::editMenu/$1');
$routes->post('admin/menu/update/(:num)', 'Admin::updateMenu/$1');

$routes->get('admin/menu/hapus/(:num)', 'Admin::hapusMenu/$1');


/*
|--------------------------------------------------------------------------
| ADMIN LAPORAN
|--------------------------------------------------------------------------
*/
$routes->get('admin/laporan', 'Admin::laporan');
$routes->post('admin/laporan', 'Admin::laporan');


/*
|--------------------------------------------------------------------------
| ADMIN PROFILE
|--------------------------------------------------------------------------
*/
$routes->get('admin/profile', 'Admin::profile');
$routes->post('admin/updateProfile', 'Admin::updateProfile');
