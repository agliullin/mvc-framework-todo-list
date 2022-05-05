<?php

namespace Core;

use Exception;

/**
 * Registry
 */
final class Registry
{
    private static $instance;
    private array $data = [];

    /**
     * Clear construct in singleton
     */
    private function __construct()
    {
        //
    }

    /**
     * Get instance
     *
     * @return Registry
     */
    public static function getInstance(): Registry
    {
        if (!self::$instance) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    /**
     * Maker
     *
     * @param $key
     * @return mixed
     * @throws Exception
     */
    public function make($key)
    {
        if (!$this->has($key)) {
            throw new Exception("Could not resolve $key from data.");
        }

        return $this->data[$key];
    }

    /**
     * Getter
     *
     * @param string $key
     *
     * @return mixed
     */
    public function get(string $key)
    {
        return ($this->data[$key] ?? null);
    }

    /**
     * Setter
     *
     * @param string $key
     * @param $value
     */
    public function set(string $key, $value): void
    {
        $this->data[$key] = $value;
    }

    /**
     * Has
     *
     * @param string $key
     *
     * @return bool
     */
    public function has(string $key): bool
    {
        return isset($this->data[$key]);
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