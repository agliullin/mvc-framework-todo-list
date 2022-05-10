<?php

namespace App\Service;

use App\Repository\TaskRepository;
use App\Traits\PagerTrait;

/**
 * Task service
 */
class TaskService implements TaskServiceInterface
{
    /**
     * Pager for pagination
     */
    use PagerTrait;

    /**
     * Allowed sorts
     */
    const SORT_ALLOWED = ['status', 'name', 'email'];

    /**
     * Allowed orders
     */
    const ORDER_ALLOWED = ['ASC', 'DESC'];

    /**
     * Task repo
     *
     * @var TaskRepository
     */
    private TaskRepository $taskRepository;

    /**
     * Constructor
     *
     * @param TaskRepository $taskRepository
     */
    public function __construct(TaskRepository $taskRepository)
    {
        $this->taskRepository = $taskRepository;
    }

    /**
     * Get paginated tasks
     *
     * @param array $data
     * @return array|object[]
     */
    public function get(array $data): array
    {
        $page = $this->getPage($data['page']);
        $limit = $this->getLimit($data['limit']);
        $offset = $this->getOffset($page, $limit);
        $sort = in_array($data['sort'], self::SORT_ALLOWED) ? $data['sort'] : 'id';
        $order = in_array($data['order'], self::ORDER_ALLOWED) ? $data['order'] : 'ASC';

        return $this->taskRepository->findBy([], [$sort => $order], $limit, $offset);
    }
}