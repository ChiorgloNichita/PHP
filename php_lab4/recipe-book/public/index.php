<?php
require_once '/../src/helpers.php';

$recipes = loadRecipes();
$latestRecipes = array_slice($recipes, -2);
?>

<h1>Каталог рецептов</h1>

<?php foreach ($latestRecipes as $recipe): ?>
    <h2><?= htmlspecialchars($recipe['title']) ?></h2>
    <p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
    <p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
    <hr>
<?php endforeach; ?>

<p><a href="/recipe/create.php">Добавить рецепт</a></p>
<p><a href="/recipe/index.php">Все рецепты</a></p>
