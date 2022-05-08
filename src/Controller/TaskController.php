<?php

namespace App\Controller;

use App\Entity\Task;
use App\Form\TaskForm;
use Core\Application;
use Exception;

/**
 * Task controller
 */
class TaskController extends AController
{
    /**
     * Check access
     *
     * @return bool
     * @throws Exception
     */
    protected function checkAccess(): bool
    {
        return parent::checkAccess() && $this->getUser();
    }

    /**
     * Create task page
     *
     * @throws Exception
     */
    public function create()
    {
        return $this->render('task/create.twig');
    }

    /**
     * POST store task
     *
     * @throws Exception
     */
    public function store()
    {
        // Check request data
        $request = Application::getInstance()->make('request');
        if (!$request->getData()) {
            return $this->redirect('/');
        }

        // Validate and save
        $taskForm = new TaskForm();
        if ($taskForm->load($request->getData()) && $taskForm->validate()) {
            $task = new Task();
            $task->fill($taskForm->getFormFields());
            $task->setStatus(0);

            // Initialize entityManager and repository
            $entityManager = Application::getInstance()->make('database');
            $taskRepository = $entityManager->getRepository(Task::class);
            $taskRepository->add($task);

            // Add flash notification
            $this->addFlash(
                'success',
                'Задача успешно создана!'
            );

            return $this->redirect('/');
        }

        return $this->render('task/create.twig', [
            'task' => $taskForm->getFormFields(),
            'errors' => $taskForm->getErrors()
        ]);
    }

    /**
     * Edit task page
     *
     * @throws Exception
     */
    public function edit()
    {
        // Check access
        if (!$this->checkAccess()) {
            return $this->redirect('/login');
        }

        // Task availability check
        $request = Application::getInstance()->make('request');
        $entityManager = Application::getInstance()->make('database');
        $taskRepository = $entityManager->getRepository(Task::class);
        $task = $taskRepository->findOneById($request->getData()['id'] ?? 0);
        if (!$task) {
            return $this->redirect('/');
        }

        return $this->render('task/edit.twig', [
            'task_id' => $task->getId(),
            'task' => $task
        ]);
    }

    /**
     * POST update task
     *
     * @throws Exception
     */
    public function update()
    {
        // Check access
        if (!$this->checkAccess()) {
            return $this->redirect('/login');
        }

        // Check request data
        $request = Application::getInstance()->make('request');
        if (!$request->getData()) {
            return $this->redirect('/');
        }

        // Task availability check
        $entityManager = Application::getInstance()->make('database');
        $taskRepository = $entityManager->getRepository(Task::class);
        $task = $taskRepository->findOneById($request->getData()['id'] ?? 0);
        if (!$task) {
            return $this->redirect('/');
        }

        // Validate and save
        $taskForm = new TaskForm();
        if ($taskForm->load($request->getData()) && $taskForm->validate()) {
            if ($task->getDescription() != $taskForm->getFormFields()['description']) {
                $task->setIsDescriptionModified(true);
            }
            $task->fill($taskForm->getFormFields());
            $taskRepository->add($task);

            // Add flash notification
            $this->addFlash(
                'success',
                'Задача успешно изменена!'
            );

            return $this->redirect('/');
        }

        return $this->render('task/edit.twig', [
            'task_id' => $task->getId(),
            'task' => $taskForm->getFormFields(),
            'errors' => $taskForm->getErrors()
        ]);
    }
}