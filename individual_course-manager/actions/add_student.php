<?php
require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../log_action.php';

// Получаем данные из формы
$name = trim($_POST['name'] ?? '');
$email = trim($_POST['email'] ?? '');

if ($name && $email) {
    // Вставляем студента в базу данных
    $stmt = $eduPdo->prepare("INSERT INTO students (name, email) VALUES (?, ?)");
    $stmt->execute([$name, $email]);
    logAction("Добавлен студент: $name");
}

header("Location: ../pages/students.php");
exit;
