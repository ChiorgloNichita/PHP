<?php

/**
 * Обработчик формы создания новой задачи.
 *
 * Получает данные из POST-запроса, валидирует поля,
 * создаёт структуру задачи и сохраняет её в файл tasks.json.
 */

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверяем, существует ли файл, если нет — создаём пустой JSON-массив
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

// Получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Проверяем, что обязательные поля заполнены
if (empty($title) || empty($description)) {
    die("Название и описание обязательны для заполнения.");
}

// Создаём новую задачу как ассоциативный массив
$task = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => date('Y-m-d H:i:s') // добавляем дату создания
];

// Читаем текущие задачи из файла
$tasks = json_decode(file_get_contents($filePath), true);

// Добавляем новую задачу в список
$tasks[] = $task;

// Сохраняем обновлённый список обратно в файл
if (file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT)) === false) {
    die("Ошибка записи в файл.");
}

// Перенаправляем пользователя на главную страницу
header('Location: /index.php');
exit;
?>
