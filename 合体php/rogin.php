<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ログイン | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/login.css">
</head>
<body>
    <div class="container">
        <img src="../kuma/aikon.png" alt="POCKET ROOM">

        <?php if (isset($_GET['error'])): ?>
            <p class="error">メールアドレスまたはパスワードが違います。</p>
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
