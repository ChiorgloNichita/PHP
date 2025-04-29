<?php
/**
 * Создаёт и возвращает экземпляр PDO для подключения к базе данных.
 *
 * Использует параметры подключения из файла конфигурации config/db.php.
 * Подключение настраивается с режимом ошибок "Исключения" и 
 * ассоциативным режимом выборки по умолчанию.
 *
 * @return PDO Экземпляр подключения к базе данных
 *
 * @throws PDOException В случае ошибки подключения к базе данных
 */

function getPDO(): PDO
{
    $config = require __DIR__ . '/../config/db.php';
    $dsn = "mysql:host={$config['host']};dbname={$config['dbname']};charset=utf8mb4";

    return new PDO($dsn, $config['user'], $config['password'], [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
    ]);
}
