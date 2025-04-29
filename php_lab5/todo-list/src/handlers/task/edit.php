<?php
/**
 * Обработчик редактирования задачи в базе данных.
 *
 * Выполняет:
 * - Получение ID задачи из GET-запроса
 * - Получение новых данных задачи из POST-запроса
 * - Валидацию обязательного поля "Название"
 * - Обновление записи в таблице tasks
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

// Получение данных задачи из POST-запроса
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$priority = $_POST['priority'] ?? 'Средний';
$status = $_POST['status'] ?? 'Не выполнено';

// Проверка обязательного поля "Название задачи"
if (trim($title) === '') {
    die('Название задачи обязательно.');
}

// Подготовка и выполнение SQL-запроса на обновление задачи
$stmt = $pdo->prepare("UPDATE tasks SET title = ?, description = ?, priority = ?, status = ? WHERE id = ?");
$stmt->execute([$title, $description, $priority, $status, $id]);

// Перенаправление на главную страницу списка задач
header('Location: /todo-list/public/?page=index');
exit;
