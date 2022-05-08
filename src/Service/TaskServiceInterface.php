<?php

namespace App\Service;

/**
 * Task service interface
 */
interface TaskServiceInterface
{
    /**
     * @param array $data
     * @return mixed
     */
    public function get(array $data);
}