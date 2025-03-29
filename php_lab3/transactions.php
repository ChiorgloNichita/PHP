<?php

declare(strict_types=1);

// Путь к файлу с транзакциями
define('TRANSACTIONS_FILE', 'transactions.json');

// Проверка существования файла с транзакциями
if (!file_exists(TRANSACTIONS_FILE)) {
    // Если файла нет, создаем пустой массив и сохраняем его
    file_put_contents(TRANSACTIONS_FILE, json_encode([]));
}

// Функции
function loadTransactions(): array {
    return json_decode(file_get_contents(TRANSACTIONS_FILE), true);
}

function saveTransactions(array $transactions): void {
    file_put_contents(TRANSACTIONS_FILE, json_encode($transactions, JSON_PRETTY_PRINT));
}

function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

function findTransactionByDescription(string $descriptionPart): array {
    $transactions = loadTransactions();
    return array_filter($transactions, function($transaction) use ($descriptionPart) {
        return strpos($transaction['description'], $descriptionPart) !== false;
    });
}
function findTransactionById(int $id): ?array {
    $transactions = loadTransactions();
    $filtered = array_filter($transactions, function($transaction) use ($id) {
        return $transaction['id'] === $id;
    });
    return empty($filtered) ? null : reset($filtered); // Возвращаем первый элемент, если найден
}

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

function sortTransactionsByDate(): void {
    $transactions = loadTransactions();
    usort($transactions, function($a, $b) {
        return strtotime($a['date']) - strtotime($b['date']);
    });
    saveTransactions($transactions);
}

function sortTransactionsByAmount(): void {
    $transactions = loadTransactions();
    usort($transactions, function($a, $b) {
        return $b['amount'] - $a['amount'];
    });
    saveTransactions($transactions);
}

function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $currentDate = new DateTime();
    $interval = $currentDate->diff($transactionDate);
    return $interval->days;
}

?>
