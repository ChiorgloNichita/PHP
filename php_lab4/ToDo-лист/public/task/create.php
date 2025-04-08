    <!DOCTYPE html>
    <html lang="ru">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Добавить задачу</title>
        <link rel="stylesheet" href="/css/style.css">

    </head>
    <body>
        <h1>Добавить новую задачу</h1>

        <!-- 
            HTML-форма для добавления новой задачи.
            Данные отправляются методом POST в create_handler.php.
            Поля: название, описание, приоритет и статус.
        -->
        <form action="/task/create_handler.php" method="POST">

            <!-- Название задачи (обязательное поле) -->
            <label for="title">Название задачи:</label>
            <input type="text" id="title" name="title" required><br><br>

            <!-- Описание задачи (обязательное поле) -->
            <label for="description">Описание:</label>
            <textarea id="description" name="description" required></textarea><br><br>

            <!-- Приоритет задачи -->
            <label for="priority">Приоритет:</label>
            <select id="priority" name="priority">
                <option value="high">Высокий</option>
                <option value="medium">Средний</option>
                <option value="low">Низкий</option>
            </select><br><br>

            <!-- Статус выполнения задачи -->
            <label for="status">Статус:</label>
            <select id="status" name="status">
                <option value="not_done">Не выполнено</option>
                <option value="done">Выполнено</option>
            </select><br><br>

            <!-- Кнопка для отправки формы -->
            <button type="submit">Добавить задачу</button>
        </form>
    </body>
    </html>
