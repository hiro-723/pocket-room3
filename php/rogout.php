<?php
session_start();
session_unset();  // セッション変数を全削除
session_destroy(); // セッションを破棄
header("Location: rogin.html");
exit;
?>
