<?php
/**
 * Шаблон страницы просмотра задачи.
 *
 * Выполняет:
 * - Получение ID задачи из GET-запроса
 * - Загрузку данных задачи из базы данных
 * - Отображение детальной информации о задаче (название, описание, приоритет, статус)
 * - Предоставляет ссылку для возврата к списку задач
 *
 * @package ToDoList\Templates\Task
 */

$pdo = getPDO();

// Получение ID задачи из запроса
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID задачи не указан.");
}

// Загрузка задачи из базы данных
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    die("Задача не найдена.");
}
?>

<h2><?= htmlspecialchars($task['title']) ?></h2>

<p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($task['description'])) ?></p>
<p><strong>Приоритет:</strong> <?= htmlspecialchars($task['priority']) ?></p>
<p><strong>Статус:</strong> <?= htmlspecialchars($task['status']) ?></p>

<a href="/todo-list/public/?page=index">← Назад к списку</a>
