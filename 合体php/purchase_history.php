<?php
session_start();
require_once 'db-connect.php';

// ログイン確認
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// ログイン中ユーザーID取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザー情報が見つかりません。");
}

$customer_id = $user['customer_id'];

// ▼ 購入履歴を取得
$sql = "
    SELECT 
        p.product_id,
        pr.product_name,
        pr.price,
        pr.img
    FROM purchase p
    JOIN product pr ON p.product_id = pr.product_id
    WHERE p.customer_id = ?
    ORDER BY p.purchase_id DESC
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$history = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>購入履歴 | POCKET ROOM</title>
    <link rel="stylesheet" href="../css-DS/history.css"> 
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
</head>

<body>
<div class="container">

    <!-- サイドバー -->
    <nav class="side-nav">
        <button onclick="location.href='home.php'" class="nav-item"><i class="fas fa-home"></i><br>ホーム</button>
        <button onclick="location.href='favorite.php'" class="nav-item"><i class="fas fa-heart"></i><br>お気に入り</button>
        <button onclick="location.href='cart.php'" class="nav-item"><i class="fas fa-shopping-cart"></i><br>カート</button>
        <button onclick="location.href='mypage.php'" class="nav-item"><i class="fas fa-user"></i><br>マイページ</button>
        <img src="../kuma/kuma.png" class="bear-icon">
    </nav>

    <!-- メイン -->
    <main class="content">
        <h1 class="title">POCKET ROOM</h1>
        <h2 class="subtitle">購入された商品</h2>

    <div class="items">
    <?php foreach ($history as $item): ?>
        <div class="item">
            <div class="thumb">
                <img src="../jpg/<?=$item['product_id']?>.jpg">
            </div>
            <div class="name"><?= htmlspecialchars($item['product_name']) ?></div>
            <div class="price"><?= htmlspecialchars($item['price']) ?>円</div>
        </div>
    <?php endforeach; ?>
</div>


    </main>

</div>
</body>
</html>
