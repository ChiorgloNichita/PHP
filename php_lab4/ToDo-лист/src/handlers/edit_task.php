<?php

/**
 * Обработчик формы редактирования задачи по ID.
 *
 * Получает новые данные из формы, обновляет соответствующую запись
 * в массиве задач и сохраняет его обратно в JSON-файл.
 */

// Получаем данные из формы (POST)
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Валидация обязательных полей
if (empty($title) || empty($description)) {
    echo "Название и описание задачи обязательны!";
    exit;
}

// Чтение всех задач из файла JSON
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

// Обновление задачи по индексу (id)
$tasks[$id] = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => $tasks[$id]['created_at'], // сохраняем исходную дату создания
];

// Сохранение обновлённого массива задач обратно в файл
file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

// Редирект на главную страницу после успешного обновления
header('Location: /public/index.php');
exit;
