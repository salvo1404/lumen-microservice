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

use Laravel\Lumen\Routing\Router;

/**
 * @var Router $router
 */
$router->get('/', function () use ($router) {
    return $router->app->version();
});

$router->get('/players', 'Player\PlayerController@index');
$router->post('/players', 'Player\PlayerController@store');
$router->get('/players/{player}', 'Player\PlayerController@show');
$router->put('/players/{player}', 'Player\PlayerController@update');
$router->patch('/players/{player}', 'Player\PlayerController@update');
$router->delete('/players/{player}', 'Player\PlayerController@destroy');
