<?php
session_start();
require_once 'db-connect.php';

// ログインチェック
if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

// 検索キーワード取得
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// 検索処理
if ($keyword !== '') {
  $stmt = $pdo->prepare("SELECT * FROM product WHERE product_name LIKE ?");
  $stmt->execute(['%' . $keyword . '%']);
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
} else {
  $products = [];
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>検索結果 | POCKET ROOM</title>
  <link rel="stylesheet" href="../css-DS/search.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <div class="container">

    <!-- ✅ サイドメニュー -->
    <nav class="side-nav">
      <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorites.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <!-- ✅ メインコンテンツ -->
    <main>
      <h1 class="logo">POCKET ROOM</h1>

      <!-- 🔍 検索フォーム -->
      <form action="search.php" method="get" class="search-box">
        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="検索結果の値">
        <button type="submit"><i class="fas fa-search"></i></button>
      </form>

      <!-- 🧸 検索結果エリア -->
      <div class="product-list">
        <?php if ($products): ?>
          <?php foreach ($products as $product): ?>
            <div class="product-card">
              <?php if (!empty($product['img'])): ?>
                <img src="../img/<?= htmlspecialchars($product['img']) ?>" alt="商品画像">
              <?php else: ?>
                <div class="no-image">画像なし</div>
              <?php endif; ?>

              <p class="product-name"><?= htmlspecialchars($product['product_name']) ?></p>
              <p class="product-price"><?= number_format($product['price']) ?>円</p>

              <div class="product-actions">
                <!-- ❤️ お気に入りボタン（※未実装なら後でadd-favorite.phpに） -->
                <form action="add-favorite.php" method="post">
                  <input type="hidden" name="prod
