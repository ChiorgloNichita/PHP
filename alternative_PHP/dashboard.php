<?php
/**
 * Загружает результаты футбольного теста из файла данных и отображает их в таблице.
 * 
 * @file result.php
 */

$dataFile = "data.json";

// Проверка наличия файла и декодирование JSON
$data = file_exists($dataFile) ? json_decode(file_get_contents($dataFile), true) : null;

// Проверка ошибок чтения данных
if (!$data || json_last_error() !== JSON_ERROR_NONE) {
    die("Ошибка загрузки данных.");
}

// Получаем результаты или создаем пустой массив
$results = $data["results"] ?? [];
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Результаты футбольного теста</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Таблица результатов футбольного теста</h2>

<table class="table">
    <thead>
        <tr>
            <th>Имя пользователя</th>
            <th>Правильных ответов</th>
            <th>Процент</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($results as $result): ?>
            <tr>
                <td><?= htmlspecialchars($result["username"]) ?></td>
                <td><?= htmlspecialchars($result["correct"]) ?></td>
                <td><?= htmlspecialchars($result["score"]) ?>%</td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<a href="test.php" class="button">Пройти тест заново</a>

</body>
</html>
