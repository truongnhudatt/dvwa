<?php
function hashPassword($password)
{
    // Mã hóa mật khẩu bằng phương thức password_hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    return $hashedPassword;
}

// Request khởi tạo database.
if (isset($_REQUEST["install.php"])) {
}
include("variable.php");
// Ket noi database
$link = new mysqli($db_server, $db_username, $db_password);

if ($link->connect_error) {
    die("Error fail: " . $link->connect_error);
}
// Kiem tra database ton tai
$result = $link->query("SHOW DATABASES LIKE '$db_name'");
// Kiem tra database ton tai
if ($result->num_rows == 0) {
    // echo "Khởi tạo database thành công.";
    // Tao database
    $sql = "CREATE DATABASE IF NOT EXISTS " . $db_name;
    $recordset = $link->query($sql);

    if (!$recordset) {

        die("Error: " . $link->error);
    }

    // Chon database
    mysqli_select_db($link, $db_name);

    // Tao bang users
    $sql = "CREATE TABLE users (
        id INT AUTO_INCREMENT PRIMARY KEY,
        username VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        token VARCHAR(255)
    );";
    $recordset = $link->query($sql);
    if (!$recordset) {

        die("Error: " . $link->error);
    }

    // $token = bin2hex(random_bytes(16));

    $userData = array(
        array('ptit', hashPassword('ptit@123'), bin2hex(random_bytes(16))),
        array('ptit2', hashPassword('ptit@123'), bin2hex(random_bytes(16)))
    );


    // Chuẩn bị câu lệnh SQL INSERT
    $sql = "INSERT INTO users (username, password, token) VALUES ";

    // Lặp qua mảng dữ liệu người dùng và thêm vào câu lệnh SQL
    foreach ($userData as $user) {
        $sql .= "('" . $user[0] . "', '" . $user[1] . "', '" . $user[2] . "'),";
    }

    // Loại bỏ dấu phẩy cuối cùng
    $sql = rtrim($sql, ',');
    $recordset = $link->query($sql);
    if (!$recordset) {

        die("Error: " . $link->error);
    }
} else {
    // echo "Database đã tồn tại.";
}
