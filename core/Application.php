<?php

namespace Core;

use Doctrine\ORM\ORMException;

/**
 * Application
 */
class Application {
    /**
     * @var ?Registry $registry
     */
    private static ?Registry $registry = null;

    /**
     * Clear construct in singleton
     */
    private function __construct()
    {
        //
    }

    /**
     * Initialize main components in application
     *
     * @return void
     * @throws ORMException
     */
    private static function init()
    {
        $registry = Registry::getInstance();
        $registry->set('database', Database::getInstance());
        $registry->set('request', new Request());
        $registry->set('router', new Router());
        $registry->set('twig', new \Twig\Environment(new \Twig\Loader\FilesystemLoader('views')));
        $registry->set('session', new Session());
        static::$registry = $registry;
    }

    /**
     * Get instance
     *
     * @return Registry
     * @throws ORMException
     */
    public static function getInstance(): Registry
    {
        if (!static::$registry) {
            static::init();
        }
        return static::$registry;
    }

    /**
     * Clear clone in singleton
     *
     * @return void
     */
    private function __clone()
    {
        //
    }

    /**
     * Clear wakeup in singleton
     *
     * @return void
     */
    private function __wakeup()
    {
        //
    }
}