<?php
session_start();
require_once 'db-connect.php';

if (!isset($_SESSION['username'])) {
    exit("ログインしていません");
}

if (!isset($_POST['favorite_id'])) {
    exit("IDがありません");
}

$favorite_id = $_POST['favorite_id'];

$stmt = $pdo->prepare("DELETE FROM favorite WHERE favorite_id = ?");
$stmt->execute([$favorite_id]);

echo "OK";
?>
