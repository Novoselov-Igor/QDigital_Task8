<?php

namespace application\models;

use application\core\Model;
use mysql_xdevapi\Exception;

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

    private function checkUser()
    {
        $check = $this->hasAccount();
        if ($check->rowCount() <= 0) {
            $this->insert();
        }
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

    public function comparePasswords($password)
    {
        $user = $this->getUser();
        return password_verify($password, $user['password']);
    }

    public function getUser()
    {
        $user = $this->hasAccount();
        return $user->fetch(\PDO::FETCH_ASSOC);
    }

    public function getUserById($id)
    {
        $sgl = 'SELECT * FROM ' . $this->table . ' WHERE `id` = :id';

        $user = $this->db->query($sgl, ['id' => $id]);
        return $user->fetch(\PDO::FETCH_ASSOC);
    }
}