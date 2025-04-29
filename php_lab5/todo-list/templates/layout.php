<?php
/**
 * Основной шаблон (layout) для всех страниц ToDo List.
 *
 * Выполняет:
 * - Подключение глобальных стилей CSS
 * - Отображение заголовка и навигационного меню
 * - Вывод содержимого страницы через переменную $content
 *
 * @package ToDoList\Templates
 */
?>
<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <title>ToDo List</title>
    <link rel="stylesheet" href="/todo-list/public/css/style.css">
</head>
<body>
    <h1>ToDo List</h1>

    <nav>
        <a href="/todo-list/public/?page=index">Главная</a> |
        <a href="/todo-list/public/?page=create">Добавить задачу</a>
    </nav>

    <hr>

    <!-- Динамический вывод контента страницы -->
    <?= $content ?>
</body>
</html>
