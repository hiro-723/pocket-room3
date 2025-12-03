<?php
session_start(); 
require_once 'db-connect.php';
ini_set('display_errors',1);
error_reporting(E_ALL);

// ▼ ログインしていない場合ログインへ
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

$error = "";

// ▼ 登録処理（フォーム送信されたときだけ実行）
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $name       = $_POST['name'];
    $prefecture = $_POST['prefecture'];
    $city       = $_POST['city'];
    $address    = $_POST['address'];
    $building   = $_POST['building'];
    $phone      = $_POST['phone'];
    $email      = $_POST['email'];
    $password   = $_POST['password'];

    // ▼ ログインしているユーザーの ID を取得
    $stmt = $pdo->prepare("SELECT * FROM customer WHERE customer_id = ?");
    $stmt->execute([$_SESSION['customer_id']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if (!$user) {
    

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
    } else {
    // レコードが無い → INSERT
    $sql = "INSERT INTO customer
            (customer_name, prefecture, city, address, building, phone_number, email, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $success = $stmt->execute([
        $name, $prefecture, $city, $address, $building,
        $phone, $email, $password
    ]);
}

    if ($success) {

        // メールアドレスを変更した場合はセッションも更新
        $_SESSION['username'] = $email;

        header("Location: mypage.php?update=1");
        exit;

    } else {
        $error = "更新に失敗しました。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>お客様情報入力 | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/costomer.css">
</head>
<body>
    <div class="register">
        <img src="../kuma/moji.png" class="moji">
        <h2>お客様情報</h2>

        <?php if (!empty($error)): ?>
            <p style="color:red;"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="okyakusamajouhou.php" method="post">
            <input type="text" name="name" placeholder="名前" required>
            <input type="text" name="prefecture" placeholder="都道府県" required>
            <input type="text" name="city" placeholder="市町村" required>
            <input type="text" name="address" placeholder="番地" required>
            <input type="text" name="building" placeholder="建物名">
            <input type="text" name="phone" placeholder="電話番号・携帯番号" required>
            <input type="email" name="email" placeholder="メールアドレス" required>
            <input type="password" name="password" placeholder="パスワード" required>

            <button type="submit">変更する</button>
            <a href="mypage.php"><button type="button">戻る</button></a>
        </form>
    </div>
</body>
</html>
