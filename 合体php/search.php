<?php
session_start();
require_once 'db-connect.php';

// ログインチェック
if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}
//カテゴリー取得
$category = isset($_GET['category']) ? trim($_GET['category']) : '';
// 検索キーワード取得
$keyword = isset($_GET['keyword']) ? trim($_GET['keyword']) : '';

// 検索処理
// 🔍 カテゴリ検索が優先
if ($category !== '') {
  $stmt = $pdo->prepare("
    SELECT * FROM product
    WHERE category = ?
  ");
  $stmt->execute([$category]);
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else if ($keyword !== '') {

  // 🔍 キーワード検索
  $stmt = $pdo->prepare("
    SELECT * FROM product 
    WHERE product_name LIKE :kw
       OR category LIKE :kw
       OR color LIKE :kw
       OR genre LIKE :kw
  ");
  $stmt->bindValue(':kw', "%{$keyword}%", PDO::PARAM_STR);
  $stmt->execute();
  $products = $stmt->fetchAll(PDO::FETCH_ASSOC);

} else {
  $products = [];
}
$stmt = $pdo->prepare("SELECT product_id FROM favorite WHERE customer_id = ?");
$stmt->execute([$customer_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_COLUMN);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <style>
    .item img.a {
      width: 150px;
      height: 150px;
      object-fit: cover;
      border-radius: 0 !important;
      background: none !important;
    }
  </style>
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
      <button onclick="location.href='favorite.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <!-- ✅ メインコンテンツ -->
    <main>
    <img src="../kuma/moji.png" class="moji" alt="タイトルロゴ">

      <!-- 🔍 検索フォーム -->
      <form action="search.php" method="get" class="search-box">
        <input type="text" name="keyword" value="<?= htmlspecialchars($keyword) ?>" placeholder="商品名・色・ジャンルで検索">
        <button type="submit"><i class="fas fa-search"></i></button>
      </form>

      <!-- 🧸 検索結果エリア -->
      <div class="grid">
        <?php if ($products): ?>
          <?php foreach ($products as $product): ?>
            <div class="item">
            <a href="product.php?id=<?= $product['product_id'] ?>" class="product-link">
              <?php if (!empty($product['img'])): ?>
              <img src="../jpg/<?=$product['product_id'] ?>.jpg" class="a">
              <?php else: ?>
                <div class="no-image">画像なし</div>
              <?php endif; ?>

              <p class="product-name"><?= htmlspecialchars($product['product_name']) ?></p>
              <p class="product-price"><?= number_format($product['price']) ?>円</p></a>

              <div class="aaa">
                <span>カテゴリ: <?= htmlspecialchars($product['category']) ?></span><br>
                <span>色: <?= htmlspecialchars($product['color']) ?></span><br>
                <span>ジャンル: <?= htmlspecialchars($product['genre']) ?></span>
              </div>

              <div class="product-actions">
                <!-- ❤️ お気に入りボタン -->
                <form action="favorite-insert.php" method="post">
                  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                  <button type="submit" class="fav-btn"><i class="fas fa-heart"></i></button>
                </form>

                <!-- 🛒 カート追加ボタン -->
                <form action="cart-insert.php" method="post">
                  <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
                  <button type="submit" class="cart-btn"><i class="fas fa-shopping-cart"></i></button>
                </form>
              </div>
            </div>
          <?php endforeach; ?>
        <?php else: ?>
          <p class="no-result">該当する商品がありません。</p>
        <?php endif; ?>
      </div>
    </main>
  </div>
</body>
</html>
