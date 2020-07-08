<?php

/*
|--------------------------------------------------------------------------
| Application Routes
|--------------------------------------------------------------------------
|
| Here is where you can register all of the routes for an application.
| It is a breeze. Simply tell Lumen the URIs it should respond to
| and give it the Closure to call when that URI is requested.
|
*/

$router->get('/', function () use ($router) {
    // return $router->app->version();
    return str_random(40);
});

$router->get('/products','ProductsController@get');
$router->post('/products','ProductsController@find');
$router->post('/products/save','ProductsController@save');
$router->delete('/products/drop/{id}','ProductsController@drop');

$router->get('/category','CategoryController@get');
$router->post('/category','CategoryController@find');
$router->post('/category/save','CategoryController@save');
$router->delete('/category/drop/{id}','CategoryController@drop');

$router->post("/register", "UsersController@register");
$router->post("/login", "UsersController@login");

$router->get('/users','UsersController@get');
$router->get('/users/{id}', 'UsersController@getUser');
$router->post('/users','UsersController@find');
$router->post('/users/save','UsersController@save');
$router->delete('/users/drop/{id}','UsersController@drop');

$router->get("/profil/{id}", "UsersController@getProfil");
$router->post("/profil", "UsersController@profil");

$router->get("/address/{id}", "AddressController@get");
$router->post("/address/save", "AddressController@save"); 
$router->delete("/address/drop/{id}", "AddressController@drop");

$router->get("/orders", "OrdersController@get");
$router->get("/orders/{id_user}", "OrdersController@getById");
$router->post("/orders/save", "OrdersController@save");
$router->post("/accept/{id_order}", "OrdersController@accept");
$router->post("/decline/{id_order}", "OrdersController@decline");

