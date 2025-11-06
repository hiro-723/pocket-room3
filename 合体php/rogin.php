<?php
require_once 'db-connect.php';
session_start();

$error = '';

// ▼ ログイン処理（フォーム送信時）
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM members WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user'] = $user['name'];
        header("Location: welcome.php"); // ログイン後のページ
        exit;
    } else {
        $error = "メールアドレスまたはパスワードが違います。";
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | POCKET ROOM</title>
    <link rel="stylesheet" href="../合体css/style.css">
</head>
<body>
    <div class="container">
        <img src="../kuma/aikon.png" alt="POCKET ROOM">

        <?php if ($error): ?>
            <p class="error"><?= htmlspecialchars($error) ?></p>
        <?php endif; ?>

        <form action="home.php" method="post">
            <label>メールアドレス</label>
            <input type="email" name="email" required>

            <label>パスワード</label>
            <input type="password" name="password" required>

            <p class="register-link">
                <a href="sinkikaiintouroku.php">新規会員登録</a>
            </p>

            <button type="submit">ログインする</button>
        </form>
    </div>
</body>
</html>
