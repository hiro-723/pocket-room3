<?php
session_start();
require_once '../db-connect.php';

// ID の受取
if (!isset($_POST['id']) || empty($_POST['id'])) {
    echo "ID が入力されていません。";
    exit;
}

$id = $_POST['id'];

// 商品が存在するかチェック
$check = $pdo->prepare("SELECT * FROM product WHERE id = ?");
$check->execute([$id]);
$product = $check->fetch();

if (!$product) {
    echo "指定されたIDの商品は存在しません。";
    echo '<br><a href="product-delete.php">戻る</a>';
    exit;
}

// 削除実行
$stmt = $pdo->prepare("DELETE FROM product WHERE id = ?");
$result = $stmt->execute([$id]);

if ($result) {
    // 成功したら admin.php に戻す
    header("Location: admin-menu.php?msg=deleted");
    exit;
} else {
    echo "削除に失敗しました。";
    echo '<br><a href="product-delete.php">戻る</a>';
    exit;
}
