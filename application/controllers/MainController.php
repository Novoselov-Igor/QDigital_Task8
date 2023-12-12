<?php

namespace application\controllers;

use application\core\Controller;
use application\models\Task;
use application\models\User;

class MainController extends Controller
{
    private function validatePostData($key): string
    {
        if (isset($_POST[$key])) {
            return trim($_POST[$key]);
        } else {
            return '';
        }
    }

    public function mainAction()
    {
        $user = new User();
        $task = new Task();

        if (isset($_SESSION['userId'])) {
            $user = $user->getUserById($_SESSION['userId']);
            $task = $task->getTask($user['id']);

            $vars = ['user' => $user, 'task' => $task];
            $this->view->render('Главная страница', $vars);
        }
        else{
            header('Location: /auth');
        }
    }

    public function logoutAction()
    {
        unset($_SESSION['userId']);
        header('Location: /');
    }

    public function taskAdditionAction()
    {
        $description = $this->validatePostData('task');

        if (isset($_SESSION['userId'])) {
            $userId = trim($_SESSION['userId']);
        } else {
            $userId = '';
        }

        if ($description === '') {
            die('Введите название задачи');
        }
        if ($userId === '') {
            die('Непредвиденная ошибка');
        }

        $data = [
            'user_id' => $userId,
            'description' => $description,
            'status' => 0
        ];

        $task = new Task();
        $task->create($data);

        header('Location: /');
    }

    public function taskRemovalAction()
    {
        $taskId = $this->validatePostData('taskId');
        if (isset($_SESSION['userId'])) {
            $userId = trim($_SESSION['userId']);
        } else {
            $userId = '';
        }

        if ($userId === '') {
            die('Непредвиденная ошибка');
        }

        $task = new Task();

        if ($taskId === '') {
            $task->deleteTasksAll($userId);
        } else {
            $task->deleteTask($taskId, $userId);
        }

        header('Location: /');
    }

    public function taskReadinessAction()
    {
        $taskId = $this->validatePostData('taskId');
        if (isset($_SESSION['userId'])) {
            $userId = trim($_SESSION['userId']);
        } else {
            $userId = '';
        }

        if ($userId === '') {
            die('Непредвиденная ошибка');
        }

        $task = new Task();

        if ($taskId === '') {
            $task->readyTasksAll($userId);
        } else {
            $status = $task->getStatus($taskId, $userId);

            if ($status['status']) {
                $task->readyUnreadyTask($taskId, $userId, 0);
            } else {
                $task->readyUnreadyTask($taskId, $userId, 1);
            }
        }

        header('Location: /');
    }
}