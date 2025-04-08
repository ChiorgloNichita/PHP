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
