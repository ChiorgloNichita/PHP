<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить рецепт</title>
</head>
<body>
    <h1>Добавление рецепта</h1>
    <form action="../../src/handlers/handle_form.php" method="post">
        <label>Название:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Категория:</label><br>
        <select name="category" required>
            <option value="">Выберите категорию</option>
            <option value="Супы">Супы</option>
            <option value="Салаты">Салаты</option>
            <option value="Десерты">Десерты</option>
        </select><br><br>

        <label>Ингредиенты:</label><br>
        <textarea name="ingredients" required></textarea><br><br>

        <label>Описание:</label><br>
        <textarea name="description" required></textarea><br><br>

        <label>Теги:</label><br>
        <select name="tags[]" multiple>
            <option value="быстро">быстро</option>
            <option value="вкусно">вкусно</option>
            <option value="полезно">полезно</option>
        </select><br><br>

        <label>Шаги приготовления:</label><br>
        <textarea name="steps" required></textarea><br><br>

        <button type="submit">Сохранить</button>
    </form>
</body>
</html>
