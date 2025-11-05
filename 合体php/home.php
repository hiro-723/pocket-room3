<?php
session_start();

// ログインしていなければログインページにリダイレクト
if (!isset($_SESSION['username'])) {
    header("Location: rogin.html");
    exit;
}

// エスケープして出力
$username = htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8');
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
    <header>
      <h1>POCKET ROOM</h1>
      <p>ようこそ、<?php echo $username; ?> さん！</p>
    </header>

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

  <nav class="bottom-nav">
      <div class="nav-item" onclick="location.href='home.php'">🏠<br><span>ホーム</span></div>
      <div class="nav-item" onclick="location.href='okiniiri.php'">❤️<br><span>お気に入り</span></div>
      <div class="nav-item" onclick="location.href=''">🧸<br><span></span></div>
      <div class="nav-item" onclick="location.href='cart.html'">🛒<br><span>カート</span></div>
      <div class="nav-item" onclick="location.href='mypage.html'">👤<br><span>マイページ</span></div>
  </nav>
</body>
</html>
