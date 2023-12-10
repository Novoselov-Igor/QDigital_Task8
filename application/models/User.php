<?php

namespace application\models;

use application\core\Model;

class User extends Model
{
    protected $table = 'users';
    protected $fillable = [
        'login',
        'password'
    ];

    private function hasAccount()
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE `login` = :login';
        return $this->db->query($sql, ['login' => $this->fillable['login']]);
    }

    private function authenticate()
    {
        $user = $this->hasAccount();
        $user = $user->fetch(\PDO::FETCH_ASSOC);
        setcookie('userId', $user['id'], time() + 360000, '/');
    }

    private function checkUser()
    {
        $check = $this->hasAccount();
        if ($check->rowCount() <= 0) {
            $this->insert();
        }
        $this->authenticate();
    }

    protected function insert()
    {
        $sql = 'INSERT INTO ' . $this->table . '(login, password) VALUES (:login, :password)';
        $this->db->query($sql, $this->fillable);
    }

    public function create($data)
    {
        if (!empty($data)) {
            $this->fillable = $data;
            $this->checkUser();
        } else {
            die('Передан пустой массив');
        }
    }

    public function getUser()
    {
        if (isset($_COOKIE['userId'])) {
            $sgl = 'SELECT * FROM ' . $this->table . ' WHERE `id` = :id';

            $user = $this->db->query($sgl, ['id' => $_COOKIE['userId']]);
            return $user->fetch(\PDO::FETCH_ASSOC);
        }
        return '';
    }

    public static function isAuthorized()
    {
        return !!($_COOKIE['userId'] ?? false);
    }
}