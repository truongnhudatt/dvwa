<!DOCTYPE html>
<html>
<head>
    <title>Trang Chủ Mua Hàng</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<?php
    include('install.php');
?>
<body>
    <?php
        session_start();
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!isset($_SESSION['username'])) {
            header("Location: login.php");
            exit;
        }

        // Lấy thông tin người dùng từ phiên làm việc
        $username = $_SESSION['username'];

    ?>
    <header>
        <div class="header-container">
            <h1>Toys Store</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="profile.php">Thông tin cá nhân</a></li>
                </ul>
            </nav>
            <div class="user-info">
                <span>Tên tài khoản: <?php echo $username ?></span>
                <a href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </header>
    <div class="container">
        <div class="products">
            <?php include 'products.php'; ?>
        </div>
    </div>

    <div class="spacer"></div>

    <footer class="footer">
        <p>&copy; 2023 Cửa hàng của chúng tôi. Tất cả quyền được bảo vệ.</p>
    </footer>
</body>
</html>
