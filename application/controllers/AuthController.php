<?php

namespace application\controllers;

use application\core\Controller;

class AuthController extends Controller
{
    public function authAction()
    {
        $this->view->render('Регистрация/Авторизация');
    }
}