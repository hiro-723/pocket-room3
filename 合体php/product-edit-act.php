<?php
require_once 'db-connect.php';

// product_id が送られていない場合
if (!isset($_POST['product_id'])) {
    echo "商品IDがありません。";
    exit;
}

$id       = $_POST['product_id'];
$name     = $_POST['product_name'];
$price    = $_POST['price'];
$category = $_POST['category'];
$color    = $_POST['color'];
$genre    = $_POST['genre'];

$img_name = null;

// ----------------------
// 画像アップロード処理
// ----------------------
if (!empty($_FILES['img']['name'])) {

    // 元ファイルの拡張子を取得
    $ext = pathinfo($_FILES['img']['name'], PATHINFO_EXTENSION);

    // ファイル名を作成
    $img_name = 'img_' . time() . '.' . $ext;

    // 保存先フォルダ
    $upload_path = "../upload/" . $img_name;

    // 実際に保存
    if (!move_uploaded_file($_FILES['img']['tmp_name'], $upload_path)) {
        echo "画像のアップロードに失敗しました。";
        exit;
    }

    // 画像あり UPDATE
    $sql = "UPDATE product 
            SET product_name=?, price=?, category=?, color=?, genre=?, img=? 
            WHERE product_id=?";
    $params = [$name, $price, $category, $color, $genre, $img_name, $id];

} else {

    // 画像なし UPDATE
    $sql = "UPDATE product 
            SET product_name=?, price=?, category=?, color=?, genre=? 
            WHERE product_id=?";
    $params = [$name, $price, $category, $color, $genre, $id];
}

// UPDATE 実行
$stmt = $pdo->prepare($sql);
$success = $stmt->execute($params);

// ----------------------
// 結果処理
// ----------------------
if ($success) {
    header("Location: mypage.php?msg=updated");
    exit;
} else {
    echo "更新に失敗しました。";
    echo "<br><a href='product-edit.php?id=$id'>戻る</a>";
    exit;
}
