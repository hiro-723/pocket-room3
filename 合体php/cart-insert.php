<?php
session_start();
require_once 'db-connect.php';

if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

// ログイン中のユーザー情報取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  echo "ユーザーが見つかりません。";
  exit;
}

$customer_id = $user['customer_id'];
$product_id = $_POST['product_id'];

// すでにカートに同じ商品があるかチェック
$check = $pdo->prepare("SELECT * FROM cart WHERE customer_id = ? AND product_id = ?");
$check->execute([$customer_id, $product_id]);

if ($check->rowCount() == 0) {
  // なければ追加
  $stmt = $pdo->prepare("INSERT INTO cart (customer_id, product_id) VALUES (?, ?)");
  $stmt->execute([$customer_id, $product_id]);
}

// カート画面へ移動
header("Location: cart.php");
exit;
?>
