<?php
/**
 * Главная страница, на которой приветствуется пользователь и предоставляется кнопка для начала прохождения теста.
 * 
 * Страница содержит кнопку для перехода на страницу с тестом, а также стилизацию с использованием внешнего CSS.
 */
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Главная страница</title>
    <!-- Подключение внешнего файла стилей -->
    <link rel="stylesheet" href="css/style.css"> 
</head>
<body>

<!-- Контейнер для размещения содержимого страницы -->
<div class="container">
    <!-- Заголовок страницы -->
    <h1 class="title">Добро пожаловать в футбольный тест</h1>
    
    <!-- Кнопка для перехода на страницу теста -->
    <a href="test.php">
        <button class="start-button">Пройти тест</button>
    </a>
</div>

</body>
</html>
