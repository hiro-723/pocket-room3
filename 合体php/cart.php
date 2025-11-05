<?php
session_start();

// ログイン確認（ログインしていなければログインページへ）
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// 合計金額（例: セッションから計算する）
$total = isset($_SESSION['total']) ? $_SESSION['total'] : 10000;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カート | POCKET ROOM</title>
  <link rel="stylesheet" href="../css/cart.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>POCKET ROOM</h1>
      <h2>カート</h2>
    </header>

    <main>
      <div class="cart-item">
        <div class="item-info">カートに<br>入っている<br>商品の表示</div>
        <div class="item-control">
          <span class="plus">＋</span>
          <span class="quantity">1</span>
          <span class="minus">－</span>
          <button class="delete-btn">削除</button>
        </div>
      </div>

      <div class="cart-item">
        <div class="item-info">カートに<br>入っている<br>商品の表示</div>
        <div class="item-control">
          <span class="plus">＋</span>
          <span class="quantity">1</span>
          <span class="minus">－</span>
          <button class="delete-btn">削除</button>
        </div>
      </div>

      <div class="total-section">
        <p>合計金額<br><span class="price"><?php echo number_format($total); ?>円</span></p>
        <button class="buy-btn">購入する</button>
      </div>
    </main>
  </div>

  <nav class="bottom-nav">
    <div class="nav-item" onclick="location.href='home.php'">🏠<br><span>ホーム</span></div>
    <div class="nav-item" onclick="location.href='favorites.html'">❤️<br><span>お気に入り</span></div>
    <div class="nav-item" onclick="location.href='item.html'">🧸<br><span>商品</span></div>
    <div class="nav-item" onclick="location.href='cart.php'">🛒<br><span>カート</span></div>
    <div class="nav-item" onclick="location.href='mypage.html'">👤<br><span>マイページ</span></div>
  </nav>
</body>
</html>
