<?php
/**
 * Обработчик добавления новой задачи в базу данных.
 *
 * Выполняет:
 * - Получение данных из POST-запроса (название, описание, приоритет, статус)
 * - Валидацию обязательных полей
 * - Добавление новой записи в таблицу tasks
 * - Перенаправление пользователя обратно на список задач
 *
 * @package ToDoList\Handlers\Task
 */

require_once __DIR__ . '/../../db.php';

$pdo = getPDO();

// Получение данных из POST-запроса
$title = $_POST['title'] ?? '';
$description = $_POST['description'] ?? '';
$priority = $_POST['priority'] ?? 'Средний';
$status = $_POST['status'] ?? 'Не выполнено';

// Проверка обязательного поля "Название задачи"
if (trim($title) === '') {
    die('Название задачи обязательно.');
}

// Подготовка и выполнение SQL-запроса на добавление новой задачи
$stmt = $pdo->prepare("INSERT INTO tasks (title, description, priority, status) VALUES (?, ?, ?, ?)");
$stmt->execute([$title, $description, $priority, $status]);

// Перенаправление на главную страницу списка задач
header('Location: /todo-list/public/?page=index');
exit;
