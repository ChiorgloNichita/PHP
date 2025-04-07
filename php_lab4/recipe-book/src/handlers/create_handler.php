<?php
// Путь к файлу с задачами (попробуйте использовать абсолютный путь)
$filePath = __DIR__ . "/../../storage/tasks.json"; // Абсолютный путь

// Проверяем, существует ли файл, если нет — создаём его
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([])); // создаем пустой файл
}

// Получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Проверяем, что все данные переданы
if (empty($title) || empty($description)) {
    die("Название и описание обязательны для заполнения.");
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
$tasks = json_decode(file_get_contents($filePath), true);

// Добавляем новую задачу в массив
$tasks[] = $task;

// Сохраняем обновленный массив задач обратно в файл
if (file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT)) === false) {
    die("Ошибка записи в файл.");
}

// Перенаправляем на страницу списка задач
header('Location: /public/index.php');
exit;
?>