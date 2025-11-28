<?php
// パスワード確認後の遷移先（好きなページに変えてOK）
$target = "admin-menu.php";

// POSTされたらチェック
if ($_SERVER["REQUEST_METHOD"] === "POST") {

    $input_password = $_POST['password'];

    // ★ここだけ！ 正解パスワード1234
    if ($input_password === "1234") {
        header("Location: " . $target);
        exit;
    } else {
        $error = "パスワードが違います。";
    }
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<h2>管理者パスワード確認</h2>

<?php if (!empty($error)) echo "<p style='color:red;'>$error</p>"; ?>

<form action="" method="post">
    <input type="password" name="password" placeholder="パスワードを入力" required>
    <br>
    <button type="submit">送信</button>
</form>    
</body>
</html>