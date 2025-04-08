<?php

/**
 * Обработчик формы добавления задачи.
 *
 * Получает данные из POST-запроса, валидирует поля, добавляет задачу
 * в массив и сохраняет его в файл storage/tasks.json.
 */

// Получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Валидация обязательных полей: название и описание
if (empty($title) || empty($description)) {
    echo "Название и описание задачи обязательны!";
    exit;
}

// Создание новой задачи
$task = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => date('Y-m-d H:i:s') // текущая дата и время
];

// Чтение существующих задач из файла
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

// Добавление новой задачи в массив
$tasks[] = $task;

// Сохранение обновлённого массива задач обратно в файл
file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

// Перенаправление пользователя на главную страницу
header('Location: /public/index.php');
exit;
