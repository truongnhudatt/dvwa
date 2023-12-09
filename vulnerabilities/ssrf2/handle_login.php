<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $xmlData = file_get_contents('php://input');

    $dom = new DOMDocument();
    $dom->loadXML($xmlData, LIBXML_NOENT);
    $username = $dom->getElementsByTagName('username')->item(0)->nodeValue;
    $password = $dom->getElementsByTagName('password')->item(0)->nodeValue;
    include("variable.php");
    function passwordHash($password){
        return $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }
    $conn = mysqli_connect($db_server, $db_username, $db_password,$db_name);

    if ($conn->connect_error) {
        $response = [
                    'status' => 'error',
                    'message' => 'Kết nối cơ sở dữ liệu thất bại.'
                ];
    }
    $sql = "SELECT id, username, password FROM user WHERE username = ?";
    if ($stmt = $conn->prepare($sql)) {
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $stmt->bind_result($user_id, $db_username, $db_password);

        $stmt->bind_result($user_id, $db_username, $db_password);
        if ($stmt->fetch()) {
            if (password_verify($password, $db_password)) {
                $_SESSION['id'] = $user_id;
                $_SESSION['username'] = $username;
                $response = [
                    'status' => 'success',
                    'message' => 'Đăng nhập thành công'
                ];
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Sai mật khẩu.'
                ];
            }
        } else {
            $response = [
                'status' => 'error',
                'message' => 'Sai tên đăng nhập.'
            ];
        }
    }
    else {
        $response = [
            'status' => 'error',
            'message' => 'Sai tên đăng nhập hoặc mật khẩu.'
        ];
    }

    // Trả về kết quả dưới dạng JSON
    header('Content-Type: application/json');
    echo json_encode($response);
}
?>
