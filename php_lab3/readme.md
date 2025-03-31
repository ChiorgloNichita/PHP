# Лабораторная работа №3. Массивы и Функции

## Цель работы

Освоить работу с массивами в PHP, применяя различные операции: создание, добавление, удаление, сортировка и поиск. Закрепить навыки работы с функциями, включая передачу аргументов, возвращаемые значения и анонимные функции.
Проект состоит из следующих файлов:

- **index.php** —  страница, которая отображает галерею изображений.
- **transactions.php** — содержит массив транзакций.
- **main.php** — скрипт для вывода изображений в виде галереи.
- **styles.css** — стили для таблицы и галереи изображений.
- **functions.php** - содержит функции для их обработки

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

Этот файл отвечает за отображение галереи изображений. В нем подключены другие необходимые файлы и стили.

```php
<?php
/**
 * Путь к директории с изображениями.
 *
 * @var string
 */
$dir = 'image/';

/**
 * Получение списка файлов из директории.
 *
 * Проверка, существует ли директория, и получение всех файлов, если директория существует. Если директория не найдена, создается пустой массив.
 *
 * @var array Массив файлов из директории.
 */
if (is_dir($dir)) {
    $files = scandir($dir); // Получаем список файлов
} else {
    $files = []; // Если директория не найдена, создаем пустой массив
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cats</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <header>
        <p>About Cats | News | Contacts</p>
    </header>
    <main>
        <div class="gallery">
            <?php
            /**
             * Проверка наличия изображений в директории и вывод изображений.
             *
             * Если в директории есть изображения (файлы), то выводятся изображения на страницу.
             * Если папка пуста или не найдена, выводится сообщение "No images found".
             */
            if (!empty($files)) { // Проверка на наличие файлов
                for ($i = 0; $i < count($files); $i++) {
                    if ($files[$i] !== "." && $files[$i] !== ".." && preg_match('/\.(jpg|jpeg|png|gif)$/i', $files[$i])) {
                        $path = $dir . $files[$i];
            ?>
            <div class="image">
                <img src="<?php echo $path ?>" alt="Изображение">
            </div>
            <?php
                    }
                }
            } else {
                echo "<p>No images found.</p>"; // Сообщение, если папка пуста или не найдена
            }
            ?>
        </div>
    </main>
    <footer>
        <p>USM © 2025</p>
    </footer>
</body>
</html>

```

#### functions.php

Этот файл содержит  функции для обработки данных, включая добавление транзакций, сортировку и вычисление общей суммы.

```php
<?php

declare(strict_types=1);

/**
 * Вычисляет общую сумму всех транзакций.
 *
 * @param array $transactions Массив транзакций.
 * @return float Общая сумма транзакций.
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction["amount"];
    }
    return $total;
}

/**
 * Ищет транзакции по частичному совпадению в описании.
 *
 * @param array $transactions Массив транзакций.
 * @param string $descriptionPart Часть описания, по которой производится поиск.
 * @return array Найденные транзакции.
 */
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    $foundTransactions = [];

    foreach ($transactions as $transaction) {
        if (stripos($transaction["description"], $descriptionPart) !== false) {
            $foundTransactions[] = $transaction;
        }
    }

    return $foundTransactions;
}

/**
 * Ищет транзакцию по её ID.
 *
 * @param array $transactions Массив транзакций.
 * @param int $id ID транзакции.
 * @return array|null Найденная транзакция или null, если не найдена.
 */
function findTransactionById(array $transactions, int $id): ?array {
    foreach ($transactions as $transaction) {
        if ($transaction["id"] === $id) {
            return $transaction; // Если нашли, сразу возвращаем
        }
    }
    return null; // Если не нашли, возвращаем null
}

/**
 * Рассчитывает количество дней, прошедших с момента транзакции.
 *
 * @param DateTime $date Дата транзакции.
 * @return int Количество прошедших дней.
 */
function daysSinceTransaction(DateTime $date): int {
    $currentDate = new DateTime();
    return $date->diff($currentDate)->days;
}

/**
 * Добавляет новую транзакцию в глобальный массив транзакций.
 *
 * @param int $id ID транзакции.
 * @param string $date Дата транзакции в формате "YYYY-MM-DD".
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Продавец/компания.
 * @return void
 */
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;

    $transactions[] = [
        "id" => $id,
        "date" => new DateTime($date),
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}

/**
 * Сортирует транзакции по дате (от старых к новым).
 *
 * @param array $transactions Массив транзакций (передается по ссылке).
 * @return void
 */
function sortTransactionsByDate(array &$transactions): void {
    usort($transactions, function ($a, $b) {
        return $a["date"] <=> $b["date"];
    });
}

/**
 * Сортирует транзакции по сумме (от больших к меньшим).
 *
 * @param array $transactions Массив транзакций (передается по ссылке).
 * @return void
 */
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, function ($a, $b) {
        return $b["amount"] <=> $a["amount"];
    });
}

```

#### main.php

Этот код представляет собой веб-страницу, которая генерирует отчет о транзакциях.

```php
<?php

declare(strict_types=1);
require_once 'functions.php';
require_once 'transactions.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Отчет о транзакциях</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <h2>Отчет о транзакциях</h2>
    <table>
        <thead>
            <tr>
                <th>Transaction ID</th>
                <th>Date</th>
                <th>Total Amount</th>
                <th>Description</th>
                <th>Merchant</th>
                <th>Days Passed</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($transactions as $transaction): ?>
                <tr>
                    <td><?php echo $transaction["id"]; ?></td>
                    <td><?php echo $transaction["date"]->format('Y-m-d'); ?></td>
                    <td><?php echo number_format($transaction["amount"], 2); ?> lei</td>
                    <td><?php echo $transaction["description"]; ?></td>
                    <td><?php echo $transaction["merchant"]; ?></td>
                    <td><?php echo daysSinceTransaction($transaction["date"]); ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <p>Total Amount: <?php echo number_format(calculateTotalAmount($transactions), 2); ?> lei</p>
</body>
</html>

```

#### styles.css

Этот файл содержит стили для отображения таблицы и галереи изображений.

```css
/* styles.css */
body {
    font-family: Arial, sans-serif;
    background-color: #f4f4f4;
    margin: 0;
    padding: 0;
}

header {
    background-color: #333;
    color: #fff;
    text-align: center;
    padding: 20px;
}

footer {
    text-align: center;
    background-color: #333;
    color: #fff;
    padding: 10px;
}

.gallery {
    display: flex;
    flex-wrap: wrap;  /* Размещение элементов по строкам */
    justify-content: space-around;  /* Расстояние между изображениями */
    margin: 20px;
    gap: 15px;  /* Отступы между изображениями */
}

.image {
    width: 200px;  /* Ширина каждого изображения */
    height: auto;  /* Автоматическая высота, чтобы сохранить пропорции */
    border-radius: 10px;  /* Скругленные углы для изображений */
    overflow: hidden;  /* Обрезка лишнего контента */
    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);  /* Легкая тень для улучшения визуала */
}

.image img {
    width: 100%;
    height: 100%;
    object-fit: cover;  /* Обрезка изображений для покрытия всей области */
    border-radius: 10px;
}

/* Дополнительный стиль для заголовков */
h1 {
    font-size: 2em;
    margin: 0;
}

p {
    margin: 10px 0;
}


body {
    font-family: Arial, sans-serif;
    background-color: #f8f9fa;
    margin: 20px;
    text-align: center;
}

h2 {
    color: #333;
}

table {
    width: 80%;
    margin: 20px auto;
    border-collapse: collapse;
    box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
    background-color: #fff;
    border-radius: 8px;
    overflow: hidden;
}

th, td {
    padding: 12px;
    border: 1px solid #ddd;
    text-align: left;
}

th {
    background-color: #007bff;
    color: white;
    font-weight: bold;
}

tr:nth-child(even) {
    background-color: #f2f2f2;
}

tr:hover {
    background-color: #d6e4ff;
}

p {
    font-size: 18px;
    font-weight: bold;
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


