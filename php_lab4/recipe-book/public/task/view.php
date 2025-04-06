<?php
// Получаем данные из GET-запроса
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
$taskToView = null;
foreach ($tasks as $task) {
    if ($task['title'] === $taskTitle) {
        $taskToView = $task;
        break; // Прерываем цикл, как только задача найдена
    }
}

// Если задача не найдена, выводим ошибку
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
    <link rel="stylesheet" href="../css/style.css">
</head>

<body>
    <h1>Просмотр задачи: <?php echo htmlspecialchars($taskToView['title']); ?></h1>

    <p><strong>Описание:</strong> <?php echo htmlspecialchars($taskToView['description']); ?></p>
    <p><strong>Приоритет:</strong> <?php echo htmlspecialchars($taskToView['priority']); ?></p>
    <p><strong>Статус:</strong> <?php echo htmlspecialchars($taskToView['status']); ?></p>
    <p><strong>Дата создания:</strong> <?php echo htmlspecialchars($taskToView['created_at']); ?></p>

    <br>
    <a href="edit.php?id=<?php echo urlencode($taskToView['title']); ?>">Редактировать задачу</a>
    <br>
    <a href="/public/index.php">Назад к списку задач</a>
</body>
</html>
