<?php
require_once 'db-connect.php';

$name = $_POST['product_name'];
$price = $_POST['price'];
$category = $_POST['category'];
$color = $_POST['color'];
$genre = $_POST['genre'];

$img_name = null;

if (!empty($_FILES['img']['name'])) {
    $img_name = 'img_' . time() . '.jpg';
    move_uploaded_file($_FILES['img']['tmp_name'], "../upload/$img_name");
}

$stmt = $pdo->prepare("
    INSERT INTO product(product_name, price, category, color, genre, img)
    VALUES(?,?,?,?,?,?)
");

$success = $stmt->execute([$name, $price, $category, $color, $genre, $img_name]);

if ($success) {
    header("Location: mypage.php");
    exit;
} else {
    echo "登録に失敗しました。";
}
