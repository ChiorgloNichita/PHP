<?php

// Вспомогательные функции
require_once('../helpers.php');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Получаем данные из формы
    $title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
    $category = filter_input(INPUT_POST, 'category', FILTER_SANITIZE_STRING);
    $ingredients = filter_input(INPUT_POST, 'ingredients', FILTER_SANITIZE_STRING);
    $description = filter_input(INPUT_POST, 'description', FILTER_SANITIZE_STRING);
    $tags = $_POST['tags'] ?? [];
    $steps = filter_input(INPUT_POST, 'steps', FILTER_SANITIZE_STRING);

    // Валидация данных
    if (empty($title) || empty($category) || empty($ingredients) || empty($description) || empty($steps)) {
        echo "Все поля обязательны для заполнения!";
        exit;
    }

    // Формируем данные для сохранения
    $formData = [
        'title' => $title,
        'category' => $category,
        'ingredients' => $ingredients,
        'description' => $description,
        'tags' => $tags,
        'steps' => explode("\n", $steps),
    ];

    // Сохраняем данные в файл
    $file = '../storage/recipes.txt';
    file_put_contents($file, json_encode($formData) . PHP_EOL, FILE_APPEND);

    // Перенаправление на главную
    header("Location: ../public/index.php");
    exit;
}

?>
