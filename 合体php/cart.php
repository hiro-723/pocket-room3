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
    <header>
      <img src="../kuma/moji.png" alt="pocket room">
      <h2>カート</h2>
    </header>

    <main id="cart-container">
      <?php if ($cartItems): ?>
        <?php foreach ($cartItems as $item): ?>
          <div class="cart-item" data-id="<?= $item['cart_id'] ?>">
            <div class="cart-info">
              <?php if (!empty($item['img'])): ?>
                <img src="../img/<?= htmlspecialchars($item['img']) ?>" alt="商品画像">
              <?php endif; ?>
              <p><?= htmlspecialchars($item['product_name']) ?><br><?= number_format($item['price']) ?>円</p>
            </div>

            <div class="cart-control">
              <button class="btn increase">＋</button>
              <span class="quantity">1</span>
              <button class="btn decrease">−</button>

              <form action="cart-delete.php" method="post" style="display:inline;">
                <input type="hidden" name="cart_id" value="<?= htmlspecialchars($item['cart_id']) ?>">
                <button type="submit" class="btn delete">削除</button>
              </form>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>カートに商品がありません。</p>
      <?php endif; ?>

      <div class="cart-total">
        <p>合計金額: <span id="total"><?= number_format($total) ?></span>円</p>

        <?php if ($cartItems): ?>
          <!-- ✅ カートに商品がある場合のみ購入可能 -->
          <form action="purchase.php" method="post">
            <button type="submit" class="buy-btn">購入する</button>
          </form>
        <?php else: ?>
          <!-- ✅ 商品がない場合は無効化 -->
          <button class="buy-btn" disabled style="opacity:0.6; cursor:not-allowed;">購入する</button>
        <?php endif; ?>
      </div>
    </main>
  </div>


  <nav class="side-nav">
    <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
    <button onclick="location.href='favorites.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
    <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
    <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
    <img src="../kuma/kuma.png" class="bear-icon">
  </nav>
<script>
document.addEventListener('DOMContentLoaded', () => {
  const cartItems = document.querySelectorAll('.cart-item');
  const totalDisplay = document.getElementById('total');

  function updateTotal() {
    let total = 0;
    cartItems.forEach(item => {
      const quantityEl = item.querySelector('.quantity');
      const price = parseInt(quantityEl.dataset.price);
      const quantity = parseInt(quantityEl.textContent);
      total += price * quantity;
    });
    totalDisplay.textContent = total.toLocaleString();
  }

  cartItems.forEach(item => {
    const increaseBtn = item.querySelector('.increase');
    const decreaseBtn = item.querySelector('.decrease');
    const quantityEl = item.querySelector('.quantity');

    increaseBtn.addEventListener('click', () => {
      let qty = parseInt(quantityEl.textContent);
      quantityEl.textContent = qty + 1;
      updateTotal();
    });

    decreaseBtn.addEventListener('click', () => {
      let qty = parseInt(quantityEl.textContent);
      if (qty > 1) {
        quantityEl.textContent = qty - 1;
        updateTotal();
      }
    });
  });

  // 初期計算
  updateTotal();
});
</script>

</body>
</html>
