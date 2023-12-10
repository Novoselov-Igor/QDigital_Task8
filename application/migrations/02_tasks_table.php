<?php

$config = require '../config/db.php';

$dsn = "mysql:host=$config[host]; dbname=$config[name];charset=$config[charset]";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $config['user'], $config['password'], $opt);

$sql = 'CREATE table IF NOT EXISTS tasks (
    id INT PRIMARY KEY  auto_increment,
    user_id INT REFERENCES users(id),
    description VARCHAR(100) NOT NULL,
    status TINYINT(1) NOT NULL
)';

$pdo->exec($sql);
