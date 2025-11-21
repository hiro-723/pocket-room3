<?php
// DB接続（パスは環境に合わせて変更）
require_once '../db_connect.php';

// 更新対象の商品IDを取得
$id = $_GET['id'] ?? null;

// IDが無い場合は管理者画面に戻す
if ($id === null) {
  header('Location: admin.php');
  exit;
}

// 商品情報の取得
$sql = "SELECT * FROM products WHERE id = :id";
$stmt = $pdo->prepare($sql);
$stmt->bindValue(':id', $id, PDO::PARAM_INT);
$stmt->execute();
$product = $stmt->fetch(PDO::FETCH_ASSOC);

// 商品が存在しない場合は戻す
if (!$product) {
  header('Location: admin.php');
  exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>商品更新画面</title>
  <link rel="stylesheet" href="../css/update.css">
</head>
<body>
  <div class="container">
    <h2>商品更新画面</h2>

    <div class="product-card">
      <!-- サムネ画像（画像がある場合のみ表示） -->
      <div class="image-box">
        <?php if (!empty($product['image'])): ?>
          <img src="../uploads/<?= htmlspecialchars($product['image'], ENT_QUOTES) ?>" 
               alt="" style="width:150px; height:120px; border-radius:3px;">
        <?php endif; ?>
      </div>

      <p class="product-name"><?= htmlspecialchars($product['name'], ENT_QUOTES) ?></p>
      <p class="product-desc"><?= htmlspecialchars($product['description'], ENT_QUOTES) ?></p>
    </div>

    <p class="confirm-text">この商品を更新しますか？</p>

    <div class="button-group">
      <!-- はい → 更新実行へ -->
      <form action="product_update_done.php" method="post">
        <input type="hidden" name="id" value="<?= $product['id'] ?>">
        <button class="yes" type="submit">はい</button>
      </form>

      <!-- いいえ → 管理者画面へ -->
      <button class="no" onclick="location.href='admin.php'">いいえ</button>
    </div>
  </div>
</body>
</html>
