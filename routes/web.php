<?php

/** @var \Laravel\Lumen\Routing\Router $router */

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
    return $router->app->version();
});
$router->get('{table}', 'WaveController@index');
$router->post('{table}/maingrid', 'WaveController@list');
//$router->get('notes', 'WaveController@index');
$router->post('{table}/save[/{id}]', 'WaveController@save');
$router->post('{table}/get[/{id}]', 'WaveController@get');
$router->post('{table}/delete[/{id}]', 'WaveController@delete');
//Route::get('test/',function() {
//    return view('dev.jqueryui');
//});
