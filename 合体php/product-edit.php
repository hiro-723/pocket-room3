<?php
session_start();
require_once 'db-connect.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品編集</title>
  <link rel="stylesheet" href="../css-DS/product-edit.css">
</head>
<body>

<h1>商品編集</h1>

<?php
// ----------------------------
// 商品ID 未指定 → ID入力フォーム
// ----------------------------
if (!isset($_GET['id'])) {
?>
    <form method="get" action="product-edit.php">
        <label>編集したい商品のID：</label>
        <input type="number" name="id" required>
        <button type="submit">表示</button>
    </form>
<?php
    exit;
}


// ----------------------------
// 商品IDが指定された場合 → DBから取得
// ----------------------------
$product_id = $_GET['id'];

$stmt = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$stmt->execute([$product_id]);
$product = $stmt->fetch();

if (!$product) {
    echo "指定されたIDの商品は存在しません。";
    echo '<br><a href="product-edit.php">戻る</a>';
    exit;
}
?>

<!-- 商品編集フォーム -->
<form action="product-edit-act.php" method="post">
    <input type="hidden" name="product_id" value="<?php echo $product['product_id']; ?>">

    <label>商品名：</label>
<input type="text" name="product_name" value="<?php echo htmlspecialchars($product['product_name']); ?>" required>
<br><br>

<label>値段：</label>
<input type="number" name="price" value="<?php echo $product['price']; ?>" required>
<br><br>

<label>カテゴリー：</label>
<input type="text" name="category" value="<?php echo htmlspecialchars($product['category']); ?>" required>
<br><br>

<label>色：</label>
<input type="text" name="color" value="<?php echo htmlspecialchars($product['color']); ?>" required>
<br><br>

<label>ジャンル：</label>
<input type="text" name="genre" value="<?php echo htmlspecialchars($product['genre']); ?>" required>
<br><br>

<label>商品画像：</label>
<input type="file" name="img">
<br>
現在の画像：<?php echo $product['img'] ? $product['img'] : '登録なし'; ?>
<br><br>

    <button type="submit">更新する</button>
</form>

<br>
<button onclick="history.back()">戻る</button>

</body>
</html>
