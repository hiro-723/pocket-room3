<?php
session_start();
require_once 'db-connect.php'; // PDO接続

// ログインチェック
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// ログイン中ユーザーのIDを取得
$stmt = $pdo->prepare("SELECT customer_id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_id = $user['customer_id'];

// お気に入り一覧を取得
$sql = "
  SELECT 
    favorite.favorite_id,
    product.product_id,
    product.product_name,
    product.price
  FROM favorite
  JOIN product ON favorite.product_id = product.product_id
  WHERE favorite.customer_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お気に入り一覧</title>
  <link rel="stylesheet" href="../css-DS/favorite.css">
</head>
<body>
  <div class="container">
    <nav class="side-nav">
      <button onclick="location.href='home.html'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorites.html'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.html'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.html'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">

    </nav>

    <main class="content">
      <img src="../kuma/moji.png" class="moji">
      <input type="text" placeholder="検索" class="search-bar">

      <div class="grid">
        <div class="item">商品A</div>
        <div class="item">商品B</div>
        <div class="item">商品C</div>
        <div class="item">商品D</div>
        <div class="item">商品E</div>
        <div class="item">商品F</div>
        <div class="item">商品G</div>
        <div class="item">商品H</div>
      </div>
    </main>
  </div>

  <script src="../js/favorite.js"></script>
</body>
</html>
