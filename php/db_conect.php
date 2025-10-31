<?php
const SERVER = 'mysql326.phy.lolipop.lan';
const DBNAME = 'LAA1607632-pocketroom';
const USER = 'LAA1607632';
const PASS = 'pocketRoom';
    $connect = 'mysql:host='. SERVER . ';dbname='. DBNAME . ';charset=utf8'; 


try {
    $pdo = new PDO($connect, USER, PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit('DB接続エラー: ' . $e->getMessage());
}
?>
