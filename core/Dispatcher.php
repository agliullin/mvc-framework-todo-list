<?php

namespace Core;

use Exception;

/**
 * Dispatcher
 */
class Dispatcher {
    /**
     * Application class
     *
     * @var Registry|null
     */
    private ?Registry $app;

    /**
     * Request class
     *
     * @var mixed
     */
    private $request;

    /**
     * Router class
     *
     * @var mixed
     */
    private $router;

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->app = Application::getInstance();
        $this->request = $this->app->make('request');
        $this->router = $this->app->make('router');
    }

    /**
     * Dispatch
     *
     * @throws Exception
     */
    public function dispatch()
    {
        $url = $this->request->getPath();
        $method = $this->request->getMethod();
        $data = $this->request->getData();

        $callable = $this->router->match($method, $url);

        // Check if isset callable function
        if (isset($callable['callback'])) {
            $callback = $callable['callback'];
            return $callback($data);
        }

        // Check if isset callable controller
        if (isset($callable['controller'])) {
            $controllerDefinition = $callable['controller'];
            list($controller, $method) = explode('@', $controllerDefinition);
            $controllerClass = 'App\\Controller\\' . $controller;
            $controllerInstance = new $controllerClass;
            return $controllerInstance->$method($data);
        }

        throw new Exception('Either callback or controller is required');
    }
}