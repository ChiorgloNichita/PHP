<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Добавить рецепт</title>
</head>
<body>
    <h1>Добавление рецепта</h1>
    <form action="/src/handlers/handler_form.php" method="POST">
        <label>Название рецепта:<br>
            <input type="text" name="title" required>
        </label><br><br>

        <label>Категория:<br>
            <select name="category" required>
                <option value="">Выберите категорию</option>
                <option>Завтрак</option>
                <option>Обед</option>
                <option>Ужин</option>
                <option>Десерт</option>
            </select>
        </label><br><br>

        <label>Ингредиенты:<br>
            <textarea name="ingredients" rows="4" required></textarea>
        </label><br><br>

        <label>Описание:<br>
            <textarea name="description" rows="4" required></textarea>
        </label><br><br>

        <label>Теги:<br>
            <select name="tags[]" multiple>
                <option>Просто</option>
                <option>Быстро</option>
                <option>Вегетарианское</option>
                <option>Острое</option>
            </select>
        </label><br><br>

        <label>Шаги приготовления:<br>
            <textarea name="steps" rows="5"></textarea>
        </label><br><br>

        <button type="submit">Сохранить рецепт</button>
    </form>
</body>
</html>
