<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Добавить новую задачу</h1>
    <form action="create_handler.php" method="POST">
        <label for="title">Название задачи:</label>
        <input type="text" id="title" name="title" required><br><br>

        <label for="description">Описание:</label>
        <textarea id="description" name="description" required></textarea><br><br>

        <label for="priority">Приоритет:</label>
        <select id="priority" name="priority">
            <option value="high">Высокий</option>
            <option value="medium">Средний</option>
            <option value="low">Низкий</option>
        </select><br><br>

        <label for="status">Статус:</label>
        <select id="status" name="status">
            <option value="not_done">Не выполнено</option>
            <option value="done">Выполнено</option>
        </select><br><br>

        <button type="submit">Добавить задачу</button>
    </form>
</body>
</html>

