<?php

declare(strict_types=1);

// Подключаем необходимые файлы с функциями и транзакциями
require_once 'functions.php';
require_once 'transactions.php'; // Этот файл должен содержать массив $transactions

/**
 * Сортировка транзакций по дате.
 *
 * Использует функцию sortTransactionsByDate для сортировки массива транзакций
 * по дате в порядке возрастания.
 *
 * @param array $transactions Массив транзакций, который нужно отсортировать.
 * @return void
 */
sortTransactionsByDate($transactions);

/**
 * Сортировка транзакций по сумме (по убыванию).
 *
 * Использует функцию sortTransactionsByAmount для сортировки массива транзакций
 * по сумме в порядке убывания.
 *
 * @param array $transactions Массив транзакций, который нужно отсортировать.
 * @return void
 */
sortTransactionsByAmount($transactions);
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
