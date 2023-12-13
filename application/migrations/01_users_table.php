<?php

$config = require '../config/db.php';

$dsn = "mysql:host=$config[host]; dbname=$config[name];charset=$config[charset]";
$opt = [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    PDO::ATTR_EMULATE_PREPARES => false,
];

$pdo = new PDO($dsn, $config['user'], $config['password'], $opt);

$sql = 'CREATE table IF NOT EXISTS users (
    id INT PRIMARY KEY  AUTO_INCREMENT,
    login VARCHAR(100) NOT NULL,
    password VARCHAR(100) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP)
    ';

$pdo->exec($sql);