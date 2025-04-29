<?php
/**
 * Точка входа в приложение ToDo-List.
 *
 * Осуществляет маршрутизацию страниц:
 * - 'create'  => форма создания новой задачи
 * - 'edit'    => форма редактирования существующей задачи
 * - 'show'    => просмотр подробной информации о задаче
 * - 'index'   => отображение списка всех задач (по умолчанию)
 *
 * Загружает соответствующий шаблон страницы в буфер вывода
 * и подключает основной layout.
 *
 * @package ToDoList
 */

require_once __DIR__ . '/../src/db.php';

// Получение текущей страницы из запроса
$page = $_GET['page'] ?? 'index';

// Буферизация вывода контента страницы
ob_start();

switch ($page) {
    case 'create':
        require __DIR__ . '/../templates/task/create.php';
        break;
    case 'edit':
        require __DIR__ . '/../templates/task/edit.php';
        break;
    case 'show':
        require __DIR__ . '/../templates/task/show.php';
        break;
    default:
        require __DIR__ . '/../templates/index.php';
        break;
}

// Сохраняем контент в переменную
$content = ob_get_clean();

// Подключаем основной макет (layout)
require __DIR__ . '/../templates/layout.php';
