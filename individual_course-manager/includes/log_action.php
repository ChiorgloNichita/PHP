<?php
require_once __DIR__ . '/../db/education.php';

/**
 * Логирует действие администратора в таблицу actions_log базы logs.
 *
 * @param string $message Сообщение, которое нужно сохранить в лог.
 * 
 * @return void
 */
function logAction(string $message): void {
    global $authPdo;
    $stmt = $authPdo->prepare("INSERT INTO actions_log (action) VALUES (?)");
    $stmt->execute([$message]);
}
?>
