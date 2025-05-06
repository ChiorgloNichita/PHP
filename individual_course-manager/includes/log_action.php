<?php
require_once __DIR__ . '/../db/logs.php';
function logAction($message) {
    global $logPdo;
    $stmt = $logPdo->prepare("INSERT INTO actions_log (action) VALUES (?)");
    $stmt->execute([$message]);
}
?>