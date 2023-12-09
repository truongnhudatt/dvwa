<?php
session_start();

if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
}

include_once "variable.php";
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
$user_id = $_SESSION["user_id"];
if (isset($_REQUEST["_method"])) {
    $_SERVER["REQUEST_METHOD"] = $_REQUEST['_method'];
    if ($_SERVER["REQUEST_METHOD"] === "POST") {
        $new_email = $_REQUEST['new_email'];

        // Validate the email format
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Email không hợp lệ";
        } else {
            $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->bind_param("si", $new_email, $user_id);

            if ($stmt->execute()) {
                $success_message = "Email đã được cập nhật thành công!";
                header("Location: profile.php");
                exit();
            } else {
                $error_message = "Lỗi khi cập nhật email: " . $conn->error;
            }

            $stmt->close();
        }
    }
}else{
    if($_SERVER["REQUEST_METHOD"] === "POST"){
        $new_email = $_REQUEST['new_email'];
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL)) {
            $error_message = "Email không hợp lệ";
        } else {
            $stmt = $conn->prepare("UPDATE users SET email = ? WHERE id = ?");
            $stmt->bind_param("si", $new_email, $user_id);
            if ($stmt->execute()) {
                $success_message = "Email đã được cập nhật thành công!";
                header("Location: profile.php");
            } else {
                $error_message = "Lỗi khi cập nhật email: " . $conn->error;
            }

            $stmt->close();
        }
    }
}
$conn->close();
?>
