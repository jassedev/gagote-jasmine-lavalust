<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

$router->get('/student', 'StudentController::index');
$router->get('/student/profile', 'StudentController::profile');
$router->get('/users', 'UsersController::index');

$router->any('/', 'AuthController::login');
$router->any('/login', 'AuthController::login');
$router->get('/logout', 'AuthController::logout');

$router->group(['prefix' => '/api'], function ($router) {
    $router->post('/login', 'ApiController::login');
    $router->post('/register', 'ApiController::register');
    $router->post('/refresh', 'ApiController::refresh');
    $router->post('/logout', 'ApiController::logout');
    $router->get('/profile', 'ApiController::profile');

    $router->get('/users', 'ApiController::list');
    $router->post('/users', 'ApiController::create');
    $router->get('/users/{id}', 'ApiController::show');
    $router->put('/users/{id}', 'ApiController::update');
    $router->patch('/users/{id}', 'ApiController::update');
    $router->delete('/users/{id}', 'ApiController::delete');

    $router->get('/products', 'ApiController::products');
    $router->post('/products', 'ApiController::product_create');
    $router->get('/products/{id}', 'ApiController::product_show');
    $router->put('/products/{id}', 'ApiController::product_update');
    $router->patch('/products/{id}', 'ApiController::product_update');
    $router->delete('/products/{id}', 'ApiController::product_delete');

    $router->get('/students', 'ApiController::students');
    $router->post('/students', 'ApiController::student_create');
    $router->get('/students/{id}', 'ApiController::student_show');
    $router->put('/students/{id}', 'ApiController::student_update');
    $router->patch('/students/{id}', 'ApiController::student_update');
    $router->delete('/students/{id}', 'ApiController::student_delete');

    foreach ([
        '/login', '/register', '/refresh', '/logout', '/profile',
        '/users', '/users/{id}',
        '/products', '/products/{id}',
        '/students', '/students/{id}',
    ] as $path) {
        $router->options($path, 'ApiController::preflight');
    }
});

if (defined('IS_CLI') && IS_CLI) {
    $router->get('/migration/migrate', 'MigrationController::migrate');
    $router->get('/migration/rollback', 'MigrationController::rollback');
    $router->get('/migration/rollback-all', 'MigrationController::rollback_all');
    $router->get('/migration/refresh', 'MigrationController::refresh');
    $router->get('/migration/status', 'MigrationController::status');
    $router->get('/migration/create/{name}', 'MigrationController::create');
}

$router->group(['middleware' => 'AuthMiddleware'], function ($router) {
    $router->get('/product/display', 'ProductController::read');
    $router->any('/product/create', 'ProductController::create');
    $router->any('/product/edit/{id}', 'ProductController::edit');
    $router->get('/product/delete/{id}', 'ProductController::delete');

    $router->get('/products', 'ProductController::read');
    $router->any('/products/create', 'ProductController::create');
    $router->any('/products/edit/{id}', 'ProductController::edit');
    $router->get('/products/delete/{id}', 'ProductController::delete');
});


//hi //hello