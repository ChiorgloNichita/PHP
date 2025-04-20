<?php
$pdo = getPDO();
$id = $_GET['id'] ?? null;
if (!$id) die("Не указан ID");

$stmt = $pdo->prepare("SELECT * FROM recipes WHERE id = ?");
$stmt->execute([$id]);
$recipe = $stmt->fetch();

$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<h2>Редактировать рецепт</h2>
<form method="POST" action="/recipe-book/src/handlers/recipe/edit.php?id=<?= $recipe['id'] ?>">
    <label>Название: <input name="title" value="<?= htmlspecialchars($recipe['title']) ?>" required></label><br>
    <label>Категория:
        <select name="category" required>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>" <?= $recipe['category'] == $c['id'] ? 'selected' : '' ?>>
                    <?= htmlspecialchars($c['name']) ?>
                </option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Ингредиенты: <textarea name="ingredients"><?= htmlspecialchars($recipe['ingredients']) ?></textarea></label><br>
    <label>Описание: <textarea name="description"><?= htmlspecialchars($recipe['description']) ?></textarea></label><br>
    <label>Теги: <input name="tags" value="<?= htmlspecialchars($recipe['tags']) ?>"></label><br>
    <label>Шаги: <textarea name="steps"><?= htmlspecialchars($recipe['steps']) ?></textarea></label><br>
    <button type="submit">Сохранить изменения</button>
</form>
