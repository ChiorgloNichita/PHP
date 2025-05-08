<?php
require_once __DIR__ . '/../db/education.php';

/**
 * Проверка наличия токена в cookies.
 * Если токен не найден — перенаправляем пользователя на страницу входа.
 */
if (!isset($_COOKIE['auth_token'])) {
    header('Location: /login.php');
    exit;
}

$token = $_COOKIE['auth_token'];

/**
 * Подготавливаем SQL-запрос для поиска пользователя по токену.
 * Используем безопасный метод через prepare + execute.
 */
$stmt = $authPdo->prepare("SELECT * FROM users WHERE token = ?");
$stmt->execute([$token]);

/**
 * Извлекаем пользователя из результата запроса.
 * Если пользователь не найден — удаляем токен и отправляем на login.php.
 */
$user = $stmt->fetch();
if (!$user) {
    setcookie('auth_token', '', time() - 3600, '/'); // удаляем токен
    header('Location: /login.php');
    exit;
}

// Сохраняем данные авторизованного пользователя в глобальную переменную
$GLOBALS['auth_user'] = $user;

/**
 * Проверяет, авторизован ли пользователь.
 *
 * @return bool true — если пользователь вошёл, иначе false.
 */
function isLoggedIn(): bool {
    return isset($GLOBALS['auth_user']);
}

/**
 * Проверяет, является ли пользователь администратором.
 *
 * @return bool true — если у пользователя роль admin, иначе false.
 */
function isAdmin(): bool {
    return isset($GLOBALS['auth_user']['role']) && $GLOBALS['auth_user']['role'] === 'admin';
}
?>
