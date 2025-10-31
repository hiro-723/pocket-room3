<?php
session_start();

// ログインしていない場合はログイン画面に戻す
if (!isset($_SESSION['username'])) {
    header("Location: rogin.html");
    exit;
}



$pdo = new PDO($connect, USER, PASS);
$username = $_SESSION['username'];

$stmt->execute([$username]);
$sql = "
SELECT 
    p.product_id, 
    p.product_name, 
    p.price, 
    p.category, 
    p.color, 
    p.genre
FROM favourite f
INNER JOIN product p 
    ON f.product_id = p.product_id
WHERE f.customer_id = ?
";
$stmt = $pdo->prepare($sql);
$stmt->execute([$_SESSION['customer_id']]);
$favorites = $stmt->fetchAll(PDO::FETCH_ASSOC);
include 'okiniiri.html';
?>
