<?php
/**
 * Шаблон страницы добавления новой задачи.
 *
 * Отображает HTML-форму для ввода данных новой задачи:
 * - название (обязательное поле)
 * - описание
 * - приоритет (низкий, средний, высокий)
 * - статус выполнения (не выполнено, в процессе, выполнено)
 *
 * При отправке формы данные передаются в обработчик create.php методом POST.
 *
 * @package ToDoList\Templates\Task
 */
?>


<form action="/todo-list/src/handlers/task/create.php" method="POST">
    <label>Название задачи:
        <input type="text" name="title" required>
    </label><br>

    <label>Описание:
        <textarea name="description"></textarea>
    </label><br>

    <label>Приоритет:
        <select name="priority">
            <option value="Низкий">Низкий</option>
            <option value="Средний" selected>Средний</option>
            <option value="Высокий">Высокий</option>
        </select>
    </label><br>

    <label>Статус:
        <select name="status">
            <option value="Не выполнено" selected>Не выполнено</option>
            <option value="В процессе">В процессе</option>
            <option value="Выполнено">Выполнено</option>
        </select>
    </label><br>

    <input type="submit" value="Добавить задачу">
</form>
