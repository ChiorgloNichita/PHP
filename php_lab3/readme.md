# Лабораторная работа №3. Массивы и Функции

## Цель работы

Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.
Проект состоит из следующих файлов:

- **index.php** — основная страница, которая отображает как транзакции, так и галерею изображений.
- **transactions.php** — содержит массив транзакций, а также функции для их обработки.
- **gallery.php** — скрипт для вывода изображений в виде галереи.
- **styles.css** — стили для таблицы и галереи изображений.

## Функционал

### 1. Таблица транзакций

На веб-странице выводится таблица с банковскими транзакциями. Каждая транзакция содержит информацию о:
- ID транзакции
- Дате транзакции
- Сумме транзакции
- Описание транзакции
- Магазине, где была совершена транзакция
- Количестве дней с момента транзакции

Кроме того, внизу страницы отображается общая сумма всех транзакций, которая вычисляется с помощью функции **calculateTotalAmount**.

### 2. Галерея изображений

Галерея изображений состоит из фотографий, загруженных в папку **image/**. Все изображения выводятся на странице с помощью PHP. Страница генерирует список файлов из папки **image** и отображает каждое изображение в контейнере **gallery**.

### Структура файлов

#### index.php

Этот файл является основным и отвечает за отображение как таблицы с транзакциями, так и галереи изображений. В нем подключены другие необходимые файлы и стили.

Для копирования кода используйте блоки с тройными обратными кавычками (```) вокруг кода:

```php
<?php
declare(strict_types=1);
require 'transactions.php';
?>

<!DOCTYPE html>
<html lang="ru">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Банковские транзакции</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>

<h2>Список транзакций</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Дата</th>
            <th>Сумма</th>
            <th>Описание</th>
            <th>Магазин</th>
            <th>Дней назад</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
            <tr>
                <td><?= $transaction['id'] ?></td>
                <td><?= $transaction['date'] ?></td>
                <td><?= $transaction['amount'] ?> $</td>
                <td><?= $transaction['description'] ?></td>
                <td><?= $transaction['merchant'] ?></td>
                <td><?= daysSinceTransaction($transaction['date']) ?></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><strong>Общая сумма всех транзакций: </strong><?= calculateTotalAmount($transactions) ?> $</p>

<h2>Галерея изображений</h2>
<?php require 'gallery.php'; ?>

</body>
</html>


#### transactions.php

Этот файл содержит массив с транзакциями и функции для обработки данных, включая добавление транзакций, сортировку и вычисление общей суммы.

```php
<?php
declare(strict_types=1);

/**
 * Массив транзакций, содержащий данные о каждой транзакции.
 * @var array
 */
$transactions = [
    [
        "id" => 1,
        "date" => "2019-01-01",
        "amount" => 100.00,
        "description" => "Payment for groceries",
        "merchant" => "SuperMart",
    ],
    [
        "id" => 2,
        "date" => "2020-02-15",
        "amount" => 75.50,
        "description" => "Dinner with friends",
        "merchant" => "Local Restaurant",
    ],
];

/**
 * Функция для вычисления общей суммы всех транзакций.
 *
 * @param array $transactions Массив транзакций.
 * @return float Общая сумма всех транзакций.
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

/**
 * Функция для поиска транзакций по части описания.
 *
 * @param array $transactions Массив транзакций.
 * @param string $descriptionPart Часть описания транзакции для поиска.
 * @return array Массив транзакций, описание которых содержит переданную строку.
 */
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    return array_filter($transactions, function ($transaction) use ($descriptionPart) {
        return stripos($transaction['description'], $descriptionPart) !== false;
    });
}

/**
 * Функция для поиска транзакции по ее ID.
 *
 * @param array $transactions Массив транзакций.
 * @param int $id ID транзакции для поиска.
 * @return array|null Транзакция с данным ID или null, если не найдена.
 */
function findTransactionById(array $transactions, int $id): ?array {
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return null;
}

/**
 * Функция для добавления новой транзакции.
 *
 * @param int $id ID транзакции.
 * @param string $date Дата транзакции.
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Магазин, где была совершена транзакция.
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    $transactions[] = compact("id", "date", "amount", "description", "merchant");
}

/**
 * Функция для сортировки транзакций по дате.
 *
 * @param array $transactions Массив транзакций.
 * @return void Массив транзакций сортируется по дате.
 */
function sortTransactionsByDate(array &$transactions): void {
    usort($transactions, fn($a, $b) => strcmp($a['date'], $b['date']));
}

/**
 * Функция для сортировки транзакций по сумме (по убыванию).
 *
 * @param array $transactions Массив транзакций.
 * @return void Массив транзакций сортируется по сумме.
 */
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, fn($a, $b) => $b['amount'] <=> $a['amount']);
}

/**
 * Функция для подсчета количества дней с момента транзакции.
 *
 * @param string $date Дата транзакции.
 * @return int Количество дней с момента транзакции.
 */
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $now = new DateTime();
    return $now->diff($transactionDate)->days;
}
?>



```

#### gallery.php

Этот файл сканирует директорию **image/** и выводит все изображения в виде галереи.

```php
<?php
/**
 * Сканирует директорию и выводит изображения из папки.
 *
 * @var string $dir Путь к папке с изображениями.
 * @var array $files Массив файлов в директории.
 */
$dir = 'image/';
$files = scandir($dir);
?>

<div class="gallery">
    <?php foreach ($files as $file): ?>
        <?php if ($file !== "." && $file !== ".."): ?>
            <img src="<?= $dir . $file ?>" alt="Image" class="gallery-img">
        <?php endif; ?>
    <?php endforeach; ?>
</div>
<p style="text-align:center; margin-top: 20px;">USM @ 2025</p>
```

#### styles.css

Этот файл содержит стили для отображения таблицы и галереи изображений.

```css
/* Стиль для навигационного меню */
.navbar {
    display: flex;
    justify-content: center;
    gap: 20px;
    background-color: #f0f0f0;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 5px;
    margin-top: 20px; 
    margin-bottom: 20px; 
}

.navbar a {
    text-decoration: none;
    color: #333;
    font-weight: bold;
    padding: 5px 15px;
    transition: background-color 0.3s;
}

.navbar a:hover {
    background-color: #ddd;
    border-radius: 5px;
}

/* Стиль для таблицы транзакций */
table {
    width: 100%;
    border-collapse: collapse;
}

th, td {
    padding: 10px;
    border: 1px solid black;
    text-align: center;
}

.gallery {
    display: flex;
    flex-wrap: wrap;
    gap: 10px;
    justify-content: center;
}

.gallery-img {
    width: 150px;  
    height: 150px; 
    object-fit: cover; 
    border: 2px solid #ddd;
    border-radius: 5px;
}

p {
    font-size: 16px;
    color: #333;
    text-align: center;
    margin-top: 20px;
}

```

### Задания, выполненные в рамках работы:
1. Создание таблицы транзакций с вычислением общей суммы.
2. Реализация поиска и сортировки транзакций по различным критериям.
3. Реализация динамической галереи изображений с возможностью добавления новых фото.
4. Работа с глобальными переменными в PHP для обработки данных.

## Контрольные вопросы

### 1. Что такое массивы в PHP?

Массивы в PHP — это структуры данных, которые позволяют хранить несколько значений под одним именем. Массивы могут содержать элементы разных типов, и индексы могут быть как числовыми, так и ассоциативными (строковыми). 

### 2. Каким образом можно создать массив в PHP?

Массивы в PHP можно создать двумя способами:

- **Нумерованные массивы**: Используя `array()` или краткую синтаксис `[]`.

### 3. Для чего используется цикл foreach?

Цикл foreach используется для перебора всех элементов массива или объекта. Это удобный способ пройти по массиву, не используя индексы, особенно для ассоциативных массивов.


