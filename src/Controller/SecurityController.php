<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\LoginForm;
use Core\Application;
use Exception;

/**
 * Log in/out controller
 */
class SecurityController extends AController
{
    /**
     * Login page
     *
     * @throws Exception
     */
    public function login()
    {
        return $this->render('security/login.twig');
    }

    /**
     * POST auth
     *
     * @throws Exception
     */
    public function auth()
    {
        // Check request data
        $request = Application::getInstance()->make('request');
        if (!$request->getData()) {
            return $this->redirect('/');
        }

        // Validate and auth
        $loginForm = new LoginForm();
        if ($loginForm->load($request->getData()) && $loginForm->validate() && $user = $loginForm->getUser()) {
            $session = Application::getInstance()->make('session');
            $session->set('user', [
                'id' => $user->getId(),
                'username' => $user->getUsername()
            ]);
            return $this->redirect('/');
        }

        return $this->render('security/login.twig', [
            'user' => $loginForm->getFormFields(),
            'errors' => $loginForm->getErrors()
        ]);
    }

    /**
     * Logout
     *
     * @throws Exception
     */
    public function logout()
    {
        $session = Application::getInstance()->make('session');
        $session->unset('user');
        $session->destroy();
        return $this->redirect('/');
    }
}