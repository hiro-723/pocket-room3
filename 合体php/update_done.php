<?php
// URLパラメータ msg があれば表示内容を変更 / なければデフォルト文
$message = $_GET['msg'] ?? '更新完了しました。';
?>
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>完了画面</title>
  <link rel="stylesheet" href="../css/update_done.css">
</head>
<body>
  <div class="container">
    <!-- 完了メッセージ表示 -->
    <h2><?= htmlspecialchars($message, ENT_QUOTES) ?></h2>

    <!-- 管理者設定画面に戻るボタン -->
    <button onclick="location.href='admin.php'">管理者設定に戻る</button>
  </div>
</body>
</html>
