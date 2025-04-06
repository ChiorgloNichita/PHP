<?php
// Читаем задачи из файла
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

if (!$tasks) {
    die("Задачи не найдены.");
}

// Количество задач на одной странице
$tasksPerPage = 5;

// Получаем текущую страницу из GET-параметра, если параметр не передан — используем первую страницу
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Проверяем, чтобы страница была не меньше 1
$page = $page < 1 ? 1 : $page;

// Вычисляем общее количество страниц
$totalTasks = count($tasks);
$totalPages = ceil($totalTasks / $tasksPerPage);

// Вычисляем индекс для начала вывода задач на текущей странице
$startIndex = ($page - 1) * $tasksPerPage;

// Выбираем задачи для текущей страницы
$currentPageTasks = array_slice($tasks, $startIndex, $tasksPerPage);
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
    <h1>Список задач</h1>
    <table border="1">
        <tr>
            <th>Название</th>
            <th>Приоритет</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
        <?php foreach ($currentPageTasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <a href="task/view.php?id=<?php echo urlencode($task['title']); ?>">Просмотр</a>
                    <a href="task/edit.php?id=<?php echo urlencode($task['title']); ?>">Редактировать</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>
    <!-- Навигация по страницам -->
    <div>
        <?php if ($page > 1): ?>
            <a href="/public/index.php?page=<?php echo $page - 1; ?>">Предыдущая</a>
        <?php endif; ?>

        <span>Страница <?php echo $page; ?> из <?php echo $totalPages; ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="/public/index.php?page=<?php echo $page + 1; ?>">Следующая</a>
        <?php endif; ?>
    </div>

    <br>
    <a href="task/create.php">Добавить задачу</a>
</body>
</html>
