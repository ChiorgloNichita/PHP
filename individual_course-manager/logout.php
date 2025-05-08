<?php
/**
 * Выход из системы.
 *
 * Удаляет auth_token из cookies и перенаправляет пользователя на страницу входа.
 *
 * @package CourseManager
 */

setcookie('auth_token', '', time() - 3600, '/');
header('Location: login.php');
exit;
