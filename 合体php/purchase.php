<?php
session_start();
require_once '../db-connect.php';

if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

// 🔹 ユーザーID取得
$stmt = $pdo->prepare("SELECT customer_id FROM users WHERE username = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);
$customer_id = $user['customer_id'];

// 🔹 購入処理（はいが押されたとき）
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['confirm'])) {
  $payment = $_POST['payment'];

  // カートの中身を取得
  $stmt = $pdo->prepare("
    SELECT c.product_id
    FROM cart c
    WHERE c.customer_id = ?
  ");
  $stmt->execute([$customer_id]);
  $items = $stmt->fetchAll(PDO::FETCH_ASSOC);

  if (!empty($items)) {
    try {
      $pdo->beginTransaction();

      // 🔸 購入履歴テーブルに登録
      $stmt = $pdo->prepare("INSERT INTO purchase (customer_id, product_id) VALUES (?, ?)");
      foreach ($items as $i) {
        $stmt->execute([$customer_id, $i['product_id']]);
      }

      // 🔸 カートを空に
      $stmt = $pdo->prepare("DELETE FROM cart WHERE customer_id = ?");
      $stmt->execute([$customer_id]);

      $pdo->commit();

      $message = "購入が完了しました！ご利用ありがとうございました。";
    } catch (Exception $e) {
      $pdo->rollBack();
      $message = "購入処理中にエラーが発生しました。";
    }
  } else {
    $message = "カートが空です。";
  }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>購入 | POCKET ROOM</title>
  <link rel="stylesheet" href="../合体css/purchase.css">
</head>
<body>
  <div class="container">
    <header>
        <img src="../kuma/moji.png" alt="pocket room">
      <h2>購入</h2>
    </header>

    <main>
      <?php if (!empty($message)): ?>
        <p style="color:green;"><?= htmlspecialchars($message) ?></p>
      <?php else: ?>
        <form method="POST">
          <div class="payment-box">
            <label><input type="radio" name="payment" value="クレジットカード" checked> クレジットカード</label><br>
            <label><input type="radio" name="payment" value="PayPay"> PayPay</label><br>
            <label><input type="radio" name="payment" value="後払い（ペイディ）"> 後払い（ペイディ）</label>
          </div>

          <h3>購入いたしますか？</h3>

          <button type="submit" name="confirm" class="yes-btn">はい</button>
          <button type="button" class="no-btn" onclick="location.href='cart.php'">いいえ</button>
        </form>
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
