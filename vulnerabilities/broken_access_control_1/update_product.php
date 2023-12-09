<?php
session_start();
include("variable.php");
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['productData'])) {
    $productData = json_decode($_POST['productData'], true);

    $db = new mysqli($db_server, $db_username, $db_password, $db_name);

    if ($db->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
    }

    $id = $_SESSION['productId'];
    $updateQuery = "UPDATE product SET value='$productData' WHERE id=$id";
    $result = $db->query($updateQuery);

    if ($result) {
        echo "Thông tin sản phẩm đã được cập nhật thành công!";
    } else {
        echo "Có lỗi xảy ra khi cập nhật thông tin sản phẩm!";
    }

    $db->close();
}
