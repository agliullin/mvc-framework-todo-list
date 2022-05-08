<?php

namespace Core;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMException;
use Doctrine\ORM\Tools\Setup;

/**
 * Database
 * TODO: Create an additional layer for dynamically database connect
 */
class Database
{
    /**
     * Doctrine entity manager
     *
     * @var EntityManager
     */
    protected static $entityManager;

    /**
     * Clear construct in singleton
     */
    private function __construct()
    {
        //
    }

    /**
     * Initialize database connection
     *
     * @return void
     * @throws ORMException
     */
    private static function init()
    {
        $isDevMode = true;
        $proxyDir = null;
        $cache = null;
        $useSimpleAnnotationReader = false;
        $config = Setup::createAnnotationMetadataConfiguration(array(__DIR__."/../src/Entity/"), $isDevMode, $proxyDir, $cache, $useSimpleAnnotationReader);

        $conn = array(
            'driver' => getenv('DB_DRIVER'),
            'dbname' => getenv('DB_NAME'),
            'user' => getenv('DB_USER'),
            'password' => getenv('DB_PASSWORD'),
            'host' => getenv('DB_HOST'),
        );

        $entityManager = EntityManager::create($conn, $config);
        static::$entityManager = $entityManager;
    }

    /**
     * Get instance
     *
     * @return EntityManager
     * @throws ORMException
     */
    public static function getInstance(): EntityManager
    {
        if (!static::$entityManager) {
            static::init();
        }
        return static::$entityManager;
    }

}