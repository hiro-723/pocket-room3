<?php
require_once '../db-connect.php';

$id = $_POST['product_id'];
$name = $_POST['product_name'];
$price = $_POST['price'];
$category = $_POST['category'];
$color = $_POST['color'];
$genre = $_POST['genre'];

$img_name = null;

if (!empty($_FILES['img']['name'])) {
    $img_name = 'img_' . time() . '.jpg';
    move_uploaded_file($_FILES['img']['tmp_name'], "../upload/$img_name");

    $sql = "UPDATE product SET product_name=?, price=?, category=?, color=?, genre=?, img=? WHERE product_id=?";
    $params = [$name, $price, $category, $color, $genre, $img_name, $id];
} else {
    $sql = "UPDATE product SET product_name=?, price=?, category=?, color=?, genre=? WHERE product_id=?";
    $params = [$name, $price, $category, $color, $genre, $id];
}

$stmt = $pdo->prepare($sql);
$success = $stmt->execute($params);

if ($success) {
    header("Location: mypage.php");
} else {
    echo "更新に失敗しました。";
}
