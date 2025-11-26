<?php
session_start(); 
require_once 'db-connect.php';
ini_set('display_errors',1);
error_reporting(E_ALL);

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
    $stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
    $stmt->execute([$_SESSION['username']]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
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
    $stmt->execute([
        $name, $prefecture, $city, $address, $building,
        $phone, $email, $password, $customer_id
    ]);
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録 | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/costomer.css">
</head>
<body>
    <div class="register">
      <img src="../kuma/moji.png" class="moji">
    <h2>お客様情報</h2>
    <form action="" method="post">
      <input type="text" name="name" placeholder="名前">
      <input type="text" name="prefecture" placeholder="都道府県">
      <input type="text" name="city" placeholder="市町村">
      <input type="text" name="address" placeholder="番地">
      <input type="text" name="building" placeholder="建物名">
      <input type="text" name="phone" placeholder="電話番号・携帯番号">
      <input type="email" name="email" placeholder="メールアドレス">
      <input type="password" name="password" placeholder="パスワード">
      <button type="submit">変更する</button>
      <button type="button">戻る</button>
    </form>
  </div>
</body>
</html>
