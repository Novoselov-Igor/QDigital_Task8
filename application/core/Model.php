<?php

namespace application\core;

use application\lib\Db;

abstract class Model
{
    protected $db;
    protected $table;
    protected $fillable = [];

    public function __construct()
    {
        $this->db = new Db();
    }

    public function create($data)
    {

    }

    protected function insert()
    {
    }
}