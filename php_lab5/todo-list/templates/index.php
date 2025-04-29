<?php
/**
 * Шаблон главной страницы списка задач.
 *
 * Выполняет:
 * - Получение списка задач с пагинацией
 * - Отображение задач в виде таблицы
 * - Отображение ссылок на просмотр, редактирование и удаление задачи
 * - Вывод пагинации (предыдущая/следующая страница)
 * - Кнопка для добавления новой задачи
 *
 * @package ToDoList\Templates
 */

require_once __DIR__ . '/../src/db.php';

$pdo = getPDO();

// Параметры пагинации
$page = max(1, (int)($_GET['p'] ?? 1));
$perPage = 5;
$offset = ($page - 1) * $perPage;

// Считаем общее количество задач
$total = $pdo->query("SELECT COUNT(*) FROM tasks")->fetchColumn();
$pages = ceil($total / $perPage);

// Получаем задачи с лимитом и смещением
$tasks = $pdo->query("SELECT * FROM tasks ORDER BY created_at DESC LIMIT $perPage OFFSET $offset")->fetchAll();
?>

<h2 style="text-align:center; margin-top:20px;">Список задач</h2>

<table>
    <thead>
        <tr>
            <th>Название</th>
            <th>Приоритет</th>
            <th>Статус</th>
            <th>Действия</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($tasks as $task): ?>
            <tr>
                <td><?= htmlspecialchars($task['title']) ?></td>
                <td><?= htmlspecialchars($task['priority']) ?></td>
                <td><?= htmlspecialchars($task['status']) ?></td>
                <td>
                    <a href="?page=show&id=<?= $task['id'] ?>">Просмотр</a> |
                    <a href="?page=edit&id=<?= $task['id'] ?>">Редактировать</a> |
                    <a href="/todo-list/src/handlers/task/delete.php?id=<?= $task['id'] ?>" onclick="return confirm('Удалить задачу?')">Удалить</a>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Пагинация -->
<div style="text-align:center; margin-top: 20px;">
    Страница <?= $page ?> из <?= $pages ?> |
    
    <?php if ($page > 1): ?>
        <a href="?page=index&p=<?= $page - 1 ?>">← Предыдущая</a> |
    <?php endif; ?>

    <?php if ($page < $pages): ?>
        <a href="?page=index&p=<?= $page + 1 ?>">Следующая →</a>
    <?php endif; ?>
</div>

<!-- Кнопка Добавить задачу -->
<div style="text-align:center; margin-top: 20px;">
    <a href="?page=create" style="display:inline-block; padding:10px 20px; background-color:#4CAF50; color:white; text-decoration:none; border-radius:5px;">Добавить задачу</a>
</div>
