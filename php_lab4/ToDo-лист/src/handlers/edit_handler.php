<?php

/**
 * Обработчик редактирования задачи.
 *
 * Получает новые данные из формы (POST), находит задачу по старому названию,
 * обновляет её поля и сохраняет обратно в файл tasks.json.
 */

// Получаем данные из формы
$newTitle = $_POST['title'];
$priority = $_POST['priority'];
$status = $_POST['status'];
$description = $_POST['description'];
$oldTitle = $_POST['old_title'];

// Валидация: проверяем обязательные поля
if (empty($newTitle) || empty($description)) {
    die("Название и описание обязательны для заполнения.");
}

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Чтение задач из файла (если файл есть)
$tasks = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

// Поиск задачи по старому названию и обновление данных
foreach ($tasks as &$task) {
    if ($task['title'] === $oldTitle) {
        $task['title'] = $newTitle;
        $task['priority'] = $priority;
        $task['status'] = $status;
        $task['description'] = $description;
        $task['created_at'] = date('Y-m-d H:i:s'); // Обновляем дату
        break;
    }
}
unset($task); // Завершаем ссылку на последний элемент

// Сохраняем задачи обратно в файл
file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT));

// Перенаправление на главную страницу (ничего не выводим!)
header("Location: /index.php");
exit;
