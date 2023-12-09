<?php
header('Content-Type: application/json; charset=utf-8');
session_set_cookie_params(['samesite' => 'None']);
session_start();
// Nhận dữ liệu JSON từ yêu cầu
$json_data = file_get_contents('php://input');
$data = json_decode($json_data, true);

// Kiểm tra xem dữ liệu có hợp lệ không
if (empty($data['username']) || empty($data['password'])) {
    http_response_code(400);
    echo json_encode(array('error' => 'Invalid data'));
}

// Lấy thông tin từ dữ liệu
$username = $data['username'];
$password = $data['password'];

// Kiểm tra thông tin đăng nhập
if ($username === 'ptit' && $password === 'ptit@123') {
    // Đăng nhập thành công
    $_SESSION['username'] = $username;
    echo json_encode(array('success' => true, 'session_id' => session_id()));
} else {
    // Đăng nhập thất bại
    http_response_code(401);
    echo json_encode(array('error' => 'Invalid credentials'));
}

?>
