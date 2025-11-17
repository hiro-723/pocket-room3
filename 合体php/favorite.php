<?php
session_start();
require_once '../db-connect.php';

// ログイン確認
if (!isset($_SESSION['username'])) {
  header("Location: rogin.php");
  exit;
}

// email で customer_id を取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    exit("ユーザーが見つかりません。");
}

$customer_id = $user['customer_id'];

// お気に入り一覧取得
$sql = "
SELECT 
    f.favorite_id,
    p.product_id,
    p.product_name,
    p.price
FROM favorite f
JOIN product p ON f.product_id = p.product_id
WHERE f.customer_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<table>
    <tr>
        <th>商品名</th><th>価格</th><th>削除</th>
    </tr>
    <?php foreach ($favorites as $fav): ?>
    <tr>
        <td><?= htmlspecialchars($fav['product_name'], ENT_QUOTES) ?></td>
        <td><?= htmlspecialchars($fav['price'], ENT_QUOTES) ?>円</td>
        <td>
            <a href="favorite-delete.php?id=<?= $fav['favorite_id'] ?>">削除</a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>
