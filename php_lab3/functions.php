<?php

declare(strict_types=1);

/**
 * Функция для вычисления общей суммы всех транзакций.
 *
 * Проходит по массиву транзакций и суммирует значения поля 'amount' каждой транзакции.
 *
 * @param array $transactions Массив транзакций.
 * @return float Общая сумма всех транзакций.
 */
function calculateTotalAmount(array $transactions): float {
    $total = 0.0;
    foreach ($transactions as $transaction) {
        $total += $transaction['amount'];
    }
    return $total;
}

/**
 * Функция для поиска транзакции по части описания.
 *
 * Проходит по массиву транзакций и находит все транзакции, описание которых
 * содержит указанную часть текста.
 *
 * @param string $descriptionPart Часть описания для поиска.
 * @param array $transactions Массив транзакций.
 * @return array Массив транзакций, чьи описания содержат заданную часть текста.
 */
function findTransactionByDescription(string $descriptionPart, array $transactions) {
    $result = [];
    foreach ($transactions as $transaction) {
        if (strpos($transaction['description'], $descriptionPart) !== false) {
            $result[] = $transaction;
        }
    }
    return $result;
}

/**
 * Функция для поиска транзакции по ID.
 *
 * Находит транзакцию в массиве по её уникальному ID.
 *
 * @param int $id Уникальный идентификатор транзакции.
 * @param array $transactions Массив транзакций.
 * @return array|null Транзакция с заданным ID или null, если не найдена.
 */
function findTransactionById(int $id, array $transactions) {
    foreach ($transactions as $transaction) {
        if ($transaction['id'] === $id) {
            return $transaction;
        }
    }
    return null;
}

/**
 * Функция для вычисления количества дней с момента транзакции.
 *
 * Вычисляет разницу в днях между текущей датой и датой транзакции.
 *
 * @param DateTime $date Дата транзакции.
 * @return int Количество дней между текущей датой и датой транзакции.
 */
function daysSinceTransaction(DateTime $date): int {
    $currentDate = new DateTime();
    $interval = $date->diff($currentDate);
    return $interval->days;
}

/**
 * Функция для добавления новой транзакции.
 *
 * Добавляет новую транзакцию в массив транзакций.
 *
 * @param int $id Уникальный идентификатор транзакции.
 * @param DateTime $date Дата транзакции.
 * @param float $amount Сумма транзакции.
 * @param string $description Описание транзакции.
 * @param string $merchant Название организации получателя.
 * @param array &$transactions Массив транзакций, в который добавляется новая транзакция.
 * @return void
 */
function addTransaction(int $id, DateTime $date, float $amount, string $description, string $merchant, array &$transactions): void {
    $transactions[] = [
        "id" => $id,
        "date" => $date,
        "amount" => $amount,
        "description" => $description,
        "merchant" => $merchant,
    ];
}

/**
 * Функция для сортировки транзакций по дате.
 *
 * Сортирует массив транзакций по дате в порядке возрастания.
 *
 * @param array &$transactions Массив транзакций, который будет отсортирован.
 * @return void
 */
function sortTransactionsByDate(array &$transactions): void {
    usort($transactions, function($a, $b) {
        return $a['date'] <=> $b['date'];
    });
}

/**
 * Функция для сортировки транзакций по сумме (по убыванию).
 *
 * Сортирует массив транзакций по сумме в порядке убывания.
 *
 * @param array &$transactions Массив транзакций, который будет отсортирован.
 * @return void
 */
function sortTransactionsByAmount(array &$transactions): void {
    usort($transactions, function($a, $b) {
        return $b['amount'] <=> $a['amount'];
    });
}
