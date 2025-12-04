<?php
session_start();
require_once 'db-connect.php';
ini_set('display_errors', 1);
error_reporting(E_ALL);

// ----- ログインチェック -----
if (!isset($_SESSION['username'])) {
    die("ログインしていません。");
}

// ----- 商品IDがあるか確認 -----
if (!isset($_GET['id'])) {
    die("商品IDが指定されていません。");
}

$product_id = $_GET['id'];

// ----- DB から商品情報を取得 -----
$stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$product) {
    die("商品が見つかりません。");
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集</title>
    <link rel="stylesheet" href="../css-DS/costomer.css">
</head>
<body>

<div class="register">
    <h2>商品編集</h2>

    <form action="product-update.php" method="post" enctype="multipart/form-data">

        <label>商品ID（変更不可）</label>
        <input type="number" name="product_id" value="<?= $product['product_id'] ?>" readonly>

        <label>商品名</label>
        <input type="text" name="product_name" value="<?= $product['product_name'] ?>" required>

        <label>値段</label>
        <input type="number" name="price" value="<?= $product['price'] ?>" required>

        <label>カテゴリー</label>
        <input type="text" name="category" value="<?= $product['category'] ?>" required>

        <label>色</label>
        <input type="text" name="color" value="<?= $product['color'] ?>" required>

        <label>ジャンル</label>
        <input type="text" name="genre" value="<?= $product['genre'] ?>" required>

        <label>商品画像</label>
        <input type="file" name="img">
        <p>現在の画像：<?= $product['img'] ?></p>

        <button type="submit">更新する</button>
        <a href="mypage.php"><button type="button">戻る</button></a>

    </form>
</div>

</body>
</html>
