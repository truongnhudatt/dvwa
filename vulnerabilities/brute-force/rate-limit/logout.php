<?php
session_start();

// Hủy tất cả các biến session
$_SESSION = array();
session_unset();

// Hủy bỏ phiên làm việc
session_destroy();

// Chuyển hướng về trang đăng nhập hoặc trang chính (tùy thuộc vào yêu cầu của bạn)
header("Location: index.php");
exit();
?>
