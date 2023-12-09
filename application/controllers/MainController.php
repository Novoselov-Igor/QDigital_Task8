<?php

namespace application\controllers;

use application\core\Controller;

class MainController extends Controller
{
    public function mainAction()
    {
        $vars = ['test' => 'test'];
        $this->view->render('Главная страница', $vars);
    }
}