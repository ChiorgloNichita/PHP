<?php

/**
 * Страница редактирования задачи.
 *
 * Получает название задачи из GET-параметра (?id=...),
 * находит соответствующую задачу в файле tasks.json
 * и отображает HTML-форму с предзаполненными значениями.
 */

// Проверяем, передан ли параметр id
if (!isset($_GET['id'])) {
    die("Параметр 'id' не передан в URL.");
}

// Получаем значение параметра id (в текущей реализации — это title)
$taskTitle = $_GET['id'];

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверка существования файла с задачами
if (!file_exists($filePath)) {
    die("Файл с задачами не найден.");
}

// Чтение и декодирование задач
$tasks = json_decode(file_get_contents($filePath), true);

// Поиск задачи по названию
$taskToEdit = null;
foreach ($tasks as $task) {
    if ($task['title'] === $taskTitle) {
        $taskToEdit = $task;
        break; // Прерываем цикл после нахождения
    }
}

// Если задача не найдена — выводим ошибку
if (!$taskToEdit) {
    die("Задача не найдена: " . htmlspecialchars($taskTitle));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать задачу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Редактирование задачи: <?= htmlspecialchars($taskToEdit['title']) ?></h1>

    <!-- Форма для редактирования задачи -->
    <form action="/task/edit_handler.php" method="POST">

        <!-- Название задачи -->
        <label for="title">Название задачи</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($taskToEdit['title']) ?>" required>

        <!-- Описание задачи -->
        <label for="description">Описание</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($taskToEdit['description']) ?></textarea>

        <!-- Приоритет -->
        <label for="priority">Приоритет</label>
        <select id="priority" name="priority">
            <option value="low" <?= $taskToEdit['priority'] === 'low' ? 'selected' : '' ?>>Низкий</option>
            <option value="medium" <?= $taskToEdit['priority'] === 'medium' ? 'selected' : '' ?>>Средний</option>
            <option value="high" <?= $taskToEdit['priority'] === 'high' ? 'selected' : '' ?>>Высокий</option>
        </select>

        <!-- Статус -->
        <label for="status">Статус</label>
        <select id="status" name="status">
            <option value="not_done" <?= $taskToEdit['status'] === 'not_done' ? 'selected' : '' ?>>Не выполнено</option>
            <option value="done" <?= $taskToEdit['status'] === 'done' ? 'selected' : '' ?>>Выполнено</option>
        </select>

        <!-- Скрытое поле для передачи старого названия задачи -->
        <input type="hidden" name="old_title" value="<?= htmlspecialchars($taskToEdit['title']) ?>">

        <!-- Кнопка отправки формы -->
        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
