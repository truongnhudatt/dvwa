<?php
session_start();
if (!isset($_SESSION["user_id"])) {
    header("Location: login.php");
    exit();
};
$csrfToken = bin2hex(random_bytes(32));
$_SESSION['csrf_token'] = $csrfToken;
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
    <!-- Sử dụng thư viện jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
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
                    <td><?php echo $last_name ?></td>
                </tr>
                <tr>
                    <th>Tên:</th>
                    <td><?php echo $first_name ?></td>
                </tr>
                <tr>
                    <th>Email:</th>
                    <td class="edit-email-container">
                        <div>
                            <?php echo $email ?>
                            <button id="edit_email_button" class="btn btn-link">Sửa</button>
                        </div>
                    </td>
                </tr>
                <tr>
                    <th>Tên người dùng:</th>
                    <td><?php echo $username ?></td>
                </tr>
            </table>

            <form action="process_profile.php" method="post" id="edit_email_form" style="display: none;">
                <div class="form-group">
                    <label for="new_email">Email mới:</label>
                    <input type="email" name="new_email" id="new_email" class="form-control" required>
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token'] ?>">
                </div>
                <button type="submit" name="edit_email" class="btn btn-primary">Lưu</button>
                <button type="button" id="cancel_edit_email" class="btn btn-secondary">Hủy</button>
            </form>

            <form action="logout.php" method="post">
                <button id="btn-submit" type="submit" class="btn btn-danger logout-btn">Đăng Xuất</button>
            </form>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

<script>
    $(document).ready(function() {
        // Bắt sự kiện click nút "Sửa"
        $("#edit_email_button").click(function() {
            // Ẩn nút "Sửa" và hiển thị form sửa email
            $("#edit_email_button").hide();
            $("#edit_email_form").show();
        });

        // Bắt sự kiện click nút "Hủy"
        $("#cancel_edit_email").click(function() {
            // Hiển thị lại nút "Sửa" và ẩn form sửa email
            $("#edit_email_button").show();
            $("#edit_email_form").hide();
        });
    });
</script>
</body>
</html>
