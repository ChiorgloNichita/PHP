<?php

/**
 * Главная страница списка задач с постраничным выводом.
 *
 * Загружает задачи из файла, рассчитывает параметры пагинации
 * и отображает таблицу с задачами (по 5 штук на страницу).
 */

// Читаем задачи из файла
$tasks = json_decode(file_get_contents(__DIR__ . '/../storage/tasks.json'), true);

// Проверяем наличие задач
if (!$tasks) {
    die("Задачи не найдены.");
}

// Количество задач, отображаемых на одной странице
$tasksPerPage = 5;

// Получаем номер текущей страницы из GET-параметра ?page=
// Если параметр не указан — используется страница 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Убедимся, что номер страницы не меньше 1
$page = $page < 1 ? 1 : $page;

// Вычисляем общее количество задач
$totalTasks = count($tasks);

// Определяем количество страниц (округляем вверх)
$totalPages = ceil($totalTasks / $tasksPerPage);

// Вычисляем индекс начала вывода задач для текущей страницы
$startIndex = ($page - 1) * $tasksPerPage;

// Получаем список задач, которые нужно отобразить на текущей странице
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

    <!-- Таблица со списком задач -->
    <table border="1">
        <tr>
            <th>Название</th>
            <th>Приоритет</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>

        <!-- Выводим задачи на текущей странице -->
        <?php foreach ($currentPageTasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <!-- Ссылки на просмотр и редактирование задачи -->
                    <a href="task/view.php?id=<?php echo urlencode($task['title']); ?>">Просмотр</a>
                    <a href="task/edit.php?id=<?php echo urlencode($task['title']); ?>">Редактировать</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <!-- Пагинация -->
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

    <!-- Кнопка добавления новой задачи -->
    <a href="/task/create.php">Добавить задачу</a>
</body>
</html>
