<?php
session_start();
require_once 'db-connect.php';

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer WHERE email = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email, $password]);
    $customer = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($customer) {
        $_SESSION['customer'] = $customer; 
        header("Location: home.php");
        exit;
    } else {
        header("Location: rogin.php?error=1");
        exit;
    }
}
?>

<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/style.css">
</head>
<body>
    <div class="container">
        <img src="../kuma/aikon.png" alt="POCKET ROOM">

        <?php if (isset($_GET['error'])): ?>
            <p class="error">メールアドレスまたはパスワードが違います。</p>
        <?php endif; ?>

        <form action="rogin.php" method="post">
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
