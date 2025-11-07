<?php
session_start();
require_once 'db-connect.php'; // DB接続ファイル

$message = '';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // メールアドレスの重複チェック
    $check_sql = "SELECT * FROM customer WHERE email = ?";
    $check_stmt = $pdo->prepare($check_sql);
    $check_stmt->execute([$email]);
    $existing_user = $check_stmt->fetch(PDO::FETCH_ASSOC);

    if ($existing_user) {
        $message = "このメールアドレスはすでに登録されています。";
    } else {
        // ハッシュ化しないでそのまま保存
        $sql = "INSERT INTO customer (email, password) VALUES (?, ?)";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$email, $password]);

        $message = "登録が完了しました。ログインしてください。";
        header("Location: rogin.php");
        exit;
    }
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
        <h1>POCKET ROOM</h1>
        <h2>新規会員登録</h2>

        <?php if ($message): ?>
            <p class="message"><?= htmlspecialchars($message, ENT_QUOTES, 'UTF-8') ?></p>
        <?php endif; ?>

        <form action="rogin.php" method="post">
            <label>メールアドレス</label>
            <input type="email" name="email" required>

            <label>パスワード</label>
            <input type="password" name="password" required>

            <input type="submit" value="登録する">
        </form>
    </div>
</body>
</html>
