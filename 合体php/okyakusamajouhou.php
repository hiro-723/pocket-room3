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
    echo "<p class='success'>変更が完了しました。</p>";
    echo "<p class='link'><a href='rogin.php'>ログインページへ</a></p>";
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
    <form>
      <input type="text" placeholder="名前">
      <input type="text" placeholder="都道府県">
      <input type="text" placeholder="市町村">
      <input type="text" placeholder="番地">
      <input type="text" placeholder="建物名">
      <input type="text" placeholder="電話番号・携帯番号">
      <input type="email" placeholder="メールアドレス">
      <input type="password" placeholder="パスワード">
      <button type="submit">変更する</button>
    </form>
  </div>
</body>
</html>
