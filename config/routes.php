<?php

use Core\Application;

$router = Application::getInstance()->make('router');
$router->add('GET', '/', ['controller' => 'HomeController@index']);

$router->add('GET', '/login', ['controller' => 'SecurityController@login']);
$router->add('POST', '/login', ['controller' => 'SecurityController@auth']);
$router->add('GET', '/logout', ['controller' => 'SecurityController@logout']);

$router->add('GET', '/create', ['controller' => 'TaskController@create']);
$router->add('POST', '/create', ['controller' => 'TaskController@store']);
$router->add('GET', '/edit', ['controller' => 'TaskController@edit']);
$router->add('POST', '/edit', ['controller' => 'TaskController@update']);