<?php
// src/helpers.php

/**
 * Валидация данных рецепта.
 *
 * @param array $data Данные рецепта.
 * @return array Массив ошибок валидации.
 */
function validateRecipeData($data) {
    $errors = [];
    if (empty($data['title'])) {
        $errors['title'] = 'Название рецепта обязательно.';
    }
    // Добавьте другие проверки
    return $errors;
}
?>
