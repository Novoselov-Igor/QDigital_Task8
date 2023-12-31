<?php

namespace application\controllers;

use application\core\Controller;
use application\models\User;

class AuthController extends Controller
{
    public function authAction()
    {
        $this->view->render('Регистрация/Авторизация');
    }

    public function authenticateAction()
    {
        if (isset($_POST['login'])) {
            $login = trim($_POST['login']);
        } else {
            $login = "";
        }

        if (isset($_POST['password'])) {
            $password = trim($_POST['password']);
        } else {
            $password = "";
        }

        if ($login === '') {
            echo 'Введите ваш логин.';
            exit;
        } elseif ($password === null) {
            echo 'Введите пароль.';
            exit;
        } elseif (strlen($password) < 6) {
            echo "Пароль слишком короткий.\nПароль должен содержать минимум 6 символов.";
            exit;
        }

        $data = [
            'login' => $login,
            'password' => password_hash($password, PASSWORD_DEFAULT)
        ];

        $user = new User();

        $user->create($data);

        if ($user->comparePasswords($password)) {
            $user = $user->getUser();
            $_SESSION['userId'] = $user['id'];
        } else {
            header('Location: /auth');
        }

        header('Location: /');
    }
}