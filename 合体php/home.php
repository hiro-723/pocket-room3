<?php
session_start();
require_once 'db-connect.php';

// ▼ ログインフォームからPOSTされた場合（ログイン処理）
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM customer WHERE email = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    // パスワードチェック（今回はハッシュ化していない前提）
    if ($user && $password === $user['password']) {
        $_SESSION['username'] = $user['name']; // ← ここを「username」に統一
    } else {
        header("Location: rogin.php?error=1");
        exit;
    }
}

// ▼ セッションがなければログインページへ
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// ▼ HTML出力部分
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>ホーム</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <link rel="stylesheet" href="../css-DS/home.css" />
</head>
<body>

    <nav class="side-nav">
      <button onclick="location.href='home.html'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorites.html'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.html'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.html'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">

    </nav>

  <main class="main">
    <header>
      <img src="../kuma/moji.png" class="moji">
      <input type="text" placeholder="検索">
    </header>

    <section class="carousel">
      <div class="card">おすすめ商品表示</div>
    </section>

    <section class="categories">
      <div class="item"> <img src="../home/リビング.png"></div>
      <div class="item">キッチン</div>
      <div class="item">ダイニング</div>
      <div class="item">寝室</div>
      <div class="item">書斎</div>
      <div class="item">バスルーム</div>
    </section>
  </main>

</body>
</html>
