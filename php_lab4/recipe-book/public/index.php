<?php
require_once '../src/helpers.php';

$recipes = loadRecipes();
$latestRecipes = array_slice($recipes, -2);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Каталог рецептов</title>
</head>
<body>
    <h1>Последние рецепты</h1>
    <?php foreach ($latestRecipes as $recipe): ?>
        <h2><?= htmlspecialchars($recipe['title']) ?></h2>
        <p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
        <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
        <hr>
    <?php endforeach; ?>
    <a href="recipe/index.php">Посмотреть все рецепты</a>
</body>
</html>
