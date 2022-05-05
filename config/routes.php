<?php

use Core\Application;

$router = Application::getInstance()->make('router');
$router->add('GET', '/', ['controller' => 'HomeController@home']);