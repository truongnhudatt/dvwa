<?php
session_start();
include_once "variable.php";
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$user_id = $_SESSION["user_id"];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['csrf_token']) && $_POST['csrf_token'] === $_SESSION['csrf_token']) {
        updateEmail($conn, $user_id);
    } else {
        echo "CSRF Token validation failed!";
    }
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET') {
        updateEmail($conn, $user_id);
}

function updateEmail($conn, $user_id) {
    global $error_message, $success_message;

    $new_email = $_REQUEST['new_email'];

    if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
        $error_message = "Email không hợp lệ";
    } else {
        $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
        $stmt->bind_param("si", $new_email, $user_id);

        if ($stmt->execute()) {
            $success_message = "Email đã được cập nhật thành công!";
            header("Location: index.php");
            exit(); // Đảm bảo kịp thời kết thúc script sau khi chuyển hướng
        } else {
            $error_message = "Lỗi khi cập nhật email: " . $conn->error;
        }

        $stmt->close();
    }
}

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();

    $first_name = $row['first_name'];
    $last_name = $row['last_name'];
    $email = $row['email'];
    $username = $row['username'];
} else {
    header("Location: login.php");
    exit();
}

$conn->close();
?>
