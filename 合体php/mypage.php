<?php
session_start();

// ログインチェック
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit;
}

$username = $_SESSION['username'];
?>
<!DOCTYPE html>
<html lang="ja">
<head>
<meta charset="UTF-8">
<title>マイページ</title>
<link rel="stylesheet" href="mypage.css">
<!-- FontAwesome（必要なら） -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>

<div class="container">

  <!-- =================================== -->
  <!-- ✔ 左サイドナビ（あなたが指定したそのまま） -->
  <!-- =================================== -->
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


  <!-- =================================== -->
  <!-- ✔ メインエリア（中央にメニューを表示） -->
  <!-- =================================== -->
  <main>
      <div class="mypage-menu">

          <!-- ロゴ画像（あなたのCSS .moji に対応） -->
          <img src="../logo/moji.png" alt="POCKET ROOM" class="moji">

          <h2>マイページ</h2>

          <p>こんにちは、<?php echo htmlspecialchars($username); ?> さん</p>
          <br>

          <ul class="menu">

              <li>
                  <button class="menu-btn" onclick="location.href='customer-info.php'">
                      <span class="icon"><i class="fas fa-user"></i></span>
                      お客様情報
                  </button>
              </li>

              <li>
                  <button class="menu-btn" onclick="location.href='order-history.php'">
                      <span class="icon"><i class="fas fa-shopping-bag"></i></span>
                      購入履歴
                  </button>
              </li>

              <li>
                  <button class="menu-btn" onclick="location.href='contact.php'">
                      <span class="icon"><i class="fas fa-envelope"></i></span>
                      お問い合わせ
                  </button>
              </li>

              <li>
                  <button class="menu-btn" onclick="location.href='logout.php'">
                      <span class="icon"><i class="fas fa-right-from-bracket"></i></span>
                      ログアウト
                  </button>
              </li>

          </ul>
      </div>
  </main>

</div>

</body>
</html>
