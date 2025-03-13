<?php
/**
 * Получение данных из параметров GET запроса.
 * 
 * @var int $correctCount Количество правильных ответов.
 * @var float $score Процент правильных ответов.
 */
$correctCount = isset($_GET["correct"]) ? (int)$_GET["correct"] : 0;
$score = isset($_GET["score"]) ? (float)$_GET["score"] : 0;
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

<div class="result-box">
    <h2>Ваш результат в футбольном тесте</h2>
    <p class="result-text">
        Количество правильных ответов: <b><?= $correctCount ?></b>
    </p>
    <p class="result-text">
        Процент набранных баллов: <b><?= $score ?>%</b>
    </p>
    <a href="test.php" class="button">Пройти тест заново</a>
    <a href="dashboard.php" class="button">Посмотреть таблицу результатов</a>
    <a href="index.php" class="button">Вернуться на главную</a>
</div>

</body>
</html>
