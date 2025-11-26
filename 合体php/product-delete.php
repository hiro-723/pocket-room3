<?php
require_once 'db-connect.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品削除</title>
  <link rel="stylesheet" href="../css-DS/product-delete.css">
</head>
<body>

<div class="container">

  <div class="thumb"></div>

  <h1>商品削除</h1>

  <p>商品名：<?= $item['product_name'] ?></p>
  <p>値段：<?= $item['price'] ?></p>
  <p>カテゴリー：<?= $item['category'] ?></p>
  <p>色：<?= $item['color'] ?></p>
  <p>ジャンル：<?= $item['genre'] ?></p>

  <p class="confirm-text">この商品を削除しますか？</p>

  <div class="btn-area">
    <a class="yes" href="product-delete-act.php?id=<?= $item['product_id'] ?>">はい</a>
    <button class="no" onclick="history.back()">いいえ</button>
  </div>

</div>

</body>
</html>
