<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */
$routes->get('/', 'Home::index');
$routes->get('/page/(:any)', 'Home::page/$1');
$routes->get('/detailberita/(:any)', 'Home::detailberita/$1');
$routes->get('/detailagenda/(:any)', 'Home::detailagenda/$1');
$routes->get('/kerjasama/(:any)', 'Home::kerjasama/$1');
$routes->get('/detailkerjasama/(:any)', 'Home::detailkerjasama/$1');
$routes->get('/detailkerjasama/(:any)', 'Home::detailkerjasama/$1');
$routes->get('/berita', 'Home::berita');
$routes->get('/agenda', 'Home::agenda');
$routes->get('/alumni', 'Home::alumni');
$routes->get('/alumnidownload', 'Home::alumnidownload');
$routes->get('/kartualumni', 'Home::kartualumni');
$routes->post('/cetakkartu', 'Home::cetakkartu');
$routes->get('/cetakkartu', 'Home::cetakkartu');
$routes->get('/cerita', 'Home::cerita');
$routes->get('/karier', 'Home::karier');
$routes->get('/karier/(:any)', 'Home::karierdetail/$1');
$routes->get('/detailcerita/(:any)', 'Home::detailcerita/$1');
$routes->get('/add_cerita', 'Home::add_cerita');
$routes->post('/create_cerita', 'Home::create_cerita');
$routes->get('/expo', 'Home::expo');
$routes->get('/expo/(:any)', 'Home::expodetail/$1');

// TUSSSSS ===============================================================

$routes->get('/auth', 'Auth::index');
$routes->post('login', 'Auth::login');
$routes->post('auth/logout', 'Auth::logout');

$routes->group('admin', ['filter' => 'admin'], function ($routes) {
    $routes->get('/', 'Dashboard::admin');
    $routes->get('alumni', 'Alumni::index');
    $routes->get('alumni/(:num)', 'Alumni::detail/$1');
    $routes->post('alumni/upload', 'Alumni::uploadExcel');
    $routes->post('alumni/insert', 'Alumni::insert');
    $routes->post('alumni/update', 'Alumni::update');
    $routes->post('alumni/delete', 'Alumni::delete');

    $routes->get('karier', 'Karier::index');
    $routes->get('karier/(:num)', 'Karier::detail/$1');
    $routes->post('karier/insert', 'Karier::insert');
    $routes->post('karier/update', 'Karier::update');
    $routes->post('karier/delete', 'karier::delete');

    $routes->get('kerjasama', 'Kerjasama::index');
    $routes->get('kerjasama/(:num)', 'Kerjasama::edit/$1');
    $routes->get('kerjasama/tambah', 'Kerjasama::tambah');
    $routes->post('kerjasama/insert', 'Kerjasama::insert');
    $routes->post('kerjasama/update', 'Kerjasama::update');
    $routes->post('kerjasama/delete', 'Kerjasama::delete');

    $routes->get('upcoming', 'Agenda::index');
    $routes->post('upcoming/insert', 'Agenda::insert');
    $routes->post('upcoming/update', 'Agenda::update');
    $routes->post('upcoming/delete', 'Agenda::delete');

    $routes->get('expo', 'Expo::index');
    $routes->get('expo/(:num)', 'Expo::edit/$1');
    $routes->get('expo/tambah', 'Expo::tambah');
    $routes->post('expo/insert', 'Expo::insert');
    $routes->post('expo/update', 'Expo::update');
    $routes->post('expo/delete', 'Expo::delete');

    $routes->get('berita', 'Berita::index');
    $routes->get('berita/tambah', 'Berita::tambah');
    $routes->post('berita/insert', 'Berita::insert');
    $routes->post('berita/update', 'Berita::update');
    $routes->post('berita/delete', 'Berita::delete');
    $routes->get('berita/edit/(:num)', 'Berita::edit/$1');

    $routes->get('page', 'Page::index');
    $routes->get('page/edit/(:num)', 'Page::edit/$1');
    $routes->post('page/update', 'Page::update');

    $routes->get('cerita-alumni', 'Cerita::index');
    $routes->get('cerita-alumni/approved', 'Cerita::approved');
    $routes->get('cerita-alumni/rejected', 'Cerita::rejected');
    $routes->get('cerita-alumni/(:num)', 'Cerita::detail/$1');
    $routes->get('cerita-alumni/edit/(:num)', 'Cerita::edit/$1');
    $routes->post('cerita-alumni/update', 'Cerita::update');
    $routes->post('cerita-alumni/approve', 'Cerita::approve');
    $routes->post('cerita-alumni/reject', 'Cerita::reject');
    $routes->post('page/update', 'Page::update');
});
