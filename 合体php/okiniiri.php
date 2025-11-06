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
  <link rel="stylesheet" href="../合体css/okiniiri.css">
</head>
<body>
  <div class="container">
    <header>
      <img src="../kuma/moji.png" alt="pocket room">
    </header>

    <main>
      <?php if (empty($favorites)): ?>
        <p>お気に入りに登録された商品はありません。</p>
      <?php else: ?>
        <div class="favorite-list">
          <?php foreach ($favorites as $item): ?>
            <div class="favorite-item">
              <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="">
              <div class="info">
                <h2><?= htmlspecialchars($item['product_name']) ?></h2>
                <p class="price">¥<?= htmlspecialchars($item['price']) ?></p>
                <div class="actions">
                  <button class="remove-btn" data-id="<?= $item['favorite_id'] ?>">削除</button>
                  <button class="add-cart-btn" data-id="<?= $item['product_id'] ?>">カートに追加</button>
                </div>
              </div>
            </div>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>
    </main>
  </div>

   <nav class="bottom-nav">
      <div class="nav-item" onclick="location.href='home.php'">🏠<br><span>ホーム</span></div>
      <div class="nav-item" onclick="location.href='okiniiri.php'">❤️<br><span>お気に入り</span></div>
      <div class="nav-item" onclick="location.href=''">🧸<br><span></span></div>
      <div class="nav-item" onclick="location.href='cart.html'">🛒<br><span>カート</span></div>
      <div class="nav-item" onclick="location.href='mypage.html'">👤<br><span>マイページ</span></div>
  </nav>

  <script src="../js/favorite.js"></script>
</body>
</html>
