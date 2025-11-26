<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>商品登録</title>
  <link rel="stylesheet" href="../css-DS/product-add.css">
</head>
<body>

<div class="container">

  <form action="product-add-act.php" method="post" enctype="multipart/form-data">

    <div class="thumb"></div>

    <h1>商品登録</h1>

    <input type="text" name="product_name" placeholder="商品名" required>
    <input type="number" name="price" placeholder="値段" required>
    <input type="text" name="category" placeholder="カテゴリー" required>
    <input type="text" name="color" placeholder="色" required>
    <input type="text" name="genre" placeholder="ジャンル" required>
    <input type="file" name="img">

    <p class="confirm-text">この商品を登録しますか？</p>

    <div class="btn-area">
      <button type="submit" class="yes">はい</button>
      <button type="button" class="no" onclick="history.back()">いいえ</button>
    </div>

  </form>

</div>

</body>
</html>
