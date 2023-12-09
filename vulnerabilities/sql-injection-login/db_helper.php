<?php

function executeSQL($sql) {
    include("variable.php");
    // Kết nối đến cơ sở dữ liệu
    $link = new mysqli($db_server, $db_username, $db_password, $db_name);

    // Kiểm tra kết nối
    if ($link->connect_error) {
        die("Kết nối thất bại: " . $link->connect_error);
    }

    // Thực hiện truy vấn SQL
    $result = $link->query($sql);
    // $result = $link->store_result();
    
    // Kiểm tra lỗi trong truy vấn
    if (!$result) {
        die("Lỗi truy vấn SQL: " . $link->error);
    }
    
    // Đóng kết nối
    $link->close();
    
    return $result;
}
?>
