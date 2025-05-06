<?php
require_once __DIR__ . '/../includes/auth.php';
require_once __DIR__ . '/../db/education.php';

// Проверка, является ли пользователь администратором
if (!isAdmin()) {
    die("У вас нет прав для удаления записи.");
}

// Получаем ID студента для удаления
$id = $_GET['id'] ?? null;
if (!$id) {
    die('ID студента не передан');
}

// Удаляем студента
$stmt = $eduPdo->prepare("DELETE FROM students WHERE id = ?");
$stmt->execute([$id]);

header('Location: ../students.php'); // Перенаправляем назад
exit;
