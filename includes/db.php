<?php


function db(): PDO {
    static $conn = null;
    if ($conn !== null) {
        return $conn;
    }

    $host = 'localhost';
    $user = 'root';
    $pass = '';
    $name = 'gestion_stage';

    $dsn = "mysql:host={$host};dbname={$name};charset=utf8mb4";

    $options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES => false,
    ];

    $conn = new PDO($dsn, $user, $pass, $options);
    return $conn;
}

