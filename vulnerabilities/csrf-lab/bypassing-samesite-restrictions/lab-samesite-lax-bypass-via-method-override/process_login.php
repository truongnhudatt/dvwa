<?php
session_start();

include_once "variable.php";
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE username=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($password, $hashed_password)) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: index.php"); // Chuyển hướng sau khi đăng nhập thành công
            exit();
        } else {
            $_SESSION['login_message'] = "Sai mật khẩu. Vui lòng thử lại.";
        }
    } else {
        $_SESSION['login_message'] = "Người dùng không tồn tại.";
    }
}

$conn->close();
header("Location: login.php"); // Chuyển hướng nếu có lỗi hoặc người dùng không tồn tại
exit();
?>
