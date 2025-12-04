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
        $_SESSION['customer'] = $user; // ← ここを「username」に統一
    } else {
        header("Location: rogin.php?error=1");
        exit;
    }
}

// ▼ セッションがなければログインページへ
if (!isset($_SESSION['customer'])) {
    header("Location: rogin.php");
    exit;
}

// ▼ HTML出力部分
$customer = htmlspecialchars($_SESSION['customer'], ENT_QUOTES, 'UTF-8');
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

    <div class="container">
 
    <!-- ✅ 左ナビ -->
<nav class="side-nav">
<button onclick="location.href='home.php'" class="nav-item">
<i class="fas fa-home"></i><br>ホーム
</button>
<button onclick="location.href='favorite.php'" class="nav-item">
<i class="fas fa-heart"></i><br>お気に入り
</button>
<button onclick="location.href='cart.php'" class="nav-item">
<i class="fas fa-shopping-cart"></i><br>カート
</button>
<button onclick="location.href='mypage.php'" class="nav-item">
<i class="fas fa-user"></i><br>マイページ
</button>
 
      <img src="../kuma/kuma.png" class="bear-icon" alt="くまアイコン">
</nav>
 
    <!-- ✅ メインエリア -->
<main class="main">
<form action="search.php" method="get">
<header>
<img src="../kuma/moji.png" class="moji" alt="タイトルロゴ">
<input type="text"  name="keyword" placeholder="商品名・色・ジャンルで検索">
</header>
 
<section class="carousel">
<div class="banner-wrapper">
  <div class="banner-container">
    <div class="banner-track">
      <a href="search.php?keyword=椅子"><img src="../jpg/16.jpg" alt=""></a>
      <a href="search.php?keyword=テーブル"><img src="../jpg/26.jpg" alt=""></a>
      <a href="search.php?keyword=テレビ台"><img src="../jpg/7.jpg" alt=""></a>
      <a href="search.php?keyword=小物"><img src="../jpg/60.jpg" alt=""></a>
      <a href="search.php?keyword=ソファー"><img src="../jpg/1.jpg" alt=""></a>

      <!-- ループ用の複製 -->
      <a href="search.php?keyword=椅子"><img src="../jpg/16.jpg" alt=""></a>
      <a href="search.php?keyword=テーブル"><img src="../jpg/26.jpg" alt=""></a>
      <a href="search.php?keyword=テレビ台"><img src="../jpg/7.jpg" alt=""></a>
      <a href="search.php?keyword=小物"><img src="../jpg/60.jpg" alt=""></a>
      <a href="search.php?keyword=ソファー"><img src="../jpg/1.jpg" alt=""></a>
    </div>
  </div>
</div>
</section>
 
<section class="categories">

  <div class="item">
    <a href="search.php?keyword=リビング">
      <img src="../home/リビング.png" alt="リビング">
    </a>
    <p class="item-label">リビング</p>
  </div>

  <div class="item">
    <a href="search.php?keyword=キッチン">
      <img src="../home/キッチン.png" alt="キッチン">
    </a>
    <p class="item-label">キッチン</p>
  </div>

  <div class="item">
    <a href="search.php?keyword=ダイニング">
      <img src="../home/ダイニング.png" alt="ダイニング">
    </a>
    <p class="item-label">ダイニング</p>
  </div>

  <div class="item">
    <a href="search.php?keyword=寝室">
      <img src="../home/寝室.png" alt="寝室">
    </a>
    <p class="item-label">寝室</p>
  </div>

  <div class="item">
    <a href="search.php?keyword=書斎">
      <img src="../home/書斎.png" alt="書斎">
    </a>
    <p class="item-label">書斎</p>
  </div>

  <div class="item">
    <a href="search.php?keyword=バスルーム">
      <img src="../home/バスルーム.png" alt="バスルーム">
    </a>
    <p class="item-label">バスルーム</p>
  </div>

</section>
</form>
</main>
 
  </div><!-- /.container -->

</body>
</html>
