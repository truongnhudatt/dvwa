<?php
session_start();

// Hủy phiên đăng nhập và chuyển hướng về trang chủ
session_destroy();
header("Location: index.php");
exit();
?>
