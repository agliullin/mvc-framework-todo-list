<?php

namespace App\Controller;

/**
 * Home controller
 */
class HomeController extends AController
{
    /**
     * Home action
     *
     * @return void
     */
    public function home()
    {
        $data['hello'] = 'Hello';
        $this->render('home/home.twig', $data);
    }
}