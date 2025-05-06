<?php
// Основная БД для курсов
$eduPdo = new PDO("mysql:host=localhost;dbname=education;charset=utf8", "root", "");
$eduPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

// Вторая БД — для авторизации и логов
$authPdo = new PDO("mysql:host=localhost;dbname=logs;charset=utf8", "root", "");
$authPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
