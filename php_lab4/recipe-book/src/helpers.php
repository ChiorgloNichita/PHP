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

/**
 * Загружает рецепты из JSON файла.
 *
 * @return array Массив рецептов.
 */
function loadRecipes() {
    $file = __DIR__ . '/../storage/recipes.json';
    if (!file_exists($file)) {
        return [];
    }
    $content = file_get_contents($file);
    return json_decode($content, true) ?? [];
}
?>
