<?php

use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */


$routes->get('/', 'Home::index');
$routes->get('/home', 'IndexController::index');

$routes->get('/signup/register', 'SignUpController::register');
$routes->get('/signup/login', 'SignUpController::login');
$routes->get('/signup/logout', 'SignUpController::logout');
$routes->post('signup/register', 'SignUpController::create_account');
$routes->post('signup/login', 'SignUpController::signIn');


$routes->get('user/profile_edit', 'UserController::profile_edit');
$routes->get('user/profile/(:num)', 'UserController::profile');
$routes->post('user/profile_edit', 'UserController::update');

$routes->get('note/note', 'NoteController::note');
$routes->post('note/note_add', 'NoteController::note_add');


$routes->get('drawflow/index', 'DrawflowController::index');
$routes->get('drawflow/parser', 'DrawflowController::parser');
$routes->get('drawflow/test', 'DrawflowController::test');