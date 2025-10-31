<?php
session_start();

$id = $_POST['id'] ?? null;
$action = $_POST['action'] ?? null;

if (!$id || !isset($_SESSION['product'][$id])) {
    header('Location: cart.php');
    exit;
}

// 現在の数量を取得
$quantity = $_SESSION['product'][$id]['quantity'];

// アクション別処理
if ($action === 'plus') {
    $_SESSION['product'][$id]['quantity']++;
} elseif ($action === 'minus') {
    if ($quantity > 1) {
        $_SESSION['product'][$id]['quantity']--;
    } else {
        // 数量が1で「－」を押したら削除と同じ扱い
        unset($_SESSION['product'][$id]);
    }
}

// カートページに戻る
header('Location: cart.php');
exit;
?>