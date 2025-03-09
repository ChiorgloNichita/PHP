<?php
declare(strict_types=1);

$transactions = [
    ["id" => 1, "date" => "2019-01-01", "amount" => 100.00, "description" => "Payment for groceries", "merchant" => "SuperMart"],
    ["id" => 2, "date" => "2020-02-15", "amount" => 75.50, "description" => "Dinner with friends", "merchant" => "Local Restaurant"],
];

// Функция вычисления общей суммы
function calculateTotalAmount(array $transactions): float {
    $total = 0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

// Функция поиска транзакции по описанию
function findTransactionByDescription(array $transactions, string $descriptionPart): array {
    return array_filter($transactions, function ($transaction) use ($descriptionPart) {
        return stripos($transaction['description'], $descriptionPart) !== false;
    });
}

// Функция поиска транзакции по ID
function findTransactionById(array $transactions, int $id): ?array {
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return null;
}

// Функция добавления транзакции
function addTransaction(int $id, string $date, float $amount, string $description, string $merchant): void {
    global $transactions;
    $transactions[] = compact("id", "date", "amount", "description", "merchant");
}

// Функция сортировки по дате
function sortTransactionsByDate(array &$transactions): void {
    usort($transactions, fn($a, $b) => strcmp($a['date'], $b['date']));
}

// Функция сортировки по сумме (по убыванию)
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, fn($a, $b) => $b['amount'] <=> $a['amount']);
}

// Функция подсчёта дней с момента транзакции
function daysSinceTransaction(string $date): int {
    $transactionDate = new DateTime($date);
    $now = new DateTime();
    return $now->diff($transactionDate)->days;
}
?>
