<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

//==============================================================================
// DEFAULT ROUTE
//==============================================================================
$routes->get('/', 'Menu\MenuPelanggan::landing');

//==============================================================================
// ROUTES PELANGGAN
//==============================================================================

//------------------------------------------------------------------------------
// Halaman Menu
//------------------------------------------------------------------------------
$routes->get('menu', 'Menu\MenuPelanggan::index');

//------------------------------------------------------------------------------
// Keranjang
//------------------------------------------------------------------------------
$routes->post('menu/tambah', 'Menu\Keranjang::tambah');
$routes->get('menu/keranjang', 'Menu\Keranjang::lihat');
$routes->get('menu/keranjang/tambah/(:num)/(:num)', 'Menu\Keranjang::tambahQty/$1/$2');
$routes->get('menu/keranjang/kurang/(:num)/(:num)', 'Menu\Keranjang::kurangQty/$1/$2');
$routes->get('menu/keranjang/hapus/(:num)/(:num)', 'Menu\Keranjang::hapusItem/$1/$2');

//------------------------------------------------------------------------------
// Checkout & Pembayaran
//------------------------------------------------------------------------------
$routes->post('menu/struk', 'Menu\Checkout::struk');
$routes->post('menu/bayar', 'Menu\Checkout::bayar');
$routes->get('menu/sukses/(:num)', 'Menu\Checkout::sukses/$1');

//==============================================================================
// ROUTES ADMIN
//==============================================================================

//------------------------------------------------------------------------------
// AUTH (Login/Logout)
//------------------------------------------------------------------------------
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/loginProcess', 'Admin\Auth::loginProcess');
$routes->get('admin/logout', 'Admin\Auth::logout');

//------------------------------------------------------------------------------
// DASHBOARD
//------------------------------------------------------------------------------
$routes->get('admin', 'Admin\Dashboard::index');
$routes->get('admin/dashboard', 'Admin\Dashboard::index');

//------------------------------------------------------------------------------
// TRANSAKSI
//------------------------------------------------------------------------------
$routes->get('admin/transaksi', 'Admin\Transaksi::index');
$routes->get('admin/transaksi/detail/(:num)', 'Admin\Transaksi::detail/$1');
$routes->get('admin/transaksi/konfirmasi/(:num)', 'Admin\Transaksi::konfirmasi/$1');
$routes->get('admin/transaksi/tambah', 'Admin\Transaksi::tambah');
$routes->post('admin/transaksi/simpan', 'Admin\Transaksi::simpan');
$routes->get('admin/transaksi/hapus/(:num)', 'Admin\Transaksi::hapus/$1');

//------------------------------------------------------------------------------
// MANAJEMEN MENU
//------------------------------------------------------------------------------
$routes->get('admin/menu', 'Admin\MenuManager::index');
$routes->get('admin/menu/tambah', 'Admin\MenuManager::tambah');
$routes->post('admin/menu/simpan', 'Admin\MenuManager::simpan');
$routes->get('admin/menu/edit/(:num)', 'Admin\MenuManager::edit/$1');
$routes->post('admin/menu/update/(:num)', 'Admin\MenuManager::update/$1');
$routes->get('admin/menu/hapus/(:num)', 'Admin\MenuManager::hapus/$1');

//------------------------------------------------------------------------------
// LAPORAN
//------------------------------------------------------------------------------
$routes->get('admin/laporan', 'Admin\Laporan::index');
$routes->post('admin/laporan', 'Admin\Laporan::index');

//------------------------------------------------------------------------------
// PROFIL
//------------------------------------------------------------------------------
$routes->get('admin/profile', 'Admin\Profile::index');
$routes->get('admin/edit-profile', 'Admin\Profile::edit');
$routes->post('admin/update-profile', 'Admin\Profile::update');