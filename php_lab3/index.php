<?php

declare(strict_types=1);
require_once 'transactions.php';

// Изначальная загрузка транзакций
$transactions = loadTransactions();

// Обработка запросов
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

<!-- Меню, теперь оно будет отображаться только над галереей -->
<h2>Галерея изображений</h2>
<div class="navbar">
    <a href="#">Abouts casts</a>
    <a href="#">News</a>
    <a href="#">Contacts</a>
</div>

<?php require 'gallery.php'; ?>

</body>
</html>
