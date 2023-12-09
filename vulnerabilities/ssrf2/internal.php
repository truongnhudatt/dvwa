<?php
$allowedIPs = array('192.168.1.1', '127.0.0.1'); // Thêm các địa chỉ IP mà bạn muốn cho phép truy cập vào mảng này

$clientIP = $_SERVER['REMOTE_ADDR'];

if (in_array($clientIP, $allowedIPs)) {
    // Địa chỉ IP của client nằm trong danh sách được cho phép
    echo "Chào mừng bạn có quyền truy cập nội bộ!";
} else {
    // Địa chỉ IP của client không được cho phép
    echo "Truy cập bị từ chối!";
}
?>
