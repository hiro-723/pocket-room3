<?php
require_once 'db-connect.php';

$id = $_GET['id'];

$stmt = $pdo->prepare("DELETE FROM product WHERE product_id = ?");
$success = $stmt->execute([$id]);

if ($success) {
    header("Location: mypage.php");
} else {
    echo "削除に失敗しました。";
}
