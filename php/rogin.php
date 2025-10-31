<?php
session_start();
require_once 'db_connect.php';
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // ユーザー名で検索
    $sql = "SELECT * FROM customer WHERE customer_name = ? AND password = ?";
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username, $password]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user) {
        // ログイン成功
        $_SESSION['customer_id'] = $user['customer_id'];
         $_SESSION['username'] = $user['customer_name'];
        header("Location: home.html"); // ホーム画面へ
        exit;
    } else {
        echo "ユーザー名またはパスワードが間違っています。";
    }
}
?>
