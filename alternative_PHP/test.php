<?php
/**
 * Подключаем файл для обработки теста.
 * В этом файле содержится логика обработки ответов пользователя и вычисления результатов.
 */
require_once 'process_test.php'; // Подключаем логику из process_test.php
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Прохождение футбольного теста</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<h2>Пройти футбольный тест</h2>

<!-- Форма для прохождения теста -->
<form action="test.php" method="POST">
    <label>Введите ваше имя:</label>
    <input type="text" name="username" required>

    <?php 
    /**
     * Перебираем все вопросы, загруженные из JSON.
     * Каждый вопрос должен содержать текст и ответы, которые будут отображены пользователю.
     */
    foreach ($questions as $index => $q): 
        // Пропускаем вопросы, у которых нет текста или ответов
        if (empty($q["question"]) || empty($q["answers"])) continue;
    ?>
        <p><?php echo ($index + 1) . ". " .htmlspecialchars($q["question"]); ?></p>
        
        <?php 
        /**
         * Перебираем все ответы для текущего вопроса.
         * В зависимости от типа ответа (radio или checkbox) создается соответствующий HTML-элемент.
         */
        foreach ($q["answers"] as $key => $answer): 
            $inputType = htmlspecialchars($q["type"]);  // Тип элемента (radio или checkbox)
            $inputName = "answer[$index]"; // Имя для передачи данных в POST

            /**
             * Если тип ответа - checkbox, то добавляем [] в имя,
             * чтобы можно было передавать массив выбранных значений.
             */
            if ($inputType == 'checkbox') {
                $inputName .= '[]';
            }
        ?>
            <!-- Генерируем поле ввода для ответа -->
            <input type="<?= $inputType ?>" name="<?= $inputName ?>" value="<?= $key ?>"> 
            <?=htmlspecialchars($answer) ?><br>
        <?php endforeach; ?>
        <br>
    <?php endforeach; ?>

    <!-- Кнопка для отправки формы -->
    <button type="submit">Отправить</button>
</form>

</body>
</html>
