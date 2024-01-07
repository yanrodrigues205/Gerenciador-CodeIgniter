<?php

use App\Controllers\AuthController;
use CodeIgniter\Router\RouteCollection;

/**
 * @var RouteCollection $routes
 */

// --ROUTES--

    // -> LOGIN
    $routes->get('/', 'AuthController::index');
    $routes->post('/auth', 'AuthController::init');
    $routes->get('/auth/readToken', 'AuthController::readToken');

    // -> CLIENTS
    $routes->get('/clients','ClientsController::index');
    $routes->post('/clients/add','ClientsController::insert', ["filter"=> "auth"]);
    $routes->post('/clients/edit','ClientsController::alter', ["filter"=> "auth"]);
    $routes->post('/clients/delete','ClientsController::drop', ["filter"=> "auth"]);
    $routes->get('/clients/getbyid/(:num)','ClientsController::getCLientByID/$1', ["filter"=> "auth"]);
    $routes->get('/clients/getall','ClientsController::getAllClients', ["filter"=> "auth"]);
    $routes->get('/clients/phoneStatesPercent','ClientsController::getAllPhones', ["filter"=> "auth"]);
    $routes->get('/clients/getNewsClients','ClientsController::getNewsClients');


    // -> USERS
    $routes->post('/users/add','UsersController::createUser');

