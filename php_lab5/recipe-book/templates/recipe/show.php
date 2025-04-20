<?php
$pdo = getPDO();
$id = $_GET['id'] ?? null;
if (!$id) die("Не указан ID");

$stmt = $pdo->prepare("SELECT r.*, c.name as category_name FROM recipes r JOIN categories c ON r.category = c.id WHERE r.id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

if (!$recipe) die("Рецепт не найден.");
?>

<h2><?= htmlspecialchars($recipe['title']) ?></h2>
<p><strong>Категория:</strong> <?= htmlspecialchars($recipe['category_name']) ?></p>
<p><strong>Ингредиенты:</strong> <?= nl2br(htmlspecialchars($recipe['ingredients'])) ?></p>
<p><strong>Описание:</strong> <?= nl2br(htmlspecialchars($recipe['description'])) ?></p>
<p><strong>Теги:</strong> <?= htmlspecialchars($recipe['tags']) ?></p>
<p><strong>Шаги:</strong> <?= nl2br(htmlspecialchars($recipe['steps'])) ?></p>
