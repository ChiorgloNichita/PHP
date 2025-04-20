<?php
$pdo = getPDO();
$categories = $pdo->query("SELECT * FROM categories")->fetchAll();
?>

<h2>Добавить рецепт</h2>
<form method="POST" action="/recipe-book/src/handlers/recipe/create.php">
    <label>Название: <input name="title" required></label><br>
    <label>Категория:
        <select name="category" required>
            <option value="">Выберите...</option>
            <?php foreach ($categories as $c): ?>
                <option value="<?= $c['id'] ?>"><?= htmlspecialchars($c['name']) ?></option>
            <?php endforeach; ?>
        </select>
    </label><br>
    <label>Ингредиенты: <textarea name="ingredients"></textarea></label><br>
    <label>Описание: <textarea name="description"></textarea></label><br>
    <label>Теги: <input name="tags"></label><br>
    <label>Шаги: <textarea name="steps"></textarea></label><br>
    <button type="submit">Сохранить</button>
</form>
