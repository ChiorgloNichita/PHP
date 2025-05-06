<?php
require_once __DIR__ . '/../db/education.php';

// Получаем токен из cookies
$token = $_COOKIE['auth_token'] ?? null;

// Проверяем, если токен существует, то извлекаем данные пользователя из базы
if ($token) {
    // Получаем пользователя по токену
    $stmt = $authPdo->prepare("SELECT * FROM users WHERE token = ?");
    $stmt->execute([$token]);
    $user = $stmt->fetch();

    // Если токен совпадает с пользователем и роль администратора
    if ($user && $user['role'] === 'admin') {
        // Логика добавления курса
        $title = trim($_POST['title'] ?? '');
        $description = trim($_POST['description'] ?? '');

        if ($title) {
            $stmt = $eduPdo->prepare("INSERT INTO courses (title, description) VALUES (?, ?)");
            $stmt->execute([$title, $description]);

            // Логирование действия
            logAction("Добавлен курс: $title");
        }
        header("Location: ../index.php");
    } else {
        header("Location: login.php"); // Если не администратор, перенаправляем на страницу входа
        exit;
    }
} else {
    header("Location: login.php"); // Если нет токена, перенаправляем на страницу входа
    exit;
}
?>
