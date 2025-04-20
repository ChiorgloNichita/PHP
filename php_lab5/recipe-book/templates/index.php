<?php
$pdo = getPDO();
$page = max(1, (int)($_GET['page'] ?? 1));
$perPage = 5;
$offset = ($page - 1) * $perPage;

$total = $pdo->query("SELECT COUNT(*) FROM recipes")->fetchColumn();
$pages = ceil($total / $perPage);

$recipes = $pdo->query("SELECT r.*, c.name as category_name FROM recipes r JOIN categories c ON r.category = c.id ORDER BY r.created_at DESC LIMIT $perPage OFFSET $offset")->fetchAll();
?>

<h2>Список рецептов</h2>
<ul>
<?php foreach ($recipes as $r): ?>
    <li>
        <strong><?= htmlspecialchars($r['title']) ?></strong> (<?= htmlspecialchars($r['category_name']) ?>)
        <a href="?page=show&id=<?= $r['id'] ?>">Открыть</a> |
        <a href="?page=edit&id=<?= $r['id'] ?>">Редактировать</a> |
        <a href="/recipe-book/src/handlers/recipe/delete.php?id=<?= $r['id'] ?>" onclick="return confirm('Удалить рецепт?')">Удалить</a>
    </li>
<?php endforeach; ?>
</ul>

<?php for ($i = 1; $i <= $pages; $i++): ?>
    <a href="?page=index&page=<?= $i ?>"><?= $i ?></a>
<?php endfor; ?>
