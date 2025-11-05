<?php
session_start();
require_once '../db-connect.php';

if (!isset($_SESSION['username'])) {
  header("Location: rogin.html");
  exit;
}

$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

$user_id = $user['id'];

$sql = "
  SELECT 
    cart.id AS cart_id,
    items.name,
    items.price,
    items.image_path,
    cart.quantity
  FROM cart
  JOIN items ON cart.item_id = items.id
  WHERE cart.user_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$user_id]);
$items = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
      <h1>POCKET ROOM</h1>
      <h2>カート</h2>
    </header>

    <main id="cart-container">
      <?php if ($items): ?>
        <?php foreach ($items as $item): ?>
          <div class="cart-item" data-id="<?= $item['cart_id'] ?>">
            <div class="cart-info">
              <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="">
              <p><?= htmlspecialchars($item['name']) ?><br><?= number_format($item['price']) ?>円</p>
            </div>

            <div class="cart-control">
              <button class="btn increase">＋</button>
              <span class="quantity"><?= $item['quantity'] ?></span>
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
          <?= number_format(array_sum(array_map(fn($i) => $i['price'] * $i['quantity'], $items))) ?>
        </span>円</p>
        <button class="buy-btn">購入する</button>
      </div>
    </main>
  </div>

  <nav class="bottom-nav">
    <div class="nav-item" onclick="location.href='home.php'">🏠<br>ホーム</div>
    <div class="nav-item" onclick="location.href='favorites.php'">❤️<br>お気に入り</div>
    <div class="nav-item" onclick="location.href='cart.php'">🧸<br>カート</div>
    <div class="nav-item" onclick="location.href='mypage.php'">👤<br>マイページ</div>
  </nav>

  <script>
    // JSで数量操作
    document.querySelectorAll('.cart-item').forEach(item => {
      const id = item.dataset.id;
      const quantityEl = item.querySelector('.quantity');
      const price = parseInt(item.querySelector('p').textContent.match(/\d+/)[0]);
      const totalEl = document.getElementById('total');

      const updateTotal = () => {
        let total = 0;
        document.querySelectorAll('.cart-item').forEach(ci => {
          const q = parseInt(ci.querySelector('.quantity').textContent);
          const p = parseInt(ci.querySelector('p').textContent.match(/\d+/)[0]);
          total += q * p;
        });
        totalEl.textContent = total.toLocaleString();
      };

      // ＋ボタン
      item.querySelector('.increase').addEventListener('click', async () => {
        const newQty = parseInt(quantityEl.textContent) + 1;
        const res = await fetch('cart_api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'increase', id })
        });
        if (res.ok) {
          quantityEl.textContent = newQty;
          updateTotal();
        }
      });

      // −ボタン
      item.querySelector('.decrease').addEventListener('click', async () => {
        const current = parseInt(quantityEl.textContent);
        if (current <= 1) return;
        const newQty = current - 1;
        const res = await fetch('cart_api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'decrease', id })
        });
        if (res.ok) {
          quantityEl.textContent = newQty;
          updateTotal();
        }
      });

      // 削除ボタン
      item.querySelector('.delete').addEventListener('click', async () => {
        if (!confirm("削除しますか？")) return;
        const res = await fetch('cart_api.php', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ action: 'delete', id })
        });
        if (res.ok) {
          item.remove();
          updateTotal();
        }
      });
    });
  </script>
</body>
</html>
