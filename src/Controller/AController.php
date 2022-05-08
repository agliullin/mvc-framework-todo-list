<?php

namespace App\Controller;

use Core\Application;
use Exception;

/**
 * Abstract class of controller
 */
abstract class AController
{
    /**
     * View engine
     *
     * @var mixed $viewEngine
     */
    protected $viewEngine;

    /**
     * Constructor
     *
     * @throws Exception
     */
    public function __construct()
    {
        $this->viewEngine = Application::getInstance()->make('twig');
    }

    /**
     * Render view in current viewEngine
     *
     * @param string $view
     * @param array $parameters
     * @return string
     */
    protected function renderView(string $view, array $parameters = []): string
    {
        if (!$this->viewEngine) {
            throw new \LogicException('You cannot use the "renderView" method if the Twig is not available.');
        }

        return $this->viewEngine->render($view, $parameters);
    }

    /**
     * Render a view
     *
     * @param string $view
     * @param array $parameters
     * @return bool
     * @throws Exception
     */
    protected function render(string $view, array $parameters = []): bool
    {
        echo $this->renderView($view, array_merge($parameters, ['app' => $this->getAppVariables()]));
        return true;
    }

    /**
     * Get app variables
     *
     * @return array
     * @throws Exception
     */
    protected function getAppVariables(): array
    {
        return [
            'user' => $this->getUser(),
            'flash' => $this->getFlash(),
            'url' => $this->getAppUrl()
        ];
    }

    public function getAppUrl()
    {
        return getenv('APP_FOLDER') ? '/' . getenv('APP_FOLDER') : '/';
    }

    /**
     * Get User
     *
     * @return mixed
     * @throws Exception
     */
    public function getUser()
    {
        $session = Application::getInstance()->make('session');
        return $session->get('user') ?? false;
    }

    /**
     * Get flash message
     *
     * @return mixed
     * @throws Exception
     */
    public function getFlash()
    {
        $session = Application::getInstance()->make('session');
        $flash = $session->get('flash') ?? false;
        $session->unset('flash');

        return $flash;
    }

    /**
     * Using the dispatcher
     */
    public function redirect($url): bool
    {
        header('Location: ' . $this->getAppUrl() . ltrim($url, '/'));
        return true;
    }

    /**
     * Check access
     *
     * @return bool
     */
    protected function checkAccess(): bool
    {
        return true;
    }

    /**
     * Adds a flash message to the current session for type.
     *
     * @throws Exception
     */
    protected function addFlash(string $type, $message): void
    {
        $session = Application::getInstance()->make('session');
        $session->set('flash', [
            'type' => $type,
            'message' => $message
        ]);
    }
}