<?php

namespace App\Traits;

/**
 * Password hash trait
 */
trait PasswordHashTrait
{
    /**
     * Make password hash
     *
     * @param $value
     * @return false|string|null
     */
    public function makePasswordHash($value)
    {
        return password_hash($value, PASSWORD_DEFAULT);
    }

    /**
     * Verify password hash
     *
     * @param $value
     * @param $hash
     * @return bool
     */
    public function verifyPasswordHash($value, $hash): bool
    {
        return password_verify($value, $hash);
    }
}