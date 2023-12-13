<?php

namespace application\models;

use application\core\Model;

class Task extends Model
{
    public $table = 'tasks';

    public $fillable = [
        'user_id',
        'description',
        'status'
    ];

    protected function insert()
    {
        $sql = 'INSERT INTO ' . $this->table . '(user_id, description, status) VALUES (:user_id, :description, :status)';
        $this->db->query($sql, $this->fillable);
    }

    public function create($data)
    {
        if (!empty($data)) {
            $this->fillable = $data;
            $this->insert();
        } else {
            die('Передан пустой массив');
        }
    }

    public function deleteTask($taskId, $userId)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE user_id = :userId AND id = :id';
        $this->db->query($sql, ['id' => $taskId, 'userId' => (int)$userId]);
    }

    public function deleteTasksAll($userId)
    {
        $sql = 'DELETE FROM ' . $this->table . ' WHERE user_id = :userId';
        $this->db->query($sql, ['userId' => (int)$userId]);
    }

    public function getStatus($taskId, $userId)
    {
        $sql = 'SELECT * FROM ' . $this->table . ' WHERE user_id = :userId AND id = :id';
        return $this->db->fetch($sql, ['id' => $taskId, 'userId' => (int)$userId]);
    }

    public function readyUnreadyTask($taskId, $userId, $status)
    {
        $sql = 'UPDATE ' . $this->table . ' SET status = ' . $status . ' WHERE user_id = :userId AND id = :id';
        $this->db->query($sql, ['id' => $taskId, 'userId' => (int)$userId]);
    }

    public function readyTasksAll($userId)
    {
        $sql = 'UPDATE ' . $this->table . ' SET status = 1 WHERE user_id = :userId';
        $this->db->query($sql, ['userId' => (int)$userId]);
    }

    public function getTask($id)
    {
        if (isset($id)) {
            $sgl = 'SELECT * FROM ' . $this->table . ' WHERE `user_id` = :id';

            return $this->db->row($sgl, ['id' => $id]);
        }
        return '';
    }
}