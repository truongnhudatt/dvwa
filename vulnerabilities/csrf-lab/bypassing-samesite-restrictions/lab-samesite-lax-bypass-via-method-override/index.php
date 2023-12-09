<?php
include("install.php");
session_start();
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap" rel="stylesheet">
    <link href="index.css" rel="stylesheet">
    <title>Trang chủ</title>
</head>

<body>
    <header>
        <div class="header-container">
            <h1><a class="logo" href="index.php">PTIT Mobile</a></h1>
            <nav>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a></li>
                    <li><a href="#">Giỏ hàng</a></li>
                    <li><a href="profile.php">Thông tin cá nhân</a></li>
                </ul>
            </nav>
            <div class="user-info">
            <?php
            // Kiểm tra xem người dùng đã đăng nhập hay chưa
            if (isset($_SESSION['username'])) {
                $username = $_SESSION['username'];
                echo "<span>Tài khoản: $username</span>
                <a class='btn btn-logout' href='logout.php'>Đăng xuất</a>";
            } else {
                // Nếu chưa đăng nhập, bạn có thể chuyển hướng hoặc thực hiện hành động khác
                echo "<span>Bạn chưa đăng nhập!</span>
                <a class='btn btn-login' href='login.php'>Đăng nhập</a>";
            }
            ?>
            </div>
        </div>
    </header>

    <div class="container">
        <form class="search-bar" method="GET">
            <input type="text" name="query" placeholder="Tìm kiếm sản phẩm ...">
            <button>Tìm kiếm</button>
        </form>
    </div>
    <div class="container">
        <div class="product-container">
        </div>
    </div>
    <script>
        function showProductDetail(productId) {
            // Thêm mã JavaScript để xử lý hiển thị chi tiết sản phẩm dựa trên productId
            window.location.href = "detail.php";
        }
    </script>
</body>

</html>