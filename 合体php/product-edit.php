<?php
require_once '../db-connect.php';

$id = $_GET['id'];
$stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->execute([$id]);
$item = $stmt->fetch();
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品更新</title>
  <link rel="stylesheet" href="../css-DS/product-edit.css">
</head>
<body>

<div class="container">

  <form action="product-edit-act.php" method="post" enctype="multipart/form-data">
    <input type="hidden" name="product_id" value="<?= $item['product_id'] ?>">

    <div class="thumb"></div>

    <h1>商品更新</h1>

    <input type="text" name="product_name" value="<?= $item['product_name'] ?>" required>
    <input type="number" name="price" value="<?= $item['price'] ?>" required>
    <input type="text" name="category" value="<?= $item['category'] ?>" required>
    <input type="text" name="color" value="<?= $item['color'] ?>" required>
    <input type="text" name="genre" value="<?= $item['genre'] ?>" required>

    <p>画像を変更する場合は選択してください</p>
    <input type="file" name="img">

    <p class="confirm-text">この商品を更新しますか？</p>

    <div class="btn-area">
      <button type="submit" class="yes">はい</button>
      <button type="button" class="no" onclick="history.back()">いいえ</button>
    </div>

  </form>

</div>

</body>
</html>
