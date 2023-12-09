<?php
// Khởi động hoặc tiếp tục phiên làm việc
session_start();

// Hủy bỏ tất cả các biến phiên
$_SESSION = array();

// Nếu cần xóa cả cookie liên quan đến phiên làm việc, hãy xóa cookie này
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}

// Hủy bỏ phiên làm việc
session_destroy();

// Chuyển hướng người dùng về trang đăng nhập hoặc trang chính sau khi đăng xuất
header("Location: index.php"); // Đổi 'login.php' thành trang đích sau khi đăng xuất
exit;
