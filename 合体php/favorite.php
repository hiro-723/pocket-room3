<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db-connect.php'; // PDO接続

// ログインチェック
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// ログイン中ユーザーのIDを取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報が見つかりません。");
}

$customer_id = $user['customer_id'];

// お気に入り一覧を取得
$sql = "
  SELECT 
    f.favorite_id,
    p.product_id,
    p.product_name,
    p.price,
    p.img
  FROM favorite f
  JOIN product p ON f.product_id = p.product_id
  WHERE f.customer_id = ?
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
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body>
  <div class="container">

    <!-- サイドメニュー -->
    <nav class="side-nav">
      <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorite.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <main class="content">
      <form action="search.php" method="get">
      <img src="../kuma/moji.png" class="moji">
      <input type="text" placeholder="検索" class="search-bar">

      <!-- ▼▼▼ グリッド：ここを DB から動的表示 ▼▼▼ -->
      <div class="grid">

        <?php if (empty($favorites)): ?>
          <p>お気に入り商品はありません。</p>
        <?php else: ?>
        
          <?php foreach ($favorites as $item): ?>
            <div class="item">
                <img src="../jpg/<?= htmlspecialchars($item['img']) ?>" class="product-img">
                <div class="name"><?= htmlspecialchars($item['product_name']) ?></div>
                <div class="price"><?= htmlspecialchars($item['price']) ?>円</div>

                <button class="delete-btn"
                        onclick="location.href='favorite-delete.php?id=<?= $item['favorite_id'] ?>'">
                    削除
                </button>
            </div>
          <?php endforeach; ?>

        <?php endif; ?>

      </div>
      <!-- ▲▲▲ グリッド終わり ▲▲▲ -->

    </main>
  </div>

  <script src="../js/favorite.js"></script>
</body>
</html>
