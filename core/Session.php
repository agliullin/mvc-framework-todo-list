<?php

namespace Core;

/**
 * Session
 */
class Session
{
    /**
     * Set to session
     *
     * @param $key
     * @param $value
     * @return void
     */
    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    /**
     * Unset to session
     *
     * @param $key
     * @return void
     */
    public static function unset($key)
    {
        unset($_SESSION[$key]);
    }

    /**
     * Get from session
     *
     * @param $key
     * @return false|mixed
     */
    public static function get($key)
    {
        return (isset($_SESSION[$key])) ? $_SESSION[$key] : false;
    }

    /**
     * Destroy session
     *
     * @return void
     */
    public static function destroy()
    {
        session_destroy();
    }
}