<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: rogin.html");
    exit;
}
echo "ようこそ、" . htmlspecialchars($_SESSION['username'], ENT_QUOTES, 'UTF-8') . "さん！";
?>