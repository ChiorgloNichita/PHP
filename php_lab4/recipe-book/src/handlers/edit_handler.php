<?php
// Получаем данные из формы
$newTitle = $_POST['title'];
$priority = $_POST['priority'];
$status = $_POST['status'];
$description = $_POST['description'];
$oldTitle = $_POST['old_title'];

// Проверяем, что все данные переданы
if (empty($newTitle) || empty($description)) {
    die("Название и описание обязательны для заполнения.");
}

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Чтение задач из файла
if (file_exists($filePath)) {
    $tasks = json_decode(file_get_contents($filePath), true);
} else {
    $tasks = [];
}

// Находим и обновляем задачу
foreach ($tasks as &$task) {
    if ($task['title'] === $oldTitle) {
        $task['title'] = $newTitle;
        $task['priority'] = $priority;
        $task['status'] = $status;
        $task['description'] = $description;
        $task['created_at'] = date('Y-m-d H:i:s'); // обновляем дату создания
        break;
    }
}

// Сохраняем обновленный массив задач обратно в файл
if (file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT)) === false) {
    die("Ошибка записи в файл.");
}

// Перенаправляем на страницу списка задач
header('Location: /public/index.php');
exit;
?>