<?php
// Получаем название задачи из GET-запроса
if (!isset($_GET['id'])) {
    die("Параметр 'id' не передан в URL.");
}

$taskTitle = $_GET['id']; // Название задачи (title) будет использоваться как уникальный идентификатор

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверяем, существует ли файл
if (!file_exists($filePath)) {
    die("Файл с задачами не найден.");
}

// Читаем задачи из файла
$tasks = json_decode(file_get_contents($filePath), true);

// Ищем задачу по названию
$taskToEdit = null;
foreach ($tasks as $task) {
    if ($task['title'] === $taskTitle) {
        $taskToEdit = $task;
        break; // Прерываем цикл, как только задача найдена
    }
}

// Если задача не найдена, выводим ошибку
if (!$taskToEdit) {
    die("Задача не найдена: " . htmlspecialchars($taskTitle));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1>Редактирование задачи: <?php echo htmlspecialchars($taskToEdit['title']); ?></h1>

    <!-- Форма редактирования задачи -->
    <form action="edit_handler.php" method="POST">
        <label for="title">Название задачи</label>
        <input type="text" id="title" name="title" value="<?php echo htmlspecialchars($taskToEdit['title']); ?>" required>

        <label for="description">Описание</label>
        <textarea id="description" name="description" required><?php echo htmlspecialchars($taskToEdit['description']); ?></textarea>

        <label for="priority">Приоритет</label>
        <select id="priority" name="priority">
            <option value="low" <?php echo $taskToEdit['priority'] == 'low' ? 'selected' : ''; ?>>Низкий</option>
            <option value="medium" <?php echo $taskToEdit['priority'] == 'medium' ? 'selected' : ''; ?>>Средний</option>
            <option value="high" <?php echo $taskToEdit['priority'] == 'high' ? 'selected' : ''; ?>>Высокий</option>
        </select>

        <label for="status">Статус</label>
        <select id="status" name="status">
            <option value="not_done" <?php echo $taskToEdit['status'] == 'not_done' ? 'selected' : ''; ?>>Не выполнено</option>
            <option value="done" <?php echo $taskToEdit['status'] == 'done' ? 'selected' : ''; ?>>Выполнено</option>
        </select>

        <input type="hidden" name="old_title" value="<?php echo htmlspecialchars($taskToEdit['title']); ?>">

        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>