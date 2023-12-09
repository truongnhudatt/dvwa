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
    $ip_address = $_SERVER['REMOTE_ADDR'];

    $max_login_attempts = 5;
    $lockout_duration = 600;

    $sql_select_attempts = "SELECT attempts, expire_time, last_attempt FROM login_attempts WHERE ip_address = ?";
    $stmt = $conn->prepare($sql_select_attempts);
    $stmt->bind_param("s", $ip_address);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result === false) {
        die("Lỗi truy vấn SQL: " . $stmt->error);
    }

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $attempts = $row['attempts'];
        $expire_time = strtotime($row['expire_time']);
        $last_attempt = strtotime($row['last_attempt']);

        if ($attempts >= $max_login_attempts && $expire_time > time()) {
            $_SESSION['login_message'] = "Bạn đã vượt quá số lần thử đăng nhập tối đa. Vui lòng thử lại sau.";
            echo "Bạn đã vượt quá số lần thử đăng nhập tối đa. Vui lòng thử lại sau.";
        } elseif ($expire_time > time() && time() - $last_attempt < $lockout_duration) {
            $_SESSION['login_message'] = "Vui lòng đợi đến khi thời gian hết hạn (10 phút) trôi qua trước khi thử lại.";
            echo "Vui lòng đợi đến khi thời gian hết hạn (10 phút) trôi qua trước khi thử lại.";
        } else {
            $sql = "SELECT * FROM users WHERE username=?";
            $stmt_select_user = $conn->prepare($sql);
            $stmt_select_user->bind_param("s", $username);
            $stmt_select_user->execute();
            $result_select_user = $stmt_select_user->get_result();

            if ($result_select_user->num_rows > 0) {
                $row_user = $result_select_user->fetch_assoc();
                $hashed_password = $row_user['password'];

                if (password_verify($password, $hashed_password)) {
                    $stmt_reset_attempts = $conn->prepare("UPDATE login_attempts SET attempts = 0, expire_time = NULL, last_attempt = NULL WHERE ip_address = ?");
                    $stmt_reset_attempts->bind_param("s", $ip_address);
                    $stmt_reset_attempts->execute();
                    $_SESSION['user_id'] = $row_user['id'];
                    $_SESSION['username'] = $row_user['username'];
                } else {
                    $attempts++;
                    $expire_time = ($attempts >= $max_login_attempts) ? date('Y-m-d H:i:s', strtotime("+$lockout_duration seconds")) : null;
                    $last_attempt = date('Y-m-d H:i:s');
                    $stmt_update_attempts = $conn->prepare("UPDATE login_attempts SET attempts = ?, expire_time = ?, last_attempt = ? WHERE ip_address = ?");
                    $stmt_update_attempts->bind_param("isss", $attempts, $expire_time, $last_attempt, $ip_address);
                    $stmt_update_attempts->execute();
                    $_SESSION['login_message'] = ($attempts >= $max_login_attempts) ? "Bạn đã vượt quá số lần thử đăng nhập tối đa. Vui lòng thử lại sau." : "Đăng nhập không thành công!";
                }
            }
        }
    } else {
        $sql = "SELECT * FROM users WHERE username=?";
        $stmt_select_user = $conn->prepare($sql);
        $stmt_select_user->bind_param("s", $username);
        $stmt_select_user->execute();
        $result_select_user = $stmt_select_user->get_result();

        if ($result_select_user->num_rows > 0) {
            $row_user = $result_select_user->fetch_assoc();
            $hashed_password = $row_user['password'];

            if (password_verify($password, $hashed_password)) {
                $stmt_reset_attempts = $conn->prepare("UPDATE login_attempts SET attempts = 0, expire_time = NULL, last_attempt = NULL WHERE ip_address = ?");
                $stmt_reset_attempts->bind_param("s", $ip_address);
                $stmt_reset_attempts->execute();
                $_SESSION['user_id'] = $row_user['id'];
                $_SESSION['username'] = $row_user['username'];
            } else {
                $attempts = 1;
                $expire_time = ($attempts >= $max_login_attempts) ? date('Y-m-d H:i:s', strtotime("+$lockout_duration seconds")) : null;
                $last_attempt = date('Y-m-d H:i:s');
                $stmt_update_attempts = $conn->prepare("INSERT INTO login_attempts (ip_address, attempts, expire_time, last_attempt) VALUES (?, ?, ?, ?)");
                $stmt_update_attempts->bind_param("siss", $ip_address, $attempts, $expire_time, $last_attempt);
                $stmt_update_attempts->execute();
                $_SESSION['login_message'] = ($attempts >= $max_login_attempts) ? "Bạn đã vượt quá số lần thử đăng nhập tối đa. Vui lòng thử lại sau." : "Đăng nhập không thành công!";
            }
        }
    }
}

$conn->close();
header("Location: index.php");
exit();
?>
