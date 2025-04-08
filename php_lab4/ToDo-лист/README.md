```markdown 
#  ToDo-лист (Список задач)
```

##  Описание

Веб-приложение на PHP для управления задачами: добавление, редактирование, просмотр и хранение задач в JSON-файле. Проект разработан в рамках **Лабораторной работы №4: Обработка и валидация форм в PHP**.

## Цель работы
Освоить основные принципы работы с HTML-формами в PHP, включая отправку данных на сервер и их обработку, включая валидацию данных.
Данная работа станет основой для дальнейшего изучения разработки веб-приложений. Дальнейшие лабораторные работы будут основываться на данной.

##  Структура проекта
```
recipe-book/
├── public/
│   ├── css/
│   │   └── style.css                  # Стилизация интерфейса
│   ├── task/
│   │   ├── create.php                 # HTML-форма создания задачи
│   │   ├── create_handler.php         # Прокси к src/handlers/create_handler.php
│   │   ├── edit.php                   # HTML-форма редактирования задачи
│   │   ├── edit_handler.php           # Прокси к src/handlers/edit_handler.php
│   │   ├── view.php                   # Просмотр задачи
│   │   └── index.php                  # Главная страница с задачами
│
├── src/
│   └── handlers/
│       ├── create_handler.php         # Обработка и сохранение новой задачи
│       ├── create_task.php            # Альтернативный вариант логики добавления
│       ├── edit_handler.php           # Обработка редактирования задачи
│       ├── edit_task.php              # Альтернативный вариант логики редактирования
│       └── helpers.php                # Вспомогательные функции
│
├── storage/
│   └── tasks.json                     # JSON-хранилище всех задач
│
└── README.md                          # Описание проекта

```

## 1. public/task/create_handler.php
**Файл-прокси для обработки формы создания.**
Просто подключает `src/handlers/create_handler.php`, который содержит логику обработки.

```php 
<?php
/**
 * Прокси-файл для обработки формы создания новой задачи.
 *
 * Подключает основной обработчик из src/handlers/create_handler.php,
 * который выполняет фильтрацию, валидацию и сохранение данных в файл.
 */
require __DIR__ . '/../../src/handlers/create_handler.php';
```


## 2. public/task/create.php
**Страница HTML-формы для создания задачи.**
Форма отправляет POST-запрос в `create_handler.php`. Валидация проводится на стороне сервера.

```html
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

    <form action="/task/create_handler.php" method="POST">
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
```

---

## 3. public/task/edit_handler.php
**Прокси-файл для формы редактирования.**
Вызывает основной обработчик `src/handlers/edit_handler.php`.

```php
<?php
/**
 * Прокси-файл для обработки формы редактирования задачи.
 *
 * Подключает основной обработчик из src/handlers/edit_handler.php,
 * который выполняет валидацию, обновление данных и сохранение.
 * Используется как action-цель в форме редактирования.
 */
require __DIR__ . '/../../src/handlers/edit_handler.php';
```

---


---

## 4. public/task/edit.php
**Страница HTML-формы редактирования.**
Загружает задачу по `title`, подставляет данные в форму.

```php
<?php
/**
 * Страница редактирования задачи.
 *
 * Получает название задачи из GET-параметра (?id=...),
 * находит соответствующую задачу в файле tasks.json
 * и отображает HTML-форму с предзаполненными значениями.
 */

// Проверяем, передан ли параметр id
if (!isset($_GET['id'])) {
    die("Параметр 'id' не передан в URL.");
}

// Получаем значение параметра id (в текущей реализации — это title)
$taskTitle = $_GET['id'];

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверка существования файла с задачами
if (!file_exists($filePath)) {
    die("Файл с задачами не найден.");
}

// Чтение и декодирование задач
$tasks = json_decode(file_get_contents($filePath), true);

// Поиск задачи по названию
$taskToEdit = null;
foreach ($tasks as $task) {
    if ($task['title'] === $taskTitle) {
        $taskToEdit = $task;
        break; // Прерываем цикл после нахождения
    }
}

// Если задача не найдена — выводим ошибку
if (!$taskToEdit) {
    die("Задача не найдена: " . htmlspecialchars($taskTitle));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Редактировать задачу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Редактирование задачи: <?= htmlspecialchars($taskToEdit['title']) ?></h1>

    <!-- Форма для редактирования задачи -->
    <form action="/task/edit_handler.php" method="POST">

        <!-- Название задачи -->
        <label for="title">Название задачи</label>
        <input type="text" id="title" name="title" value="<?= htmlspecialchars($taskToEdit['title']) ?>" required>

        <!-- Описание задачи -->
        <label for="description">Описание</label>
        <textarea id="description" name="description" required><?= htmlspecialchars($taskToEdit['description']) ?></textarea>

        <!-- Приоритет -->
        <label for="priority">Приоритет</label>
        <select id="priority" name="priority">
            <option value="low" <?= $taskToEdit['priority'] === 'low' ? 'selected' : '' ?>>Низкий</option>
            <option value="medium" <?= $taskToEdit['priority'] === 'medium' ? 'selected' : '' ?>>Средний</option>
            <option value="high" <?= $taskToEdit['priority'] === 'high' ? 'selected' : '' ?>>Высокий</option>
        </select>

        <!-- Статус -->
        <label for="status">Статус</label>
        <select id="status" name="status">
            <option value="not_done" <?= $taskToEdit['status'] === 'not_done' ? 'selected' : '' ?>>Не выполнено</option>
            <option value="done" <?= $taskToEdit['status'] === 'done' ? 'selected' : '' ?>>Выполнено</option>
        </select>

        <!-- Скрытое поле для передачи старого названия задачи -->
        <input type="hidden" name="old_title" value="<?= htmlspecialchars($taskToEdit['title']) ?>">

        <!-- Кнопка отправки формы -->
        <button type="submit">Сохранить изменения</button>
    </form>
</body>
</html>
```
---

## 5. public/task/view.php
**Страница просмотра задачи.**
Ищет задачу по `title` и выводит ее описание, статус, дату создания.
```php
<?php
/**
 * Страница просмотра задачи.
 *
 * Получает название задачи из GET-параметра `id`,
 * находит соответствующую задачу в файле tasks.json
 * и отображает подробную информацию о ней.
 */

// Получаем данные из GET-запроса
if (!isset($_GET['id'])) {
    die("Параметр 'id' не передан в URL.");
}

// Название задачи (используется как идентификатор в текущей реализации)
$taskTitle = $_GET['id'];

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверяем, существует ли файл
if (!file_exists($filePath)) {
    die("Файл с задачами не найден.");
}

// Читаем задачи из файла
$tasks = json_decode(file_get_contents($filePath), true);

// Ищем задачу по названию
$taskToView = null;
foreach ($tasks as $task) {
    if ($task['title'] === $taskTitle) {
        $taskToView = $task;
        break; // Прерываем цикл после нахождения нужной задачи
    }
}

// Если задача не найдена — выводим сообщение
if (!$taskToView) {
    die("Задача не найдена: " . htmlspecialchars($taskTitle));
}
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="/css/style.css">
</head>

<body>
    <h1>Просмотр задачи: <?= htmlspecialchars($taskToView['title']) ?></h1>

    <!-- Отображение информации о задаче -->
    <p><strong>Описание:</strong> <?= htmlspecialchars($taskToView['description']) ?></p>
    <p><strong>Приоритет:</strong> <?= htmlspecialchars($taskToView['priority']) ?></p>
    <p><strong>Статус:</strong> <?= htmlspecialchars($taskToView['status']) ?></p>
    <p><strong>Дата создания:</strong> <?= htmlspecialchars($taskToView['created_at']) ?></p>

    <br>

    <!-- Кнопка для перехода к редактированию -->
    <a href="/task/edit.php?id=<?= urlencode($taskToView['title']) ?>">Редактировать задачу</a>
    <br>
    <a href="/index.php">Назад к списку задач</a>
</body>
</html>
```
---

## 6. public/task/index.php
**Главная страница списка задач.**
Реализована пагинация, выводится по 5 задач на страницу. Есть ссылки на создание, редактирование и просмотр задач.
```php
<?php
/**
 * Главная страница списка задач с постраничным выводом.
 *
 * Загружает задачи из файла, рассчитывает параметры пагинации
 * и отображает таблицу с задачами (по 5 штук на страницу).
 */

// Читаем задачи из файла
$tasks = json_decode(file_get_contents(__DIR__ . '/../storage/tasks.json'), true);

// Проверяем наличие задач
if (!$tasks) {
    die("Задачи не найдены.");
}

// Количество задач, отображаемых на одной странице
$tasksPerPage = 5;

// Получаем номер текущей страницы из GET-параметра ?page=
// Если параметр не указан — используется страница 1
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;

// Убедимся, что номер страницы не меньше 1
$page = $page < 1 ? 1 : $page;

// Вычисляем общее количество задач
$totalTasks = count($tasks);

// Определяем количество страниц (округляем вверх)
$totalPages = ceil($totalTasks / $tasksPerPage);

// Вычисляем индекс начала вывода задач для текущей страницы
$startIndex = ($page - 1) * $tasksPerPage;

// Получаем список задач, которые нужно отобразить на текущей странице
$currentPageTasks = array_slice($tasks, $startIndex, $tasksPerPage);
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Добавить задачу</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
    <h1>Список задач</h1>

    <!-- Таблица со списком задач -->
    <table border="1">
        <tr>
            <th>Название</th>
            <th>Приоритет</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>

        <!-- Выводим задачи на текущей странице -->
        <?php foreach ($currentPageTasks as $task): ?>
            <tr>
                <td><?php echo htmlspecialchars($task['title']); ?></td>
                <td><?php echo htmlspecialchars($task['priority']); ?></td>
                <td><?php echo htmlspecialchars($task['status']); ?></td>
                <td>
                    <!-- Ссылки на просмотр и редактирование задачи -->
                    <a href="task/view.php?id=<?php echo urlencode($task['title']); ?>">Просмотр</a>
                    <a href="task/edit.php?id=<?php echo urlencode($task['title']); ?>">Редактировать</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </table>

    <br>

    <!-- Пагинация -->
    <div>
        <?php if ($page > 1): ?>
            <a href="/public/index.php?page=<?php echo $page - 1; ?>">Предыдущая</a>
        <?php endif; ?>

        <span>Страница <?php echo $page; ?> из <?php echo $totalPages; ?></span>

        <?php if ($page < $totalPages): ?>
            <a href="/public/index.php?page=<?php echo $page + 1; ?>">Следующая</a>
        <?php endif; ?>
    </div>

    <br>

    <!-- Кнопка добавления новой задачи -->
    <a href="/task/create.php">Добавить задачу</a>
</body>
</html>
```
---

## 7. src/handlers/create_handler.php
**Обработчик для создания задачи.**
Собирает данные из POST, проводит простую валидацию и добавляет задачу в JSON-файл.
```php
<?php

/**
 * Обработчик формы создания новой задачи.
 *
 * Получает данные из POST-запроса, валидирует поля,
 * создаёт структуру задачи и сохраняет её в файл tasks.json.
 */

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Проверяем, существует ли файл, если нет — создаём пустой JSON-массив
if (!file_exists($filePath)) {
    file_put_contents($filePath, json_encode([]));
}

// Получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Проверяем, что обязательные поля заполнены
if (empty($title) || empty($description)) {
    die("Название и описание обязательны для заполнения.");
}

// Создаём новую задачу как ассоциативный массив
$task = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => date('Y-m-d H:i:s') // добавляем дату создания
];

// Читаем текущие задачи из файла
$tasks = json_decode(file_get_contents($filePath), true);

// Добавляем новую задачу в список
$tasks[] = $task;

// Сохраняем обновлённый список обратно в файл
if (file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT)) === false) {
    die("Ошибка записи в файл.");
}

// Перенаправляем пользователя на главную страницу
header('Location: /index.php');
exit;
?>
```
---

## 8. src/handlers/create_task.php
**Альтернативный обработчик создания.**
Похож на create_handler.php, но обрабатывает индексно.
```php
<?php

/**
 * Обработчик формы добавления задачи.
 *
 * Получает данные из POST-запроса, валидирует поля, добавляет задачу
 * в массив и сохраняет его в файл storage/tasks.json.
 */

// Получаем данные из формы
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Валидация обязательных полей: название и описание
if (empty($title) || empty($description)) {
    echo "Название и описание задачи обязательны!";
    exit;
}

// Создание новой задачи
$task = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => date('Y-m-d H:i:s') // текущая дата и время
];

// Чтение существующих задач из файла
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

// Добавление новой задачи в массив
$tasks[] = $task;

// Сохранение обновлённого массива задач обратно в файл
file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

// Перенаправление пользователя на главную страницу
header('Location: /public/index.php');
exit;
```
---

## 9. src/handlers/edit_handler.php
**Обработчик редактирования задачи по title.**
Ищет задачу по `old_title` и заменяет ее данные.
```php
<?php

/**
 * Обработчик редактирования задачи.
 *
 * Получает новые данные из формы (POST), находит задачу по старому названию,
 * обновляет её поля и сохраняет обратно в файл tasks.json.
 */

// Получаем данные из формы
$newTitle = $_POST['title'];
$priority = $_POST['priority'];
$status = $_POST['status'];
$description = $_POST['description'];
$oldTitle = $_POST['old_title'];

// Валидация: проверяем обязательные поля
if (empty($newTitle) || empty($description)) {
    die("Название и описание обязательны для заполнения.");
}

// Путь к файлу с задачами
$filePath = __DIR__ . "/../../storage/tasks.json";

// Чтение задач из файла (если файл есть)
$tasks = file_exists($filePath) ? json_decode(file_get_contents($filePath), true) : [];

// Поиск задачи по старому названию и обновление данных
foreach ($tasks as &$task) {
    if ($task['title'] === $oldTitle) {
        $task['title'] = $newTitle;
        $task['priority'] = $priority;
        $task['status'] = $status;
        $task['description'] = $description;
        $task['created_at'] = date('Y-m-d H:i:s'); // Обновляем дату
        break;
    }
}
unset($task); // Завершаем ссылку на последний элемент

// Сохраняем задачи обратно в файл
file_put_contents($filePath, json_encode($tasks, JSON_PRETTY_PRINT));

// Перенаправление на главную страницу (ничего не выводим!)
header("Location: /index.php");
exit;
```
---

## 10. src/handlers/edit_task.php
**Обработчик редактирования задачи по ID.**
Использует индекс массива $tasks[$id] для обновления данных.
```php
<?php

/**
 * Обработчик формы редактирования задачи по ID.
 *
 * Получает новые данные из формы, обновляет соответствующую запись
 * в массиве задач и сохраняет его обратно в JSON-файл.
 */

// Получаем данные из формы (POST)
$id = $_POST['id'];
$title = $_POST['title'];
$description = $_POST['description'];
$priority = $_POST['priority'];
$status = $_POST['status'];

// Валидация обязательных полей
if (empty($title) || empty($description)) {
    echo "Название и описание задачи обязательны!";
    exit;
}

// Чтение всех задач из файла JSON
$tasks = json_decode(file_get_contents('../storage/tasks.json'), true);

// Обновление задачи по индексу (id)
$tasks[$id] = [
    'title' => $title,
    'description' => $description,
    'priority' => $priority,
    'status' => $status,
    'created_at' => $tasks[$id]['created_at'], // сохраняем исходную дату создания
];

// Сохранение обновлённого массива задач обратно в файл
file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));

// Редирект на главную страницу после успешного обновления
header('Location: /public/index.php');
exit;
```
---

## 11. src/handlers/helpers.php
**Файл с вспомогательными функциями:**
- `saveTasks()` — сохраняет массив в tasks.json
- `sanitizeInput()` — фильтрует HTML/теги
- `validateRequiredFields()` — проверяет обязательные поля
```php
<?php

/**
 * Сохраняет массив задач в JSON-файл.
 *
 * @param array $tasks Массив задач для сохранения
 * @return void
 */
function saveTasks($tasks) {
    // Сохраняем данные в файл tasks.json в формате JSON с отступами
    file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

/**
 * Очищает ввод пользователя от HTML и PHP-тегов.
 *
 * @param string $data Входная строка
 * @return string Очищенная строка
 */
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

/**
 * Проверяет, что все обязательные поля в массиве заполнены.
 *
 * @param array $data Ассоциативный массив данных (обычно $_POST)
 * @param array $fields Список обязательных полей
 * @return bool Возвращает true, если все поля заполнены, иначе false
 */
function validateRequiredFields($data, $fields) {
    foreach ($fields as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}
```
---

## 12. storage/tasks.json
**JSON-файл хранения задач.**
Каждый объект — это отдельная задача с title, description, priority, status, created_at.
```php
[
    {
        "title": "\u041a\u043b\u0430\u0441\u0441\u0438\u0447\u0435\u0441\u043a\u0438\u0439 \u0443\u043a\u0440\u0430\u0438\u043d\u0441\u043a\u0438\u0439 \u0431\u043e\u0440\u0449.",
        "description": "\u0421\u043c\u0435\u0441\u044c \u0441\u0432\u0435\u043a\u043b\u044b, \u043a\u0430\u043f\u0443\u0441\u0442\u044b \u0438 \u0447\u0435\u0441\u043d\u043e\u043a\u0430.",
        "priority": "high",
        "status": "not_done",
        "created_at": "2025-04-08 18:27:51"
    },
    {
        "title": "\u0426\u0435\u0437\u0430\u0440\u044c",
        "description": "\u041a\u0443\u0440\u0438\u0446\u0430, \u043a\u0430\u043f\u0443\u0441\u0442\u0430, \u0441\u043e\u0443\u0441 \u043c\u0430\u0439\u043e\u043d\u0435\u0437\u043d\u044b\u0439",
        "priority": "high",
        "status": "done",
        "created_at": "2025-04-05 22:07:54"
    },
    {
        "title": "\u041a\u0443\u043f\u0438\u0442\u044c \u043f\u04415",
        "description": "\u0417\u0430\u0432\u0442\u0440\u0430 \u043d\u0443\u0436\u043d\u043e \u043a\u0443\u043f\u0438\u0442\u044c \u0432 \u0431\u043e\u043c\u0431\u0435",
        "priority": "high",
        "status": "not_done",
        "created_at": "2025-04-05 22:28:12"
    },
    {
        "title": "\u041f\u043e\u0439\u0442\u0438 \u043d\u0430 \u0442\u0440\u0435\u043d\u0438\u0440\u043e\u0432\u043a\u0443",
        "description": "\u0412 13",
        "priority": "high",
        "status": "not_done",
        "created_at": "2025-04-05 23:17:05"
    },
    {
        "title": "\u0412\u044b\u043f\u043e\u043b\u043d\u0438\u0442\u044c \u043b\u0430\u0431\u0430\u0440\u0430\u0442\u043e\u0440\u043d\u0443\u044e \u043f\u043e PHP",
        "description": "\u0411\u0443\u0434\u0435\u0442 \u0441\u0434\u0435\u043b\u0430\u043d\u043e \u0432\u0441\u0435\u0433\u0434\u0430 \u0432\u043e\u0432\u0440\u0435\u043c\u044f",
        "priority": "high",
        "status": "done",
        "created_at": "2025-04-08 16:00:40"
    },
    {
        "title": "ececr",
        "description": "rvrvr",
        "priority": "high",
        "status": "not_done",
        "created_at": "2025-04-05 23:17:57"
    }
]
```
###  **1. Какие методы HTTP применяются для отправки данных формы?**

Для отправки данных формы в HTML используются **два основных HTTP-метода**:

- **GET** — данные передаются через URL (например: `?name=Задача`).  
  🔹 Применяется для поиска, фильтрации, когда данные не чувствительные.  
  🔹 Ограничен по длине URL.

- **POST** — данные отправляются **в теле запроса**, не отображаются в адресной строке.  
 В HTML это задаётся так:

```html
<form action="..." method="POST">
```

###  **2. Что такое валидация данных, и чем она отличается от фильтрации?**

##  Что такое валидация и фильтрация данных, и в чём разница?

###  Валидация данных

**Валидация** — это проверка, соответствуют ли введённые пользователем данные ожидаемым требованиям.

Например:
- Поле не должно быть пустым.
- Значение должно быть числом.
- Email должен быть в правильном формате.

###  Фильтрация данных

**Фильтрация** — это очистка данных от лишнего или потенциально вредного содержимого (например, HTML-тегов, скриптов).

Цель фильтрации — обезопасить данные перед сохранением или выводом на страницу.

###  В чём разница?

| Функция   | Описание                               | 
|-----------|----------------------------------------|
| Валидация | Проверяет, правильны ли данные         |             
| Фильтрация| Очищает данные от опасного содержимого |         

###  **3. Какие функции PHP используются для фильтрации данных?**

Вот самые популярные функции фильтрации в PHP:

| Функция                  | Назначение                                                  |
|--------------------------|-------------------------------------------------------------|
| `strip_tags($str)`       | Удаляет HTML и PHP теги из строки                           |
| `htmlspecialchars($str)` | Преобразует спецсимволы (например `<` в `&lt;`)             |
| `filter_var($var, ...)`  | Универсальный фильтр, можно фильтровать email, URL и др.    |
| `trim($str)`             | Убирает пробелы в начале и в конце строки                   |
