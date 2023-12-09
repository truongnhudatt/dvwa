<?php 
session_start();
session_unset(); // Xóa tất cả các biến phiên
session_destroy(); // Hủy bỏ phiên
header("Location: login.php"); // Chuyển hướng người dùng đến trang đăng nhập
exit;
?>