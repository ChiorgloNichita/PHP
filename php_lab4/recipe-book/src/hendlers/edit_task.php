<?php

// Получаем данные из формы
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Валидация данных
if (empty($title) || empty($description)) {
    echo "Название и описание задачи обязательны!";
    exit;
}

// Читаем задачи из файла
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

// Обновляем задачу
$tasks[$id] = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => $tasks[$id]['created_at'],  // оставляем дату создания без изменений
];

// Сохраняем обновленные данные в файл
file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

// Перенаправляем на главную страницу
header('Location: /public/index.php');
exit;