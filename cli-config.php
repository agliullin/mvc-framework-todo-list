<?php

require 'vendor/autoload.php';

$entityManager = Core\Database::getInstance();

return \Doctrine\ORM\Tools\Console\ConsoleRunner::createHelperSet($entityManager);