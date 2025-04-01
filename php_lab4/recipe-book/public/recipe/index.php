<?php
require_once __DIR__ . '/../../src/helpers.php';

$recipes = loadRecipes();

// Пагинация
$page = isset($_GET['page']) ? max((int)$_GET['page'], 1) : 1;
$perPage = 5;
$total = count($recipes);
$start = ($page - 1) * $perPage;
$visibleRecipes = array_slice($recipes, $start, $perPage);
$totalPages = ceil($total / $perPage);
?>

<h1>Все рецепты</h1>

<?php foreach ($visibleRecipes as $recipe): ?>
    <h2><?= htmlspecialchars($recipe['title']) ?></h2>
    <p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category']) ?></p>
    <p><strong>Ингредиенты:</strong><br> <?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
    <p><strong>Описание:</strong><br> <?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
    <p><strong>Шаги:</strong></p>
    <ul>
        <?php foreach ($recipe['steps'] as $step): ?>
            <li><?= htmlspecialchars($step) ?></li>
        <?php endforeach; ?>
    </ul>
    <hr>
<?php endforeach; ?>

<!-- Навигация по страницам -->
<div>
    <?php for ($i = 1; $i <= $totalPages; $i++): ?>
        <a href="?page=<?= $i ?>"><?= $i ?></a>
    <?php endfor; ?>
</div>

<p><a href="/index.php">На главную</a></p>