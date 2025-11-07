<?php
session_start();
require_once '../db-connect.php';

if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

// 🔹 ユーザーの customer_id を取得
$stmt = $pdo->prepare("SELECT customer_id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_id = $user['customer_id'];

// 🔹 購入履歴を取得
$sql = "
  SELECT 
    p.purchase_id,
    pr.product_name,
    pr.price,
    pr.category,
    pr.color,
    pr.genre
  FROM purchase p
  JOIN product pr ON p.product_id = pr.product_id
  WHERE p.customer_id = ?
  ORDER BY p.purchase_id DESC
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$purchases = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入履歴 | POCKET ROOM</title>
  <link rel="stylesheet" href="../合体css/purchase_history.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>POCKET ROOM</h1>
      <h2>購入履歴</h2>
    </header>

    <main>
      <?php if (!empty($purchases)): ?>
        <?php foreach ($purchases as $item): ?>
          <div class="purchase-item">
            <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="">
            <div class="info">
              <p class="name"><?= htmlspecialchars($item['product_name']) ?></p>
              <p class="price"><?= number_format($item['price']) ?>円</p>
              <p class="id">購入ID：<?= $item['purchase_id'] ?></p>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>購入履歴がありません。</p>
      <?php endif; ?>
    </main>
  </div>

  <nav class="bottom-nav">
    <div class="nav-item" onclick="location.href='home.php'">🏠<br>ホーム</div>
    <div class="nav-item" onclick="location.href='favorite.php'">❤️<br>お気に入り</div>
    <div class="nav-item" onclick="location.href='cart.php'">🧸<br>カート</div>
    <div class="nav-item" onclick="location.href='mypage.php'">👤<br>マイページ</div>
  </nav>
</body>
</html>
