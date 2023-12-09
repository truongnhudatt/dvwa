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
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Hồ Sơ</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="profile.css">

</head>
<body>

<div class="container">
    <div class="card">
        <div class="card-header">
            <h2 class="card-title">Hồ Sơ Người Dùng</h2>
        </div>
        <div class="card-body">
            <table class="user-info-table">
                <tr>
                    <th>Họ:</th>
                    <td><?php echo $last_name?></td>
                </tr>
                <tr>
                    <th>Tên:</th>
                    <td><?php echo $first_name?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td><?php echo $email?></td>
                </tr>
                <tr>
                    <th>Tên người dùng:</th>
                    <td><?php echo $username?></td>
                </tr>
            </table>
            <form action="logout.php" method="post">
                <button id="btn-submit" type="submit" class="btn btn-danger logout-btn">Đăng Xuất</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
