<?php
require_once 'db_connect.php';
$name       = $_POST['customer_name'];
$kana       = $_POST['customer_kana'];
$birth      = $_POST['birth_date'];
$prefecture = $_POST['prefecture'];
$city       = $_POST['city'];
$address    = $_POST['address'];
$building   = $_POST['building'];
$phone      = $_POST['phone_number'];
$email      = $_POST['email'];
$password   = $_POST['password'];

$sql= "insert into customer(customer_name,customer_kana,birth_date,prefecture,city,address,building,phone_number,email,password) values(?,?,?,?,?,?,?,?,?,?)";
$stmt = $pdo->prepare($sql);
 $stmt->execute([
        $name, $kana, $birth, $prefecture, $city,
        $address, $building, $phone, $email, $password
    ]);
header("Location: rogin.html");
exit;
?>