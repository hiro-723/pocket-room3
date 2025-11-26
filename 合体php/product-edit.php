<?php 
session_start();
require_once 'db-connect.php';
ini_set('display_errors',1);
error_reporting(E_ALL);

// ---------------------
// 商品IDが指定されていれば取得
// ---------------------
$product = null;

if (isset($_GET['id'])) {
    $id = $_GET['id'];

    $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->execute([$id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        echo "商品が見つかりません。";
        exit;
    }
}

// ---------------------
// 更新処理
// ---------------------
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $id       = $_POST['product_id'];
    $name     = $_POST['product_name'];
    $price    = $_POST['price'];
    $category = $_POST['category'];
    $color    = $_POST['color'];
    $genre    = $_POST['genre'];

    // 画像処理
    $img_name = $product['img']; // 元の画像

    if (!empty($_FILES['img']['name'])) {
        $img_name = 'img_' . time() . '.jpg';
        move_uploaded_file($_FILES['img']['tmp_name'], "../upload/$img_name");
    }

    // UPDATE
    $sql = "
        UPDATE product SET
            product_name = ?,
            price = ?,
            category = ?,
            color = ?,
            genre = ?,
            img = ?
        WHERE product_id = ?
    ";

    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([$name, $price, $category, $color, $genre, $img_name, $id]);

    if ($success) {
        header("Location: mypage.php");
        exit;
    } else {
        $error = "更新に失敗しました。もう一度お試しください。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>商品編集 | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/costomer.css">
</head>
<body>
<div class="register">
    <img src="../kuma/moji.png" class="moji">
    <h2>商品編集</h2>

    <form action="" method="post" enctype="multipart/form-data">
        
        <label>商品ID（変更不可）</label>
        <input type="number" name="product_id" value="<?php echo $product['product_id']; ?>" readonly>

        <label>商品名</label>
        <input type="text" name="product_name" value="<?php echo $product['product_name']; ?>" required>

        <label>値段</label>
        <input type="number" name="price" value="<?php echo $product['price']; ?>" required>

        <label>カテゴリー</label>
        <input type="text" name="category" value="<?php echo $product['category']; ?>" required>

        <label>色</label>
        <input type="text" name="color" value="<?php echo $product['color']; ?>" required>

        <label>ジャンル</label>
        <input type="text" name="genre" value="<?php echo $product['genre']; ?>" required>

        <label>商品画像</label>
        <input type="file" name="img">
        <p>現在の画像：<?php echo $product['img']; ?></p>

        <button type="submit">更新する</button>

        <a href="mypage.php"><button type="button">戻る</button></a>
    </form>
</div>
</body>
</html>
