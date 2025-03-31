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
