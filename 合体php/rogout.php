<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>ログアウト | POCKET ROOM</title>
  <link rel="stylesheet" href="../css-DS/complete.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>
<body>
  <div class="container">
    <nav class="side-nav">
      <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
      <button onclick="location.href='favorites.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
      <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
      <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
      <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <main class="content">
      <img src="../kuma/moji.png" class="moji">
      <section class="logout-box">
        <h2>ログアウトしますか？</h2>
        <button onclick="location.href='rogin.php'" class="buttons">はい</button>
        <button onclick="location.href='home.php'" class="buttons">いいえ</button>
      </section>
    </main>
  </div>
</body>
</html>
