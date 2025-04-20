<?php
require_once __DIR__ . '/../../db.php';
$pdo = getPDO();

$id = $_GET['id'] ?? null;
if ($id) {
    $stmt = $pdo->prepare("DELETE FROM recipes WHERE id = :id");
    $stmt->execute(['id' => $id]);
}

header('Location: /recipe-book/public/?page=index');
exit;
