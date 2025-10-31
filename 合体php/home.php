<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: rogin.html");
    exit;
}
echo "ようこそ、" . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . "さん！";
?>


<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>POCKET ROOM</title>
  <link rel="stylesheet" href="../css/home.css" />
</head>
<body>
  <div class="container">
    <header><h1>POCKET ROOM</h1></header>

    <main>
      <div class="search-bar">
        <input type="text" placeholder="🔍 検索" />
      </div>

      <div class="banner">
        <p>おススメと新着入荷をバナーで流す</p>
        <div class="dots">
          <span></span><span></span><span></span><span></span><span></span>
        </div>
      </div>

      <section class="categories">
        <div class="circle"><p>リビング</p></div>
        <div class="circle"><p>キッチン</p></div>
        <div class="circle"><p>ダイニング</p></div>
        <div class="circle"><p>寝室</p></div>
        <div class="circle"><p>書斎・子供部屋</p></div>
        <div class="circle"><p>バスルーム</p></div>
      </section>
    </main>
  </div>

  <!-- ↓ history.html と同じ構造のナビ部分 -->
  <nav class="bottom-nav">
    <ul>
      <li><button class="nav-btn" onclick="location.href='home.html'">🏠<br>ホーム</button></li>
      <li><button class="nav-btn" onclick="location.href='favorites.html'">❤️<br>お気に入り</button></li>
      <li><button class="nav-btn" onclick="location.href='item.html'">🧸<br></button></li>
      <li><button class="nav-btn" onclick="location.href='cart.html'">🛒<br>カート</button></li>
      <li><button class="nav-btn" onclick="location.href='mypage.html'">👤<br>マイページ</button></li>
    </ul>
  </nav>
</body>
</html>
