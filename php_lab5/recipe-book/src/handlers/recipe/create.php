<?php
require_once __DIR__ . '/../../db.php';

$pdo = getPDO();

// Проверка, что обязательные поля заполнены
$errors = [];

if (empty($_POST['title'])) {
    $errors[] = "Поле 'Название' обязательно.";
}

if (empty($_POST['category']) || !is_numeric($_POST['category'])) {
    $errors[] = "Выберите корректную категорию.";
} else {
    // Проверяем, существует ли категория
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE id = ?");
    $stmt->execute([$_POST['category']]);
    if ($stmt->fetchColumn() == 0) {
        $errors[] = "Категория не найдена.";
    }
}

if (!empty($errors)) {
    // Если есть ошибки, покажем их
    echo "<h3>Ошибка добавления рецепта:</h3><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><a href='/recipe-book/public/?page=create'>← Назад</a>";
    exit;
}

// Сохраняем рецепт
$stmt = $pdo->prepare("
    INSERT INTO recipes (title, category, ingredients, description, tags, steps)
    VALUES (:title, :category, :ingredients, :description, :tags, :steps)
");

$stmt->execute([
    'title' => $_POST['title'],
    'category' => $_POST['category'],
    'ingredients' => $_POST['ingredients'] ?? '',
    'description' => $_POST['description'] ?? '',
    'tags' => $_POST['tags'] ?? '',
    'steps' => $_POST['steps'] ?? '',
]);

header('Location: /recipe-book/public/?page=index');
exit;
