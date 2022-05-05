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
     * @return void
     */
    protected function render(string $view, array $parameters = [])
    {
        echo $this->renderView($view, $parameters);
    }

}