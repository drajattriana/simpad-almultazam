<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


/* --------------------------------------------- Auth ontroller --------------------------------------------- */
$routes->get('/', 'AuthController::index');
$routes->get('/home', 'AuthController::index');
$routes->get('/login', 'AuthController::index');
$routes->get('/logout', 'AuthController::logout');
$routes->post('/auth/login', 'AuthController::loginAuth');
$routes->get('/set_session/(:num)', 'AuthController::session/$1');

/* --------------------------------------------- Ajax Controller --------------------------------------------- */
$routes->post('/Ajax/edit_role/(:num)', 'AjaxController::edit_role/$1');
$routes->post('/Ajax/edit_menu/(:num)', 'AjaxController::edit_menu/$1');
$routes->post('/Ajax/edit_submenu/(:num)', 'AjaxController::edit_submenu/$1');
$routes->post('/Ajax/edit_siswa/(:num)', 'AjaxController::edit_siswa/$1');
$routes->post('/Ajax/edit_ipad/(:num)', 'AjaxController::edit_ipad/$1');
$routes->post('/Ajax/edit_kelas/(:num)', 'AjaxController::edit_kelas/$1');
$routes->post('/Ajax/edit_akun/(:num)', 'AjaxController::edit_akun/$1');

/* --------------------------------------------- Superadmin ontroller --------------------------------------------- */
$routes->get('/superadmin', 'SuperadminController::index');
$routes->post('/superadmin/getStudentsByClass', 'SuperadminController::getStudentsByClass');
$routes->get('/superadmin/role', 'SuperadminController::role');
$routes->post('/superadmin/role/add', 'SuperadminController::role/add');
$routes->post('/superadmin/role/update', 'SuperadminController::role/update');
$routes->get('/superadmin/role/delete/(:num)', 'SuperadminController::role/delete/$1');

$routes->get('/superadmin/navigation/(:num)', 'SuperadminController::navigation/$1');
$routes->post('/superadmin/navigation/(:num)/add', 'SuperadminController::navigation/$1/add');
$routes->get('/superadmin/navigation/(:num)/delete/(:num)', 'SuperadminController::navigation/$1/delete/$2');

$routes->get('/superadmin/menu', 'SuperadminController::menu');
$routes->post('/superadmin/menu/add', 'SuperadminController::menu/add');
$routes->post('/superadmin/menu/update', 'SuperadminController::menu/update');
$routes->get('/superadmin/menu/delete/(:num)', 'SuperadminController::menu/delete/$1');

$routes->get('/superadmin/submenu/(:num)', 'SuperadminController::submenu/$1');
$routes->post('/superadmin/submenu/(:num)/add', 'SuperadminController::submenu/$1/add');
$routes->get('/superadmin/submenu/(:num)/delete/(:num)', 'SuperadminController::submenu/$1/delete/$2');

$routes->get('/superadmin/akun', 'SuperadminController::akun');
$routes->post('/superadmin/akun/add', 'SuperadminController::akun/add');
$routes->post('/superadmin/akun/update', 'SuperadminController::akun/update');
$routes->get('/superadmin/akun/delete/(:num)', 'SuperadminController::akun/delete/$1');

/* --------------------------------------------- Student ontroller --------------------------------------------- */
$routes->get('/siswa', 'StudentController::student');
$routes->post('/siswa/add', 'StudentController::student/add');
$routes->post('/siswa/update', 'StudentController::student/update');
$routes->get('/siswa/delete/(:num)', 'StudentController::student/delete/$1');

$routes->post('siswa/import', 'StudentController::import');
$routes->get('siswa/download-template', 'StudentController::downloadTemplate');

$routes->get('/siswa/ipad', 'StudentController::ipad');
$routes->post('/siswa/ipad/update', 'StudentController::ipad/update');

$routes->get('/siswa/scan', 'StudentController::scan');
$routes->get('/siswa/scan/(:any)', 'StudentController::scan/$1');
$routes->post('student/scan/process', 'StudentController::processScan');

$routes->get('/siswa/kelas', 'StudentController::class');
$routes->post('/siswa/kelas/add', 'StudentController::class/add');
$routes->post('/siswa/kelas/update', 'StudentController::class/update');
$routes->get('/siswa/kelas/delete/(:num)', 'StudentController::class/delete/$1');

$routes->get('/siswa/history', 'StudentController::history');
// Add route for PDF export
$routes->get('/siswa/export_pdf', 'StudentController::export_pdf');

$routes->get('/reset/scan', 'StudentController::resetScan');


/* --------------------------------------------- Superadmin ontroller --------------------------------------------- */
$routes->get('/admin', 'AdminController::index');
$routes->post('/admin/getStudentsByClass', 'AdminController::getStudentsByClass');