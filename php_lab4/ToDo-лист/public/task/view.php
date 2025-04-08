<?php

/**
 * Страница просмотра задачи.
 *
 * Получает название задачи из GET-параметра `id`,
 * находит соответствующую задачу в файле tasks.json
 * и отображает подробную информацию о ней.
 */

// Получаем данные из GET-запроса
if (!isset($_GET['id'])) {
    die("Параметр 'id' не передан в URL.");
}

// Название задачи (используется как идентификатор в текущей реализации)
$taskTitle = $_GET['id'];

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверяем, существует ли файл
if (!file_exists($filePath)) {
    die("Файл с задачами не найден.");
}

// Читаем задачи из файла
$tasks = json_decode(file_get_contents($filePath), true);

// Ищем задачу по названию
$taskToView = null;
foreach ($tasks as $task) {
    if ($task['title'] === $taskTitle) {
        $taskToView = $task;
        break; // Прерываем цикл после нахождения нужной задачи
    }
}

// Если задача не найдена — выводим сообщение
if (!$taskToView) {
    die("Задача не найдена: " . htmlspecialchars($taskTitle));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <h1>Просмотр задачи: <?= htmlspecialchars($taskToView['title']) ?></h1>

    <!-- Отображение информации о задаче -->
    <p><strong>Описание:</strong> <?= htmlspecialchars($taskToView['description']) ?></p>
    <p><strong>Приоритет:</strong> <?= htmlspecialchars($taskToView['priority']) ?></p>
    <p><strong>Статус:</strong> <?= htmlspecialchars($taskToView['status']) ?></p>
    <p><strong>Дата создания:</strong> <?= htmlspecialchars($taskToView['created_at']) ?></p>

    <br>

    <!-- Кнопка для перехода к редактированию -->
    <a href="/task/edit.php?id=<?= urlencode($taskToView['title']) ?>">Редактировать задачу</a>
    <br>
    <a href="/index.php">Назад к списку задач</a>
</body>
</html>
