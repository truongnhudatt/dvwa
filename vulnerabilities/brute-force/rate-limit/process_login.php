<?php
session_start();
include_once "variable.php";
$conn = new mysqli($db_server, $db_username, $db_password, $db_name);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}

$username = $_POST['username'];
$password = $_POST['password'];
$ip_address = $_SERVER['REMOTE_ADDR'];

$max_login_attempts = 5;
$lockout_duration = 600;

$sql_select_attempts = "SELECT attempts, expire_time, last_attempt FROM login_attempts WHERE ip_address = '$ip_address' AND username = '$username'";
$result = $conn->query($sql_select_attempts);

if ($result === false) {
    die("Lỗi truy vấn SQL: " . $conn->error);
}

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $attempts = $row['attempts'];
    $expire_time = $row['expire_time'];
    $last_attempt = strtotime($row['last_attempt']);

    if ($attempts >= $max_login_attempts && strtotime($expire_time) > time()) {
        $_SESSION['login_message'] = "Bạn đã vượt quá số lần đăng nhập tối đa. Vui lòng thử lại sau.";
        echo "Bạn đã vượt quá số lần đăng nhập tối đa. Vui lòng thử lại sau.";
    } else if (strtotime($expire_time) > time() && time() - $last_attempt < $lockout_duration) {
        $_SESSION['login_message'] = "Vui lòng đợi đến khi thời gian hết hạn (10 phút) trôi qua trước khi thử lại.";
        echo "Vui lòng đợi đến khi thời gian hết hạn (10 phút) trôi qua trước khi thử lại.";
    } else {
        $loginResult = attemptLogin($conn, $username, $password, $attempts, $max_login_attempts, $lockout_duration, $ip_address);
        echo $loginResult;
    }
} else {
    $loginResult = attemptLogin($conn, $username, $password, 0, $max_login_attempts, $lockout_duration, $ip_address);
    echo $loginResult;
}

$conn->close();

function attemptLogin($conn, $username, $password, $attempts, $max_attempts, $lockout_duration, $ip_address) {
    $sql = "SELECT * FROM users WHERE username='$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];
        if (password_verify($password, $hashed_password)) {
            resetLoginAttempts($conn, $ip_address, $username);
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['username'] = $row['username'];
            header("Location: profile.php");
            exit();
        }
    }

    $attempts++;
    $expire_time = ($attempts >= $max_attempts) ? date('Y-m-d H:i:s', strtotime("+$lockout_duration seconds")) : null;
    $last_attempt = date('Y-m-d H:i:s');
    updateLoginAttempts($conn, $attempts, $expire_time, $last_attempt, $ip_address, $username);

    if ($attempts >= $max_attempts) {
        return $_SESSION['login_message'] = "Bạn đã vượt quá số lần đăng nhập tối đa. Vui lòng thử lại sau.";
        echo "Bạn đã vượt quá số lần đăng nhập tối đa. Vui lòng thử lại sau.";
    } else {
        return $_SESSION['login_message'] = "Đăng nhập không thành công!";
        echo "Đăng nhập không thành công!";
    }
}

function resetLoginAttempts($conn, $ip_address, $username) {
    $sql_reset_attempts = "UPDATE login_attempts SET attempts = 0, expire_time = NULL, last_attempt = NULL WHERE ip_address = '$ip_address' AND username = '$username'";
    $conn->query($sql_reset_attempts);
}

function updateLoginAttempts($conn, $attempts, $expire_time, $last_attempt, $ip_address, $username) {
    $sql_update_attempts = "UPDATE login_attempts SET attempts = $attempts, expire_time = '$expire_time', last_attempt = '$last_attempt' WHERE ip_address = '$ip_address' AND username = '$username'";
    $conn->query($sql_update_attempts);
}
?>
