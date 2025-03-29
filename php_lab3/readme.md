# Лабораторная работа №3. Массивы и Функции

## Цель работы

Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.
Проект состоит из следующих файлов:

- **index.php** — основная страница, которая отображает как транзакции, так и галерею изображений.
- **transactions.php** — содержит массив транзакций, а также функции для их обработки.
- **gallery.php** — скрипт для вывода изображений в виде галереи.
- **styles.css** — стили для таблицы и галереи изображений.
- **transactions.json** - хранение данных

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

```php
<?php

declare(strict_types=1);
require_once 'transactions.php';

// Изначальная загрузка транзакций
$transactions = loadTransactions();

/**
 * Обработка запросов от пользователя.
 * В зависимости от типа запроса (POST) выполняются действия по добавлению, удалению, сортировке и поиску транзакций.
 */
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Добавление новой транзакции
    if (isset($_POST['add'])) {
        addTransaction(
            count($transactions) + 1,  // ID транзакции
            $_POST['date'],
            (float)$_POST['amount'],
            $_POST['description'],
            $_POST['merchant']
        );
        $transactions = loadTransactions(); // Обновляем список транзакций
    }

    // Удаление транзакции
    if (isset($_POST['remove'])) {
        removeTransaction((int)$_POST['id']);
        $transactions = loadTransactions(); // Обновляем список транзакций
    }

    // Сортировка по дате
    if (isset($_POST['sort_date'])) {
        sortTransactionsByDate();
        $transactions = loadTransactions(); // Обновляем список транзакций после сортировки
    }

    // Сортировка по сумме
    if (isset($_POST['sort_amount'])) {
        sortTransactionsByAmount();
        $transactions = loadTransactions(); // Обновляем список транзакций после сортировки
    }

    // Поиск по описанию
    if (isset($_POST['search_description'])) {
        if (!empty($_POST['description_search'])) {
            $transactions = findTransactionByDescription($_POST['description_search']);
        } else {
            // Если поле поиска пустое, показываем все транзакции
            $transactions = loadTransactions();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Банковские транзакции</title>
    <link rel="stylesheet" href="styles.css"> <!-- Подключение файла стилей -->
</head>

<body>

<h1>Bank Transactions</h1>

<!-- Форма добавления транзакции -->
<h2>Add Transaction</h2>
<form method="POST">
    <label for="date">Date (YYYY-MM-DD): </label>
    <input type="date" id="date" name="date" required><br><br>
    
    <label for="amount">Amount: </label>
    <input type="number" id="amount" name="amount" step="0.01" required><br><br>
    
    <label for="description">Description: </label>
    <input type="text" id="description" name="description" required><br><br>
    
    <label for="merchant">Merchant: </label>
    <input type="text" id="merchant" name="merchant" required><br><br>
    
    <button type="submit" name="add">Add Transaction</button>
</form>

<!-- Форма удаления транзакции -->
<h2>Remove Transaction</h2>
<form method="POST">
    <label for="id">Transaction ID: </label>
    <input type="number" id="id" name="id" required><br><br>
    <button type="submit" name="remove">Remove Transaction</button>
</form>

<!-- Форма сортировки транзакций -->
<h2>Sort Transactions</h2>
<form method="POST">
    <button type="submit" name="sort_date">Sort by Date</button>
    <button type="submit" name="sort_amount">Sort by Amount</button>
</form>

<!-- Форма поиска по описанию -->
<h2>Search Transactions</h2>
<form method="POST">
    <label for="description_search">Search Description: </label>
    <input type="text" id="description_search" name="description_search">
    <button type="submit" name="search_description">Search</button>
</form>

<!-- Таблица транзакций -->
<h2>Transaction List</h2>
<table border="1">
    <thead>
        <tr>
            <th>ID</th>
            <th>Date</th>
            <th>Amount</th>
            <th>Description</th>
            <th>Merchant</th>
            <th>Days Since</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($transactions as $transaction): ?>
        <tr>
            <td><?php echo $transaction['id']; ?></td>
            <td><?php echo $transaction['date']; ?></td>
            <td><?php echo $transaction['amount']; ?></td>
            <td><?php echo $transaction['description']; ?></td>
            <td><?php echo $transaction['merchant']; ?></td>
            <td><?php echo daysSinceTransaction($transaction['date']); ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<!-- Вывод общей суммы транзакций -->
<p>Total Amount: <?php echo calculateTotalAmount($transactions); ?></p>

</body>
</html>

<h2>Галерея изображений</h2>
<div class="navbar">
    <a href="#">Abouts casts</a>
    <a href="#">News</a>
    <a href="#">Contacts</a>
</div>

<?php require 'gallery.php'; ?>

</body>
</html>
```

#### transactions.php

Этот файл содержит массив с транзакциями и функции для обработки данных, включая добавление транзакций, сортировку и вычисление общей суммы.

```php
<?php

declare(strict_types=1);

// Путь к файлу с транзакциями
define('TRANSACTIONS_FILE', 'transactions.json');

// Проверка существования файла с транзакциями
if (!file_exists(TRANSACTIONS_FILE)) {
    // Если файла нет, создаем пустой массив и сохраняем его
    file_put_contents(TRANSACTIONS_FILE, json_encode([]));
}

/**
 * Загружает список транзакций из файла.
 * 
 * @return array Массив с данными транзакций.
 */
function loadTransactions(): array {
    return json_decode(file_get_contents(TRANSACTIONS_FILE), true);
}

/**
 * Сохраняет массив транзакций в файл.
 * 
 * @param array $transactions Массив транзакций для сохранения.
 * @return void
 */
function saveTransactions(array $transactions): void {
    file_put_contents(TRANSACTIONS_FILE, json_encode($transactions, JSON_PRETTY_PRINT));
}

/**
 * Вычисляет общую сумму всех транзакций.
 * 
 * @param array $transactions Массив транзакций.
 * @return float Общая сумма транзакций.
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

/**
 * Находит транзакции по части описания.
 * 
 * @param string $descriptionPart Часть описания для поиска.
 * @return array Массив транзакций, соответствующих описанию.
 */
function findTransactionByDescription(string $descriptionPart): array {
    $transactions = loadTransactions();
    return array_filter($transactions, function($transaction) use ($descriptionPart) {
        return strpos($transaction['description'], $descriptionPart) !== false;
    });
}

/**
 * Находит транзакцию по уникальному идентификатору.
 * 
 * @param int $id Идентификатор транзакции.
 * @return array|null Транзакция с данным идентификатором или null, если не найдена.
 */
function findTransactionById(int $id): ?array {
    $transactions = loadTransactions();
    $filtered = array_filter($transactions, function($transaction) use ($id) {
        return $transaction['id'] === $id;
    });
    return empty($filtered) ? null : reset($filtered); // Возвращаем первый элемент, если найден
}

/**
 * Добавляет новую транзакцию.
 * 
 * @param int $id Уникальный идентификатор транзакции.
 * @param string $date Дата транзакции.
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Название получателя платежа.
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    $transactions = loadTransactions();
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
    saveTransactions($transactions);
}

/**
 * Удаляет транзакцию по идентификатору.
 * 
 * @param int $id Идентификатор транзакции для удаления.
 * @return void
 */
function removeTransaction(int $id): void {
    $transactions = loadTransactions();
    foreach ($transactions as $key => $transaction) {
        if ($transaction['id'] === $id) {
            unset($transactions[$key]);
            break;
        }
    }
    saveTransactions(array_values($transactions));
}

/**
 * Сортирует транзакции по дате в порядке возрастания.
 * 
 * @return void
 */
function sortTransactionsByDate(): void {
    $transactions = loadTransactions();
    usort($transactions, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });
    saveTransactions($transactions);
}

/**
 * Сортирует транзакции по сумме в порядке убывания.
 * 
 * @return void
 */
function sortTransactionsByAmount(): void {
    $transactions = loadTransactions();
    usort($transactions, function($a, $b) {
        return $b['amount'] - $a['amount'];
    });
    saveTransactions($transactions);
}

/**
 * Возвращает количество дней с момента транзакции.
 * 
 * @param string $date Дата транзакции.
 * @return int Количество дней с момента транзакции.
 */
function daysSinceTransaction(string $date): int {
    $transactionDate = strtotime($date);
    $currentDate = time();
    return floor(($currentDate - $transactionDate) / (60 * 60 * 24));
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


