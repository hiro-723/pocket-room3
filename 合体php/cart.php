<?php
session_start();

// ログイン確認（ログインしていなければログインページへ）
if (!isset($_SESSION['username'])) {
    header("Location: rogin.html");
    exit;
}

// 合計金額（例: セッションから計算する）
$total = isset($_SESSION['total']) ? $_SESSION['total'] : 10000;
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>カート | POCKET ROOM</title>
  <link rel="stylesheet" href="../合体css/cart.css">
</head>
<body>
  <div class="container">
    <header>
      <h1>POCKET ROOM</h1>
      <h2>カート</h2>
    </header>

    <main>
      <div class="cart-item">
        <div class="item-info">カートに<br>入っている<br>商品の表示</div>
        <div class="item-control">
          <span class="plus">＋</span>
          <span class="quantity">1</span>
          <span class="minus">－</span>
          <button class="delete-btn">削除</button>
        </div>
      </div>

      <div class="cart-item">
        <div class="item-info">カートに<br>入っている<br>商品の表示</div>
        <div class="item-control">
          <span clas
