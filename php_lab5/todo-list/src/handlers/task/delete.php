<?php
/**
 * Обработчик удаления задачи из базы данных.
 *
 * Выполняет:
 * - Получение ID задачи из GET-запроса
 * - Проверку наличия ID
 * - Удаление задачи из таблицы tasks по ID
 * - Перенаправление пользователя обратно на список задач
 *
 * @package ToDoList\Handlers\Task
 */

require_once __DIR__ . '/../../db.php';

$pdo = getPDO();

// Получение ID задачи из GET-запроса
$id = $_GET['id'] ?? null;
if (!$id) {
    die('ID задачи не указан.');
}

// Подготовка и выполнение SQL-запроса на удаление задачи
$stmt = $pdo->prepare("DELETE FROM tasks WHERE id = ?");
$stmt->execute([$id]);

// Перенаправление на главную страницу списка задач
header('Location: /todo-list/public/?page=index');
exit;
