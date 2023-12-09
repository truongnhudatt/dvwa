<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Trang Đăng Nhập</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="login.css">

</head>
<body>
<div class="login-container">
    <h2 class="text-center mb-4">Đăng Nhập</h2>

    <form method="post" action="process_login.php">
        <div class="form-group">
            <label for="username">Tên đăng nhập:</label>
            <input type="text" name="username" id="username" class="form-control" required>
        </div>

        <div class="form-group">
            <label for="password">Mật khẩu:</label>
            <input type="password" name="password" id="password" class="form-control" required>
        </div>

        <input type="submit" value="Đăng Nhập" class="btn btn-primary">
    </form>
    <?php
    session_start();
    if (isset($_SESSION['login_message'])) {
        echo '<div class="alert alert-danger" role="alert">' . $_SESSION['login_message'] . '</div>';
        unset($_SESSION['login_message']);
        // echo '<script>window.onload = function() { alert("Đăng nhập thành công. Xin chào ' . $user['username'] . '!"); window.location.href = "index.php"; }</script>';
        // header("refresh:5;URL=index.php");
    }
    ?>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
