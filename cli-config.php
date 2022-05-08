<?php

/**
 * PSR-4 Autoload
 */
require 'vendor/autoload.php';

/**
 * Load env file
 */
$dotenv = \Dotenv\Dotenv::createUnsafeImmutable(__DIR__);
$dotenv->load();

$entityManager = Core\Database::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);