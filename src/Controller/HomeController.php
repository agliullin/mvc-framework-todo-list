<?php

namespace App\Controller;

use App\Entity\Task;
use App\Repository\TaskRepository;
use Core\Application;
use Core\Database;
use Core\Request;
use Exception;

/**
 * Home controller
 */
class HomeController extends AController
{
    /**
     * Home page
     *
     * @return bool
     * @throws Exception
     */
    public function index(): bool
    {
        // Request data
        $request = Application::getInstance()->make('request');
        $currentSort = $request->getData()['sort'] ?? false;
        $currentOrder = $request->getData()['order'] ?? false;
        $requestData = $this->normalizeRequestData($request->getData());

        // Get tasks
        $entityManager = Application::getInstance()->make('database');
        $taskRepository = $entityManager->getRepository(Task::class);
        $taskService = new \App\Service\TaskService($taskRepository);
        $tasks = $taskService->get($requestData);

        // Make correct sort links
        // TODO: Create an additional layer that will store sortable fields
        $sorts = $this->initializeSorts();
        $sorts = $this->correctSorts($sorts, $requestData);

        // Make pagination
        // TODO: Create an additional layer to make adaptive pagination by request data
        $maxPage = ceil($taskRepository->count([]) / $requestData['limit']);
        $pagination = $this->makePagination($requestData, $maxPage);

        return $this->render('home/index.twig', [
            'tasks' => $tasks,
            'currentPage' => $requestData['page'],
            'maxPage' => $maxPage,
            'pagination' => $pagination,
            'sorts' => $sorts,
            'currentSort' => $currentSort,
            'currentOrder' => $currentOrder
        ]);
    }

    /**
     * Initialize sorts
     *
     * @return string[][]
     */
    public function initializeSorts(): array
    {
        return [
            'status' => [
                'order' => 'ASC',
                'href' => '?sort=status'
            ],
            'name' => [
                'order' => 'ASC',
                'href' => '?sort=name'
            ],
            'email' => [
                'order' => 'ASC',
                'href' => '?sort=email'
            ],
        ];
    }

    /**
     * Correct sort href by available request data
     *
     * @param $sorts
     * @param $requestData
     * @return array
     */
    public function correctSorts($sorts, $requestData): array
    {
        if (isset($requestData['sort']) && array_key_exists($requestData['sort'], $sorts)) {
            $sorts[$requestData['sort']]['order'] = $requestData['order'] == 'ASC' ? 'DESC' : 'ASC';
        }
        foreach ($sorts as $name => $sort) {
            $sorts[$name]['href'] .= '&order=' . $sort['order'];
            if ($requestData['page']) {
                $sorts[$name]['href'] .= '&page=' . $requestData['page'];
            }
        }
        return $sorts;
    }

    /**
     * Make pagination
     *
     * @param $requestData
     * @param $maxPage
     * @return array
     */
    public function makePagination($requestData, $maxPage): array
    {
        $pagination = [];
        for ($i = 1; $i <= $maxPage; $i++) {
            $pagination[] = [
                'href' => '?sort=' . $requestData['sort'] . '&order=' . $requestData['order'] . '&page=' . $i,
                'value' => $i
            ];
        }
        return $pagination;
    }

    /**
     * Normalize request data
     *
     * @param array $requestData
     * @return array
     */
    private function normalizeRequestData(array $requestData): array
    {
        return [
            'page' => (int) ($requestData['page'] ?? 1),
            'limit' => (int) ($requestData['limit'] ?? 3),
            'sort' => $requestData['sort'] ?? 'id',
            'order' => $requestData['order'] ?? 'ASC'
        ];
    }
}