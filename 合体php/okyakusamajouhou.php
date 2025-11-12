<?php
require_once 'db-connect.php';

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

    $sql = "INSERT INTO customer (name, kana, birth, prefecture, city, address, building, phone, email, password)
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$name, $kana, $birth, $prefecture, $city, $address, $building, $phone, $email, $password]);

    echo "<p class='success'>登録が完了しました。</p>";
    echo "<p class='link'><a href='login.html'>ログインページへ</a></p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>新規会員登録 | POCKET ROOM</title>
    <link rel="stylesheet" href="../合体css/style.css">
</head>
<body>
    <div class="register">
      <img src="../kuma/moji.png" class="moji">
    <h2>お客様情報</h2>
    <form>
      <input type="text" placeholder="名前">
      <input type="text" placeholder="フリガナ">
      <input type="text" placeholder="生年月日">
      <input type="text" placeholder="住所">
      <input type="text" placeholder="郵便番号">
      <input type="text" placeholder="電話番号・携帯番号">
      <input type="email" placeholder="メールアドレス">
      <input type="password" placeholder="パスワード">
      <button type="submit">変更する</button>
    </form>
  </div>
</body>
</html>
