<?php
session_start();
require_once 'db-connect.php';
ini_set('display_errors',1);
error_reporting(E_ALL);

// ▼ 最初は空の商品データ
$product = null;

// ▼ 検索ボタンが押されたら商品を取得
if (isset($_GET['search_id'])) {
    $search_id = $_GET['search_id'];

    $stmt = $pdo->prepare("SELECT * FROM product WHERE product_id = ?");
    $stmt->execute([$search_id]);
    $product = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$product) {
        $msg = "商品が見つかりません。";
    }
}

// ▼ 更新処理（保存ボタン）
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    
    $id       = $_POST['product_id'];
    $name     = $_POST['product_name'];
    $price    = $_POST['price'];
    $category = $_POST['category'];
    $color    = $_POST['color'];
    $genre    = $_POST['genre'];

    // 画像アップロード処理
    if (!empty($_FILES['img']['name'])) {
        $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);
        $img_name = 'img_' . time() . '.' . $ext;
        $upload_path = "../upload/" . $img_name;
        move_uploaded_file($_FILES['img']['tmp_name'], $upload_path);
        
        $sql = "UPDATE product SET product_name=?, price=?, category=?, color=?, genre=?, img=? WHERE product_id=?";
        $params = [$name, $price, $category, $color, $genre, $img_name, $id];
    } else {
        $sql = "UPDATE product SET product_name=?, price=?, category=?, color=?, genre=? WHERE product_id=?";
        $params = [$name, $price, $category, $color, $genre, $id];
    }

    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);

    header("Location: mypage.php?msg=updated");
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>商品編集</title>
<link rel="stylesheet" href="../css-DS/product-edit.css">
</head>
<body>

<div class="container">
    <h2>商品編集</h2>

    <!-- ▼ 商品ID入力フォーム -->
    <form method="get">
        <label>商品IDを入力してください</label>
        <input type="number" name="search_id" required>
        <div class="btn-area">
          <button type="submit" class="yes">検索</button>
        </div>
    </form>

    <hr>

    <?php if (isset($msg)) echo "<p>$msg</p>"; ?>

    <?php if ($product): ?>
    <!-- ▼ 商品が見つかった場合に表示される編集フォーム -->
    <form action="" method="post" enctype="multipart/form-data">

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

      <div class="btn-area">
        <button type="submit">更新する</button>
        <a href="mypage.php"><button type="button" class="no">戻る</button></a>
    </div>
      </form>
    <?php endif; ?>

</div>

</body>
</html>
