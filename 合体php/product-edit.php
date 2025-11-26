<?php
session_start();
require_once 'db-connect.php';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品編集</title>
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
    <input type="text" name="name" value="<?php echo htmlspecialchars($product['name']); ?>" required>
    <br><br>

    <label>価格：</label>
    <input type="number" name="price" value="<?php echo $product['price']; ?>" required>
    <br><br>

    <label>在庫：</label>
    <input type="number" name="stock" value="<?php echo $product['stock']; ?>" required>
    <br><br>

    <button type="submit">更新する</button>
</form>

<br>
<button onclick="history.back()">戻る</button>

</body>
</html>
