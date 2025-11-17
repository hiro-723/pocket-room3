<?php
session_start();
require_once 'db-connect.php';

// 未ログインならログインへ
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// ログイン中ユーザーID取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザーが見つかりません。");
}

$customer_id = $user['customer_id'];
$product_id = $_POST['product_id'];

// 重複チェック
$check = $pdo->prepare("SELECT 1 FROM favorite WHERE customer_id = ? AND product_id = ?");
$check->execute([$customer_id, $product_id]);

if ($check->rowCount() == 0) {
    $stmt = $pdo->prepare("INSERT INTO favorite (customer_id, product_id) VALUES (?, ?)");
    $stmt->execute([$customer_id, $product_id]);
}

// 元のページに戻す
header("Location: favorite.php");
exit;
?>
