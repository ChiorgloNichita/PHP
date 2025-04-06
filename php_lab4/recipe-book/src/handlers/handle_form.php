<?php
require_once '../helpers.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = trim($_POST['title'] ?? '');
    $category = trim($_POST['category'] ?? '');
    $ingredients = trim($_POST['ingredients'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $tags = $_POST['tags'] ?? [];
    $steps = trim($_POST['steps'] ?? '');

    $errors = [];

    if ($title === '') $errors['title'] = 'Введите название рецепта';
    if ($category === '') $errors['category'] = 'Выберите категорию';
    if ($ingredients === '') $errors['ingredients'] = 'Введите ингредиенты';
    if ($description === '') $errors['description'] = 'Введите описание';
    if ($steps === '') $errors['steps'] = 'Введите шаги приготовления';

    if (!empty($errors)) {
        // Тут можно реализовать вывод ошибок (например, сессия)
        echo 'Форма содержит ошибки';
        exit;
    }

    $newRecipe = [
        'title' => $title,
        'category' => $category,
        'ingredients' => $ingredients,
        'description' => $description,
        'tags' => $tags,
        'steps' => explode(PHP_EOL, $steps),
        'created_at' => date('Y-m-d H:i:s')
    ];

    saveRecipe($newRecipe);

    header('Location: ../../public/index.php');
    exit;
}
