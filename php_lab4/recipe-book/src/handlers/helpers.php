<?php

// Функция для сохранения задач в файл
function saveTasks($tasks) {
    // Сохраняем данные в файл tasks.json
    file_put_contents('../storage/tasks.json', json_encode($tasks, JSON_PRETTY_PRINT));
}

// Функция для фильтрации данных
function sanitizeInput($data) {
    return htmlspecialchars(strip_tags($data));
}

// Валидация обязательных полей
function validateRequiredFields($data, $fields) {
    foreach ($fields as $field) {
        if (empty($data[$field])) {
            return false;
        }
    }
    return true;
}