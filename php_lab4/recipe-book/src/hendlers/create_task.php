<?php

// Получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Валидация данных
if (empty($title) || empty($description)) {
    echo "Название и описание задачи обязательны!";
    exit;
}

// Создаем задачу
$task = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => date('Y-m-d H:i:s')
];

// Читаем существующие задачи из файла
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

// Добавляем новую задачу
$tasks[] = $task;

// Сохраняем задачи в файл
file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

// Перенаправляем на главную страницу
header('Location: /public/index.php');
exit;