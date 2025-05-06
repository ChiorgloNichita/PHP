<?php
require_once __DIR__ . '/../db/education.php';

// Проверка наличия токена в cookies
if (!isset($_COOKIE['auth_token'])) {
    header('Location: /login.php');
    exit;
}

$token = $_COOKIE['auth_token'];
$stmt = $authPdo->prepare("SELECT * FROM users WHERE token = ?");
$stmt->execute([$token]);
$user = $stmt->fetch();

if (!$user) {
    setcookie('auth_token', '', time() - 3600, '/');
    header('Location: /login.php');
    exit;
}

// Функция для проверки роли
function isAdmin() {
    global $user;
    return isset($user['role']) && $user['role'] === 'admin';
}
?>
