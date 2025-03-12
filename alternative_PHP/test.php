<?php
/**
 * Подключение логики теста.
 * Этот файл подключает файл с логикой обработки теста и отображает форму для прохождения теста.
 * 
 * @file test.php
 * @see process_test.php Файл, в котором реализована логика обработки теста.
 */
include 'process_test.php'; // Подключаем логику из process_test.php
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прохождение футбольного теста</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        /* Стили остаются прежними */
    </style>
</head>
<body>

<h2>Пройти футбольный тест</h2>

<!-- Форма для прохождения теста -->
<form action="test.php" method="POST">
    <label for="username">Введите ваше имя:</label>
    <input type="text" name="username" id="username" required>

<?php
/**
 * Проходим по массиву вопросов и отображаем их.
 * Для каждого вопроса отображаются возможные варианты ответа.
 *
 * @var array $questions Массив вопросов для теста.
 * @var array $q Вопрос с возможными ответами.
 */
foreach ($questions as $index => $q):
    // Пропускаем пустые вопросы
    if (empty($q["question"]) || empty($q["answers"])) continue;
?>
    <p><?= ($index + 1) . ". " . $q["question"] ?></p>

<?php
    /**
     * Отображаем варианты ответов для каждого вопроса.
     * Для каждого варианта ответа генерируется поле ввода (radio или checkbox).
     *
     * @var string $inputType Тип поля ввода (radio или checkbox).
     * @var string $inputName Имя поля для отправки данных.
     */
    foreach ($q["answers"] as $key => $answer):
        $inputType = $q["type"]; // Тип поля ввода (radio или checkbox)
        $inputName = "answer[$index]"; // Имя поля для отправки данных
        if ($inputType == 'checkbox') {
            $inputName .= '[]';  // Для чекбоксов добавляем [] в имя
        }
?>
    <input type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $key ?>"> 
    <?= $answer ?><br>
<?php endforeach; ?>
<br>
<?php endforeach; ?>

<button type="submit">Отправить</button>
</form>
</body>
</html>
