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
