<?php
session_start();

// ログインチェック（必要なら）
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

$username = $_SESSION['username']; // ログイン中のユーザー名
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>マイページ</title>
<link rel="stylesheet" href="../css-DS/mypage.css" />
</head>

<body>

<h1>POCKET ROOM</h1>

<nav class="side-nav">
<button onclick="location.href='home.php'" class="nav-item">
<i class="fas fa-home"></i><br>ホーム
</button>
<button onclick="location.href='favorites.php'" class="nav-item">
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
<ul>
    <li><a href="customer-info.php">お客様情報</a></li>
    <li><a href="order-history.php">購入履歴</a></li>
    <li><a href="contact.php">お問い合わせ</a></li>
    <li><a href="logout.php">ログアウト</a></li>
</ul>

</body>
</html>