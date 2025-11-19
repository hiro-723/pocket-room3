<?php
session_start();
require_once 'db-connect.php';

// ログインチェック
if (!isset($_SESSION['username'])) {
    exit("ログインしていません");
}

// ✔ ログインしているユーザーの customer_id を取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報がありません");
}

$customer_id = $user['customer_id'];

// ✔ 削除対象IDチェック
if (!isset($_POST['favorite_id'])) {
    exit("IDがありません");
}

$favorite_id = $_POST['favorite_id'];

// ✔ 該当ユーザーの "その商品だけ" 削除
$stmt = $pdo->prepare("DELETE FROM favorite WHERE favorite_id = ? AND customer_id = ?");
$stmt->execute([$favorite_id, $customer_id]);

// 完了後戻る
header("Location: favorite.php");
exit;
?>
