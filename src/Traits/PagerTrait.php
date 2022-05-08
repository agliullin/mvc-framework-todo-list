<?php

namespace App\Traits;

/**
 * Pager for pagination
 */
trait PagerTrait
{
    /**
     * Get page
     *
     * @param int $page
     * @return int
     */
    public function getPage(int $page = 1): int
    {
        if ($page < 1) {
            $page = 1;
        }

        return floor($page);
    }

    /**
     * Get limit
     *
     * @param int $limit
     * @return int
     */
    public function getLimit(int $limit = 3): int
    {
        if ($limit < 1 || $limit > 3) {
            $limit = 3;
        }

        return floor($limit);
    }

    /**
     * Get offset
     *
     * @param $page
     * @param $limit
     * @return int
     */
    public function getOffset($page, $limit): int
    {
        $offset = 0;
        if ($page != 0 && $page != 1) {
            $offset = ($page - 1) * $limit;
        }

        return $offset;
    }
}