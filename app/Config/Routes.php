<?php
// app/Config/Routes.php
use CodeIgniter\Router\RouteCollection;
/** @var RouteCollection $routes */

// ── Public ───────────────────────────────────────────────────
$routes->get('/',                   'BerandaController::index');
$routes->get('services',            'ServicesController::index');
$routes->get('services/konseling',  'ChatbotController::index');
$routes->post('chatbot/send',       'ChatbotController::send');
$routes->get('chatbot/session',     'ChatbotController::getSession');
$routes->post('chatbot/clear',      'ChatbotController::clear');

$routes->get('form',                'FormController::index');
$routes->post('form/submit',        'FormController::submit');

$routes->get('tes',                 'TesController::index');
$routes->post('tes/submit',         'TesController::submit');
$routes->get('tes/hasil/(:num)',    'TesController::hasil/$1');

$routes->get('blogs',               'BlogsController::index');
$routes->get('blogs/(:segment)',    'BlogsController::detail/$1');

// ── Admin login ───────────────────────────────────────────────
$routes->get('admin/login',         'AdminController::login');
$routes->post('admin/login',        'AdminController::doLogin');
$routes->get('admin/logout',        'AdminController::logout');

// ── Admin (butuh login) ───────────────────────────────────────
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('',                                'AdminController::dashboard');

    // Responden
    $routes->get('mahasiswa',                       'AdminController::mahasiswa');
    $routes->get('mahasiswa/(:num)',                'AdminController::respondenDetail/$1');
    $routes->get('mahasiswa/delete/(:num)',         'AdminController::respondenDelete/$1');

    // Hasil Tes
    $routes->get('hasil-tes',                       'AdminController::hasilTes');

    // Pertanyaan DASS-21
    $routes->get('pertanyaan-dass',                 'AdminController::pertanyaanDass');
    $routes->post('pertanyaan-dass/save',           'AdminController::pertanyaanDassSave');
    $routes->get('pertanyaan-dass/delete/(:num)',   'AdminController::pertanyaanDassDelete/$1');
    $routes->post('pertanyaan-dass/toggle/(:num)',  'AdminController::pertanyaanDassToggle/$1');

    // Form Fields
    $routes->get('form-fields',                     'AdminController::formFields');
    $routes->post('form-fields/save',               'AdminController::formFieldsSave');
    $routes->get('form-fields/delete/(:num)',       'AdminController::formFieldsDelete/$1');
    $routes->post('form-fields/toggle/(:num)',      'AdminController::formFieldsToggle/$1');

    // Blog (dengan halaman form terpisah untuk upload gambar)
    $routes->get('blogs',                           'AdminController::blogs');
    $routes->get('blogs/create',                    'AdminController::blogsCreate');
    $routes->get('blogs/edit/(:num)',               'AdminController::blogsEdit/$1');
    $routes->post('blogs/save',                     'AdminController::blogsSave');
    $routes->get('blogs/delete/(:num)',             'AdminController::blogsDelete/$1');

    // Security
    $routes->get('security-logs',                   'AdminController::securityLogs');
});