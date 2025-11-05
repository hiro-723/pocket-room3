<?php
session_start();
require_once '../db-connect.php'; // ← DB接続

// ログインしていなければログインページへ
if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

$username = $_SESSION['username'];

// ユーザー情報取得（例：usersテーブルからID取得）
$stmt = $pdo->prepare("SELECT id FROM users WHERE username = ?");
$stmt->execute([$username]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
  die("ユーザーが見つかりません。");
}

$user_id = $user['id'];

// お気に入り商品をDBから取得
$sql = "
  SELECT items.id, items.name, items.price, items.image_path
  FROM favorites
  JOIN items ON favorites.item_id = items.id
  WHERE favorites.user_id = ?
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
  <title>お気に入り | POCKET ROOM</title>
  <link rel="stylesheet" href="../合体css/favorites.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>POCKET ROOM</h1>
      <div class="search-bar">
        <input type="text" id="search" placeholder="🔍 検索">
      </div>
    </header>

    <main class="item-grid" id="item-list">
      <?php if (count($items) > 0): ?>
        <?php foreach ($items as $item): ?>
          <div class="item-card">
            <img src="<?= htmlspecialchars($item['image_path']) ?>" alt="<?= htmlspecialchars($item['name']) ?>">
            <p><?= htmlspecialchars($item['name']) ?><br><?= number_format($item['price']) ?>円</p>
            <div class="item-icons">
              <span class="favorite" data-id="<?= $item['id'] ?>">❤️</span>
              <span class="cart" data-id="<?= $item['id'] ?>">🛒</span>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p style="text-align:center;">お気に入りはまだありません。</p>
      <?php endif; ?>
    </main>
  </div>

  <nav class="bottom-nav">
    <div class="nav-item" onclick="location.href='home.php'">🏠<br><span>ホーム</span></div>
    <div class="nav-item" onclick="location.href='favorites.php'">❤️<br><span>お気に入り</span></div>
    <div class="nav-item" onclick="location.href='cart.php'">🧸<br><span>カート</span></div>
    <div class="nav-item" onclick="location.href='mypage.php'">👤<br><span>マイページ</span></div>
  </nav>

  <script>
    // 🔎 検索バー
    document.getElementById("search").addEventListener("input", function() {
      const keyword = this.value.toLowerCase();
      document.querySelectorAll(".item-card").forEach(card => {
        const name = card.querySelector("p").textContent.toLowerCase();
        card.style.display = name.includes(keyword) ? "block" : "none";
      });
    });

    // 🛒 カート追加（仮アラート）
    document.querySelectorAll(".cart").forEach(btn => {
      btn.addEventListener("click", () => {
        alert("カートに追加しました！");
      });
    });
  </script>
</body>
</html>
