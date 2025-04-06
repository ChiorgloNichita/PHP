<?php
require_once '../../src/helpers.php';

$recipes = loadRecipes();
$page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
$perPage = 5;
$total = count($recipes);
$pages = ceil($total / $perPage);
$offset = ($page - 1) * $perPage;

$recipesOnPage = array_slice($recipes, $offset, $perPage);
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Все рецепты</title>
</head>
<body>
    <h1>Все рецепты (страница <?= $page ?>)</h1>

    <?php foreach ($recipesOnPage as $recipe): ?>
        <h2><?= htmlspecialchars($recipe['title']) ?></h2>
        <p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
        <p><?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
        <hr>
    <?php endforeach; ?>

    <div>
        <?php for ($i = 1; $i <= $pages; $i++): ?>
            <a href="?page=<?= $i ?>"><?= $i ?></a>
        <?php endfor; ?>
    </div>
</body>
</html>
