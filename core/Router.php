<?php

namespace Core;

use Exception;

/**
 * Router
 */
class Router
{
    /**
     * @var array $routes
     */
    private array $routes = [];

    /**
     * Add route in array
     *
     * @param $method
     * @param $url
     * @param array $callable
     * @return void
     * @throws Exception
     */
    public function add($method, $url, array $callable = [])
    {
        $this->validate($method, $url, $callable);

        if (!isset($this->routes[$method])) {
            $this->routes[$method] = [];
        }

        $this->routes[$method][$url] = $callable;
    }

    /**
     * Validate route
     *
     * @param $method
     * @param $url
     * @param $callable
     * @return void
     * @throws Exception
     */
    public function validate($method, $url, $callable): void
    {
        if (empty($method) || !in_array($method, [Request::GET, Request::POST])) {
            throw new Exception('Invalid request method');
        }

        if (empty($url)) {
            throw new Exception("A url is required to add a route");
        }

        if (!isset($callable['callback']) && !isset($callable['controller'])) {
            throw new Exception("Either a callback or a controller is required");
        }
    }

    /**
     * Match route in array
     *
     * @param $method
     * @param $url
     * @return mixed
     * @throws Exception
     */
    public function match($method, $url)
    {
        if (!isset($this->routes[$method])) {
            throw new Exception("Invalid route method");
        }

        if (!isset($this->routes[$method][$url])) {
            throw new Exception("Invalid route url");
        }

        return $this->routes[$method][$url];
    }
}