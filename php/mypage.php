<?php
session_start();

// ログイン状態の確認
if (!isset($_SESSION['customer_id'])) {
    // 未ログインの場合はログインページへ
    header("Location: rogin.html");
    exit;
}

// セッションからユーザー情報を取得
$customer_id = $_SESSION['customer_id'];
$username = $_SESSION['username'];

// 必要ならDBから詳細情報を取得
require_once 'db_connect.php';

try {
    $sql = "SELECT * FROM customer WHERE customer_id = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$customer_id]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    exit('データ取得エラー: ' . $e->getMessage());
}

// HTML側で利用するためのデータをセット
// 例: $user['customer_name'], $user['email'] などが使用可能
?>
