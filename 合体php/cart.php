<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db-connect.php';

// セッションチェック
if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

// ログイン中のユーザー情報取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  echo "ユーザー情報が見つかりません。";
  exit;
}

$customer_id = $user['customer_id'];

// カート情報取得
$sql = "
  SELECT 
    cart.cart_id,
    product.product_name,
    product.price,
    product.img,
    cart.product_id
  FROM cart
  JOIN product ON cart.product_id = product.product_id
  WHERE cart.customer_id = ?
";

$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カート | POCKET ROOM</title>
  <link rel="stylesheet" href="../合体css/cart.css">
</head>
<body>
  <div class="container">
    <header>
      <img src="../kuma/moji.png" alt="pocket room">
      <h2>カート</h2>
    </header>

    <main id="cart-container">
      <?php if ($cartItems): ?>
        <?php foreach ($cartItems as $item): ?>
          <div class="cart-item" data-id="<?= $item['cart_id'] ?>">
            <div class="cart-info">
              <img src="<?= htmlspecialchars($item['img']) ?>" alt="">
              <p><?= htmlspecialchars($item['product_name']) ?><br><?= number_format($item['price']) ?>円</p>
            </div>

            <div class="cart-control">
              <button class="btn increase">＋</button>
              <span class="quantity">1</span>
              <button class="btn decrease">−</button>
              <button class="btn delete">削除</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>カートに商品がありません。</p>
      <?php endif; ?>

      <div class="cart-total">
        <p>合計金額: <span id="total">
          <?= number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $cartItems))) ?>
        </span>円</p>
        <button class="buy-btn">購入する</button>
      </div>
    </main>
  </div>

  <nav class="bottom-nav">
    <div class="nav-item" onclick="location.href='home.php'">🏠<br>ホーム</div>
    <div class="nav-item" onclick="location.href='favorites.php'">❤️<br>お気に入り</div>
    <img src="../kuma/ya.png" alt="aikon">
    <div class="nav-item" onclick="location.href='cart.php'">🧸<br>カート</div>
    <div class="nav-item" onclick="location.href='mypage.php'">👤<br>マイページ</div>
  </nav>
</body>
</html>
