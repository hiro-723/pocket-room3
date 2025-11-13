<?php
session_start();
require_once 'db-connect.php';

// ログインチェック
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

// 「はい」が押された場合
if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["confirm"])) {
  // カート削除
  $stmt = $pdo->prepare("DELETE FROM cart WHERE customer_id = ?");
  $stmt->execute([$customer_id]);

  echo "<p>購入が完了しました！ありがとうございました。</p>";
  echo "<a href='home.php'>ホームに戻る</a>";
  exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入確認 | POCKET ROOM</title>
  <link rel="stylesheet" href="../css-DS/purchase.css">
</head>
<body>
  <div class="container">
    <nav class="side-nav">
      <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorites.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <main>
      <h1>POCKET ROOM</h1>
      <h2>購入</h2>

      <form method="post">
        <div class="payment-options">
          <label><input type="radio" name="payment" value="credit" checked> クレジットカード</label><br>
          <label><input type="radio" name="payment" value="paypay"> PayPay</label><br>
          <label><input type="radio" name="payment" value="payday"> 後払い（ペイディ）</label>
        </div>

        <p>購入いたしますか？</p>
        <button type="submit" name="confirm" class="yes-btn">はい</button>
        <button type="button" class="no-btn" onclick="location.href='cart.php'">いいえ</button>
      </form>
    </main>
  </div>
</body>
</html>
