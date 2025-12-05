<?php
session_start();
require_once 'db-connect.php';

// ログイン確認（任意）
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品削除</title>
  <link rel="stylesheet" href="../css-DS/product-delete.css">
</head>
<body>
    <h1>商品削除</h1>

    <form action="product-delete-act.php" method="post">
        <label for="id">削除したい商品のID：</label>
        <input type="number" name="id"  min="1" required>
        <br><br>
        <div class="btn-area">
            <button type="submit" class="yes">削除する</button>
            <button type="button" class="no" onclick="history.back()">戻る</button>
        </div>
    </form>
</body>
</html>
