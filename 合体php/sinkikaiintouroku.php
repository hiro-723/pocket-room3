<?php
require_once 'db-connect.php';

// ▼ 登録処理（フォーム送信されたときだけ実行）
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name       = $_POST['name'];
    $kana       = $_POST['kana'];
    $birth      = $_POST['birth'];
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
    <div class="container">
        <img src="../kuma/aikon.png" alt="POCKET ROOM ロゴ">
        <h1>新規会員登録</h1>
        <form action="rogin.php" method="post">
            <label>名前</label>
            <input type="text" name="name" required>

            <label>フリガナ</label>
            <input type="text" name="kana" required>

            <label>生年月日</label>
            <input type="date" name="birth" required>

            <label>都道府県</label>
            <input type="text" name="prefecture" required>

            <label>市区町村</label>
            <input type="text" name="city" required>

            <label>番地</label>
            <input type="text" name="address" required>

            <label>建物名・部屋番号</label>
            <input type="text" name="building">

            <label>電話番号</label>
            <input type="tel" name="phone" required>

            <label>メールアドレス</label>
            <input type="email" name="email" required>

            <label>パスワード</label>
            <input type="password" name="password" required>

            <button type="submit">登録する</button>
        </form>
    </div>
</body>
</html>
