<?php
require_once __DIR__ . '/../../db.php';
$pdo = getPDO();

$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID рецепта не указан.");
}

$errors = [];

if (empty($_POST['title'])) {
    $errors[] = "Поле 'Название' обязательно.";
}

if (empty($_POST['category']) || !is_numeric($_POST['category'])) {
    $errors[] = "Выберите корректную категорию.";
} else {
    $stmt = $pdo->prepare("SELECT COUNT(*) FROM categories WHERE id = ?");
    $stmt->execute([$_POST['category']]);
    if ($stmt->fetchColumn() == 0) {
        $errors[] = "Категория не найдена.";
    }
}

if (!empty($errors)) {
    echo "<h3>Ошибка редактирования:</h3><ul>";
    foreach ($errors as $e) {
        echo "<li>" . htmlspecialchars($e) . "</li>";
    }
    echo "</ul><a href='/recipe-book/public/?page=edit&id=$id'>← Назад</a>";
    exit;
}

$stmt = $pdo->prepare("UPDATE recipes SET title = :title, category = :category, ingredients = :ingredients, description = :description, tags = :tags, steps = :steps WHERE id = :id");
$stmt->execute([
    'title' => $_POST['title'],
    'category' => $_POST['category'],
    'ingredients' => $_POST['ingredients'],
    'description' => $_POST['description'],
    'tags' => $_POST['tags'],
    'steps' => $_POST['steps'],
    'id' => $id,
]);

header('Location: /recipe-book/public/?page=index');
exit;
