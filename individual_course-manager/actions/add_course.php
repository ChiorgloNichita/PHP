<?php
/**
 * Обработчик добавления нового курса.
 *
 * Доступен только авторизованному пользователю с ролью "admin".
 * Получает данные из POST-запроса и добавляет курс в базу данных.
 * После успешного добавления — перенаправляет на главную страницу.
 *
 * @package CourseManager
 */

require_once __DIR__ . '/../db/education.php';
require_once __DIR__ . '/../includes/log_action.php'; // не забудь подключить, если используется logAction

// Получаем токен авторизации из cookies
$token = $_COOKIE['auth_token'] ?? null;

if (!$token) {
    header("Location: ../login.php");
    exit;
}

// Получаем пользователя по токену
$stmt = $authPdo->prepare("SELECT * FROM users WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

// Проверка на существование пользователя и его роль
if (!$user || $user['role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Получение данных формы
$title = trim($_POST['title'] ?? '');
$description = trim($_POST['description'] ?? '');

// Если указано название курса — добавляем его
if ($title !== '') {
    $stmt = $eduPdo->prepare("INSERT INTO courses (title, description) VALUES (?, ?)");
    $stmt->execute([$title, $description]);

    // Запись действия в лог
    logAction("Добавлен курс: $title");
}

// Перенаправление после выполнения
header("Location: ../index.php");
exit;
