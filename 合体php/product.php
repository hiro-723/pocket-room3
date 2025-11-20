<?php
session_start();
require_once 'db-connect.php';

// ログインチェック
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// 商品ID確認
if (!isset($_GET['id'])) {
    exit("商品IDがありません");
}

$product_id = $_GET['id'];

// 商品情報取得
$stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    exit("商品が見つかりません");
}

// ログイン中のユーザーID取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_id = $user['customer_id'];

// お気に入り登録済か判定
$stmt = $pdo->prepare("SELECT 1 FROM favorite WHERE customer_id = ? AND product_id = ?");
$stmt->execute([$customer_id, $product_id]);
$is_favorite = $stmt->fetchColumn();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title><?= htmlspecialchars($product['product_name']) ?> | 商品詳細</title>
  <link rel="stylesheet" href="../css-DS/product.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
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

    <!-- メイン -->
    <main class="content">

      <h1 class="logo">POCKET ROOM</h1>

      <div class="product">

        <!-- 商品画像 -->
        <div class="image">
          <img src="../img/<?= htmlspecialchars($product['product_id']) ?>.jpg" class="product-img">
        </div>

        <!-- 商品説明 -->
        <div class="desc">
          <h2 class="actions"><?= htmlspecialchars($product['product_name']) ?></h2>
          <p class="product-price"><?= number_format($product['price']) ?>円</p>
          <p class="product-desc"><?= nl2br(htmlspecialchars($product['description'])) ?></p>

          <!-- お気に入り / カート追加ボタン -->
          <div class="ine-cart">

            <!-- お気に入り -->
            <form action="favorite-insert.php" method="post">
              <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
              <button type="submit" class="heart">
                <i class="fas fa-heart <?= $is_favorite ? 'active' : '' ?>"></i>
              </button>
            </form>

            <!-- カート追加 -->
            <form action="cart-insert.php" method="post">
              <input type="hidden" name="product_id" value="<?= $product['product_id'] ?>">
              <button type="submit" class="fa-solid fa-cart-plus">
                <i class="fas fa-shopping-cart"></i> カートに追加
              </button>
            </form>

          </div>
        </div>
      </div>

    </main>
  </div>
</body>
</html>
