<?php
/**
 * Шаблон страницы редактирования задачи.
 *
 * Выполняет:
 * - Получение ID задачи из GET-запроса
 * - Загрузка данных задачи из базы данных
 * - Вывод формы с предзаполненными данными для редактирования
 * - Отправка изменений в обработчик edit.php методом POST
 *
 * @package ToDoList\Templates\Task
 */

$pdo = getPDO();

// Получение ID задачи из запроса
$id = $_GET['id'] ?? null;
if (!$id) {
    die("ID задачи не указан.");
}

// Загрузка задачи из базы данных
$stmt = $pdo->prepare("SELECT * FROM tasks WHERE id = ?");
$stmt->execute([$id]);
$task = $stmt->fetch();

if (!$task) {
    die("Задача не найдена.");
}
?>

<h2>Редактировать задачу</h2>

<form action="/todo-list/src/handlers/task/edit.php?id=<?= $task['id'] ?>" method="POST">
    <label>Название задачи:
        <input type="text" name="title" value="<?= htmlspecialchars($task['title']) ?>" required>
    </label><br>

    <label>Описание:
        <textarea name="description"><?= htmlspecialchars($task['description']) ?></textarea>
    </label><br>

    <label>Приоритет:
        <select name="priority">
            <option value="Низкий" <?= $task['priority'] === 'Низкий' ? 'selected' : '' ?>>Низкий</option>
            <option value="Средний" <?= $task['priority'] === 'Средний' ? 'selected' : '' ?>>Средний</option>
            <option value="Высокий" <?= $task['priority'] === 'Высокий' ? 'selected' : '' ?>>Высокий</option>
        </select>
    </label><br>

    <label>Статус:
        <select name="status">
            <option value="Не выполнено" <?= $task['status'] === 'Не выполнено' ? 'selected' : '' ?>>Не выполнено</option>
            <option value="В процессе" <?= $task['status'] === 'В процессе' ? 'selected' : '' ?>>В процессе</option>
            <option value="Выполнено" <?= $task['status'] === 'Выполнено' ? 'selected' : '' ?>>Выполнено</option>
        </select>
    </label><br>

    <input type="submit" value="Сохранить изменения">
</form>
