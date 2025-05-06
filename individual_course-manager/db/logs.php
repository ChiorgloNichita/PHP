<?php
$logPdo = new PDO("mysql:host=localhost;dbname=logs;charset=utf8", "root", "");
$logPdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>