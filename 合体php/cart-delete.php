<?php
session_start();
require_once 'db-connect.php';

// ▼ ログインチェック
if (!isset($_SESSION['username'])) {
    exit("ログインしていません");
}

// ▼ customer_id を取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報が見つかりません。");
}

$customer_id = $user['customer_id'];

// ▼ カートを空にする
$stmt = $pdo->prepare("DELETE FROM cart WHERE customer_id = ?");
$stmt->execute([$customer_id]);

// ▼ 購入完了ページへ
header("Location: cart.php");
exit;
?>