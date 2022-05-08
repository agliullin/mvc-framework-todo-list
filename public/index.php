<?php

/**
 * Start session
 */
session_start();

/**
 * PSR-4 Autoload
 */
require '../vendor/autoload.php';

/**
 * Load env file
 */
$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__ . '/../');
$dotenv->load();


/**
 * Require configs
 */
require '../config/routes.php';

try {
    $dispatcher = new Core\Dispatcher();
    $dispatcher->dispatch();
} catch (Exception $exception) {
    echo $exception->getMessage();
}