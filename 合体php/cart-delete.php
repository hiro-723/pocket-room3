<?php
session_start();
require_once 'db-connect.php';

// ▼ ログインチェック
if (!isset($_SESSION['username'])) {
    exit("ログインしていません");
}

// ▼ cart_id が送られてきているか確認
if (!isset($_POST['cart_id'])) {
    header("Location: cart.php");
    exit;
}

$cart_id = $_POST['cart_id'];

// ▼ cart_id の商品だけ削除する
$stmt = $pdo->prepare("DELETE FROM cart WHERE cart_id = ?");
$stmt->execute([$cart_id]);

// ▼ カートへ戻る
header("Location: cart.php");
exit;
