<?php 
session_start();
require_once 'db-connect.php';
ini_set('display_errors',1);
error_reporting(E_ALL);

if (!isset($_SESSION['username'])) {
    die("ログインしていません。");
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name       = $_POST['name'];
    $prefecture = $_POST['prefecture'];
    $city       = $_POST['city'];
    $address    = $_POST['address'];
    $building   = $_POST['building'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    // ▼ ログインユーザーの customer_id を取得
    $stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
        die("ユーザー情報が取得できませんでした。");
    }

    $customer_id = $user['customer_id'];

    // ▼ UPDATE 文
    $sql = "
        UPDATE customer SET
            customer_name = ?,
            prefecture = ?,
            city = ?,
            address = ?,
            building = ?,
            phone_number = ?,
            email = ?,
            password = ?
        WHERE customer_id = ?
    ";

    $stmt = $pdo->prepare($sql);

    $success = $stmt->execute([
        $name, $prefecture, $city, $address, $building,
        $phone, $email, $password, $customer_id
    ]);

    if ($success) {
        // メール変更した場合セッションも更新
        $_SESSION['username'] = $email;

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
