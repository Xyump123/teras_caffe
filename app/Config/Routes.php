<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// ==================== DEFAULT ROUTE ====================
$routes->get('/', 'Menu\MenuPelanggan::landing');

// ==================== MENU PELANGGAN ====================
$routes->get('menu', 'Menu\MenuPelanggan::index');
$routes->post('menu/tambah', 'Menu\Keranjang::tambah');
$routes->get('menu/keranjang', 'Menu\Keranjang::lihat');
$routes->get('menu/keranjang/tambah/(:num)/(:num)', 'Menu\Keranjang::tambahQty/$1/$2');
$routes->get('menu/keranjang/kurang/(:num)/(:num)', 'Menu\Keranjang::kurangQty/$1/$2');
$routes->get('menu/keranjang/hapus/(:num)/(:num)', 'Menu\Keranjang::hapusItem/$1/$2');
$routes->post('menu/struk', 'Menu\Checkout::struk');
$routes->post('menu/bayar', 'Menu\Checkout::bayar');
$routes->get('menu/sukses/(:num)', 'Menu\Checkout::sukses/$1');

// ==================== ADMIN AUTH ====================
$routes->get('admin/login', 'Admin\Auth::login');
$routes->post('admin/loginProcess', 'Admin\Auth::loginProcess');
$routes->get('admin/logout', 'Admin\Auth::logout');

// ==================== ADMIN DASHBOARD ====================
$routes->get('admin', 'Admin\Dashboard::index');
$routes->get('admin/dashboard', 'Admin\Dashboard::index');

// ==================== ADMIN TRANSAKSI (CRUD LENGKAP) ====================
$routes->get('admin/transaksi', 'Admin\Transaksi::index');                              // Daftar transaksi
$routes->get('admin/transaksi/detail/(:num)', 'Admin\Transaksi::detail/$1');           // Detail transaksi
$routes->get('admin/transaksi/konfirmasi/(:num)', 'Admin\Transaksi::konfirmasi/$1');   // Konfirmasi pembayaran
$routes->get('admin/transaksi/tambah', 'Admin\Transaksi::tambah');                     // Form tambah transaksi manual
$routes->post('admin/transaksi/simpan', 'Admin\Transaksi::simpan');                    // Simpan transaksi baru
$routes->get('admin/transaksi/edit/(:num)', 'Admin\Transaksi::edit/$1');               // Form edit transaksi
$routes->post('admin/transaksi/update/(:num)', 'Admin\Transaksi::update/$1');          // Update transaksi
$routes->get('admin/transaksi/hapus/(:num)', 'Admin\Transaksi::hapus/$1');             // Hapus transaksi

// ==================== ADMIN MANAJEMEN MENU (CRUD) ====================
$routes->get('admin/menu', 'Admin\MenuManager::index');                                // Daftar menu
$routes->get('admin/menu/tambah', 'Admin\MenuManager::tambah');                       // Form tambah menu
$routes->post('admin/menu/simpan', 'Admin\MenuManager::simpan');                      // Simpan menu baru
$routes->get('admin/menu/edit/(:num)', 'Admin\MenuManager::edit/$1');                 // Form edit menu
$routes->post('admin/menu/update/(:num)', 'Admin\MenuManager::update/$1');            // Update menu
$routes->get('admin/menu/hapus/(:num)', 'Admin\MenuManager::hapus/$1');               // Hapus menu

// ==================== ADMIN LAPORAN ====================
$routes->get('admin/laporan', 'Admin\Laporan::index');
$routes->post('admin/laporan', 'Admin\Laporan::index');

// ==================== ADMIN PROFIL ====================
$routes->get('admin/profile', 'Admin\Profile::index');
$routes->get('admin/edit-profile', 'Admin\Profile::edit');
$routes->post('admin/update-profile', 'Admin\Profile::update');

// ==================== REDIRECT ROUTES LAMA (Opsional, untuk kompatibilitas) ====================
// Routing lama yang masih mungkin dipanggil akan diarahkan ke routing baru
$routes->get('admin/detail/(:num)', function($id) {
    return redirect()->to('/admin/transaksi/detail/' . $id);
});

$routes->get('admin/konfirmasi/(:num)', function($id) {
    return redirect()->to('/admin/transaksi/konfirmasi/' . $id);
});