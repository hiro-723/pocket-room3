<?php
session_start();
ini_set('display_errors', 1);
error_reporting(E_ALL);
require_once 'db-connect.php';

$error = "";

// ▼ フォーム送信時（POST）のみ処理
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST["username"];
    $pass = $_POST["pass"];

    // DBから管理者情報取得（メール一致）
    $sql = "SELECT * FROM admins WHERE username = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $admin = $stmt->fetch(PDO::FETCH_ASSOC);

    // ▼ パスワード平文チェック
    if ($admin && $pass === $admin["pass"]) {

        // ログイン成功 → セッション保存
        $_SESSION["admin_id"] = $admin["id"];
        $_SESSION["admin_username"] = $admin["username"];

        // 管理者メニューへ
        header("Location: admin-menu.php");
        exit;

    } else {
        // 認証失敗
        $error = "メールアドレスまたはパスワードが違います。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>管理者ログイン | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/login.css">
</head>

<body>
    <div class="container">
        <img src="../kuma/aikon.png" alt="POCKET ROOM">

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>
            <h1>管理者設定</h1>
        <form action="" method="post">
            <label>ユーザーネーム</label>
            <input type="text" name="username" required>

            <label>パスワード</label>
            <input type="password" name="pass" required>

            <button type="submit">ログインする</button>
        </form>
    </div>
</body>
</html>
