<?php
session_start();
require_once 'db-connect.php';

// 未ログインならログインへ
if (!isset($_SESSION['username'])) {
    header("Location: rogin.php");
    exit;
}

// ログイン中ユーザーID取得
$stmt = $pdo->prepare("SELECT customer_id FROM customer WHERE email = ?");
$stmt->execute([$_SESSION['username']]);
$user = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$user) {
    echo "ユーザーが見つかりません。";
    exit;
}

$customer_id = $user['customer_id'];

// favorite 取得
$sql = "
  SELECT 
    favorite.favorite_id,
    product.product_id,
    product.product_name,
    product.price,
    product.img
  FROM favorite
  JOIN product ON favorite.product_id = product.product_id
  WHERE favorite.customer_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$customer_id]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="UTF-8">
  <title>お気に入り</title>
</head>
<body>

<h2>お気に入り一覧</h2>

<?php if ($favorites): ?>
    <?php foreach ($favorites as $item): ?>
        <div class="fav-item" data-id="<?= $item['favorite_id'] ?>">
            <img src="../img/<?= htmlspecialchars($item['img']) ?>" width="70">
            <p><?= htmlspecialchars($item['product_name']) ?>（<?= number_format($item['price']) ?>円）</p>
            <button class="delete-btn">削除</button>
        </div>
        <hr>
    <?php endforeach; ?>
<?php else: ?>
    <p>お気に入りに商品がありません。</p>
<?php endif; ?>

<script>
// JSで削除実行
document.querySelectorAll('.delete-btn').forEach(btn => {
    btn.addEventListener('click', () => {
        const item = btn.closest('.fav-item');
        const id = item.dataset.id;

        fetch("favorite-delete.php", {
            method: "POST",
            headers: {"Content-Type": "application/x-www-form-urlencoded"},
            body: "favorite_id=" + id
        })
        .then(res => res.text())
        .then(() => {
            item.remove(); // 画面から削除
        });
    });
});
</script>

</body>
</html>
