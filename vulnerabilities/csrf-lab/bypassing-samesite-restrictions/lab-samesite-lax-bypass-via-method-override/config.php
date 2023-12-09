<?php
include_once "variable.php";
$conn = new mysqli($db_server, $db_username, $db_password);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
?>