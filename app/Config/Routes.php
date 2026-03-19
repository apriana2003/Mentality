<?php
// app/Config/Routes.php

use CodeIgniter\Router\RouteCollection;

/** @var RouteCollection $routes */

// ── Public routes ────────────────────────────────────────────
$routes->get('/',                    'BerandaController::index');
$routes->get('/services',            'ServicesController::index');
$routes->get('/services/konseling',  'ChatbotController::index');
$routes->post('/chatbot/send',       'ChatbotController::send');
$routes->get('/chatbot/session',     'ChatbotController::getSession');
$routes->post('/chatbot/clear',      'ChatbotController::clear');

$routes->get('/form',                'FormController::index');
$routes->post('/form/submit',        'FormController::submit');

$routes->get('/tes',                 'TesController::index');
$routes->post('/tes/submit',         'TesController::submit');
$routes->get('/tes/hasil/(:num)',    'TesController::hasil/$1');

$routes->get('/blogs',               'BlogsController::index');
$routes->get('/blogs/(:segment)',    'BlogsController::detail/$1');

// ── Admin routes ─────────────────────────────────────────────
$routes->group('admin', ['filter' => 'adminAuth'], function($routes) {
    $routes->get('/',                           'AdminController::dashboard');
    $routes->get('/mahasiswa',                  'AdminController::mahasiswa');
    $routes->get('/mahasiswa/(:num)',            'AdminController::respondenDetail/$1');
    $routes->get('/mahasiswa/delete/(:num)',     'AdminController::respondenDelete/$1');
    $routes->get('/hasil-tes',                  'AdminController::hasilTes');
    $routes->get('/security-logs',              'AdminController::securityLogs');
    $routes->get('/blogs',                      'AdminController::blogs');
    $routes->post('/blogs/save',                'AdminController::blogsSave');
    $routes->get('/blogs/delete/(:num)',        'AdminController::blogsDelete/$1');
});
$routes->get('/admin/login',         'AdminController::login');
$routes->post('/admin/login',        'AdminController::doLogin');
$routes->get('/admin/logout',        'AdminController::logout');