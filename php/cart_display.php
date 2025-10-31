<?php
session_start();

// カートが存在しない場合
if (empty($_SESSION['product'])) {
    echo '<p>カートに商品は入っていません。</p>';
    return;
}

// 合計金額を計算
$total = 0;
foreach ($_SESSION['product'] as $id => $item) {
    $total += $item['price'] * $item['quantity'];
}
?>

<?php foreach ($_SESSION['product'] as $id => $item): ?>
    <div class="cart-item">
        <div class="item-name"><?= htmlspecialchars($item['name']) ?></div>
        <div class="item-controls">
            <form action="cart_action.php" method="post" style="display:inline;">
                <input type="hidden" name="id" value="<?= $id ?>">
                <button type="submit" name="action" value="plus" class="qty-btn">＋</button>
                <span class="qty"><?= $item['quantity'] ?></span>
                <button type="submit" name="action" value="minus" class="qty-btn">－</button>
            </form>
            <span class="price"><?= number_format($item['price'] * $item['quantity']) ?>円</span>
            <a href="cart-delete.php?id=<?= $id ?>" class="delete-btn">削除</a>
        </div>
    </div>
<?php endforeach; ?>

<div class="cart-total">
    <p>合計金額 <?= number_format($total) ?>円</p>
</div>

<form action="purchase.php" method="post">
    <button type="submit" class="purchase-btn">購入する</button>
</form>
