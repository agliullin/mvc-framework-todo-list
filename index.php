<?php

/**
 * Start session
 */
session_start();

/**
 * PSR-4 Autoload
 */
require 'vendor/autoload.php';

/**
 * Require configs
 */
require 'config/routes.php';

try {
    $dispatcher = new Core\Dispatcher();
    $dispatcher->dispatch();
} catch (Exception $exception) {
    echo $exception->getMessage();
}