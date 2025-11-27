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

// ✅ 合計金額を最初に初期化
$total = 0;

// ✅ 商品がある場合のみ計算
if ($cartItems) {
  foreach ($cartItems as $item) {
    $total += (int)$item['price']; // 数量1として計算
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カート | POCKET ROOM</title>
  <link rel="stylesheet" href="../css-DS/cart.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
  <div class="container">

    <!-- ✅ 左ナビ -->
    <nav class="side-nav">
      <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorite.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <!-- ✅ メイン部分 -->
    <main>
      <img src="../kuma/moji.png" class="moji">
      <h2>カート</h2>

      <?php if ($cartItems): ?>
        <?php foreach ($cartItems as $item): ?>
          <div class="cart-item">
            <div class="item-box">
              <?php if (!empty($item['img'])): ?>
              <img src="../jpg/<?=$item['product_id'] ?>.jpg" class="a">
              <?php endif; ?>
              <p><?= htmlspecialchars($item['product_name']) ?><br><?= number_format($item['price']) ?>円</p>
            </div>

            <!-- ✅ 数量調整エリア -->
            <div class="qty">
              <span class="plus" data-price="<?= (int)$item['price'] ?>">＋</span>
              <span class="num">1</span>
              <span class="minus" data-price="<?= (int)$item['price'] ?>">－</span>
            </div>

            <!-- ✅ 削除ボタン -->
            <form action="cart-delete.php" method="post" style="display:inline;">
              <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']) ?>">
              <button type="submit" class="delete-btn">削除</button>
            </form>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>カートに商品がありません。</p>
      <?php endif; ?>

      <!-- ✅ 合計金額 -->
      <div class="total">
        <p>合計金額 <span id="total"><?= number_format($total) ?></span>円</p>

        <?php if ($cartItems): ?>
          <form action="purchase.php" method="post">
            <button type="submit" class="buy-btn">購入する</button>
          </form>
        <?php else: ?>
          <button class="buy-btn" disabled style="opacity:0.6; cursor:not-allowed;">購入する</button>
        <?php endif; ?>
      </div>
    </main>
  </div>

  <script>
  document.addEventListener('DOMContentLoaded', () => {
    const totalDisplay = document.getElementById('total');
    const cartItems = document.querySelectorAll('.cart-item');

    // ✅ 合計を再計算する関数
    function updateTotal() {
      let total = 0;
      cartItems.forEach(item => {
        const price = parseInt(item.querySelector('.plus').dataset.price);
        const qty = parseInt(item.querySelector('.num').textContent);
        total += price * qty;
      });
      totalDisplay.textContent = total.toLocaleString();
    }

    // ✅ 各商品の＋／−ボタンにイベントを付与
    cartItems.forEach(item => {
      const plus = item.querySelector('.plus');
      const minus = item.querySelector('.minus');
      const num = item.querySelector('.num');

      plus.addEventListener('click', () => {
        let qty = parseInt(num.textContent);
        num.textContent = qty + 1;
        updateTotal();
      });

      minus.addEventListener('click', () => {
        let qty = parseInt(num.textContent);
        if (qty > 1) {
          num.textContent = qty - 1;
          updateTotal();
        }
      });
    });

    // ✅ 初期計算
    updateTotal();
  });
  </script>

</body>
</html>
