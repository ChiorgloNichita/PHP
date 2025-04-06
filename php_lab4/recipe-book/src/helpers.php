<?php

/**
 * Загружает все рецепты из JSON-файла
 * @return array
 */
function loadRecipes(): array {
    $file = __DIR__ . '/../storage/recipes.json';
    if (!file_exists($file)) return [];

    $data = file_get_contents($file);
    return json_decode($data, true) ?? [];
}

/**
 * Сохраняет новый рецепт в JSON-файл
 * @param array $recipe
 */
function saveRecipe(array $recipe): void {
    $file = __DIR__ . '/../storage/recipes.json';
    $recipes = loadRecipes();
    $recipes[] = $recipe;

    file_put_contents($file, json_encode($recipes, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT));
}
