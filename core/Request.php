<?php

namespace Core;

/**
 * Request
 */
class Request
{
    /**
     * GET method name
     */
    const GET = 'GET';

    /**
     * POST method name
     */
    const POST = 'POST';

    /**
     * Path
     *
     * @var mixed $path
     */
    private $path;

    /**
     * Data
     *
     * @var array $data
     */
    private array $data;

    /**
     * Method
     *
     * @var string
     */
    private string $method;

    /**
     * Constructor
     */
    public function __construct()
    {
        list($path) = explode("?", $_SERVER['REQUEST_URI']);
        $path = str_replace(getenv('APP_FOLDER'), '', $path);
        $this->path = $path;
        $this->method = $_SERVER['REQUEST_METHOD'];
        $this->data = $this->getRequestData()[$this->method];
    }

    /**
     * Get path
     *
     * @return mixed
     */
    public function getPath()
    {
        return $this->path;
    }

    /**
     * Get data
     *
     * @return array
     */
    public function getData(): array
    {
        return $this->data;
    }

    /**
     * Get method
     *
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * Get request data
     *
     * @return array
     */
    private function getRequestData(): array
    {
        return [
            self::GET => $_GET,
            self::POST => $_POST,
        ];
    }
}