<?php
session_start();
include("install.php")
?>

<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
        }

        .container {
            max-width: 80%;
            margin: 0 auto;
            background-color: rgba(255, 255, 255, 0.9);
            position: relative;
            z-index: 1;
        }

        .background {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0;
        }

        header {
            background-color: #ad171c;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .header-container {
            margin-left: 50px;
            margin-right: 50px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        nav ul {
            list-style: none;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin: 0 10px;
        }

        nav a {
            text-decoration: none;
            color: #fff;
        }

        .user-info {
            display: flex;
            align-items: center;
        }

        .user-info span {
            margin-right: 10px;
        }

        .user-info a {
            color: #fff;
            text-decoration: underline;
        }

        .personal-info {
            display: flex;
            flex-direction: column;
            color: #fff;
            font-size: 14px;
            text-align: right;
        }

        /* Search bar */
        /* Trong tệp style.css */
        /* Trong tệp style.css */
        .search-bar {
            display: flex;
            align-items: center;
            margin-left: auto;
            /* Đẩy phần search-bar sang bên phải */
        }

        .search-bar input[type="text"] {
            margin-top: 30px;
            width: 600px;
            padding: 10px;
            border: 2px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
            outline: none;
            transition: border-color 0.3s;
        }

        .search-bar input[type="text"]:focus {
            border-color: #007bff;
        }

        .search-bar button {
            margin-top: 30px;
            margin-left: 20px;
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .search-bar button:hover {
            background-color: #0056b3;
        }

        /* Product */
        .product-container {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            /* Bắt đầu từ trái sang phải */
            gap: 30px;
            /* Khoảng cách giữa các sản phẩm */
        }

        .product {
            width: calc(25% - 30px);
            /* 25% để hiển thị 4 sản phẩm trên 1 hàng */
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }


        .product:hover {
            transform: scale(1.05);
        }

        .product-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-details h3 {
            text-align: left;
            font-size: 18px;
            margin: 10px 0;
        }

        .rating {
            font-size: 20px;
            margin: 10px 0;
        }

        .star {
            color: #FFD700;
        }

        .truncate-text {
            margin-bottom: 10px;
            font-size: 14px;
            text-align: left;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3.6em;
        }

        .btn{
            background-color: #ca5357;
            opacity: 1;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none !important;
        }
        .btn:hover{
            opacity: 0.8;
        }

        .user-info > span{
            margin-right: 40px;
        }
    </style>
</head>

<body>
    <header>
        <div class='header-container'>
            <h1>Toys Store</h1>
            <nav>
                <ul>
                    <li><a href='#'>Trang chủ</a></li>
                    <li><a href='#'>Sản phẩm</a></li>
                    <li><a href='#'>Giỏ hàng</a></li>
                    <li><a href='profile.php'>Thông tin cá nhân</a></li>
                </ul>
            </nav>
            <div class='user-info'>
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
    <div class='container'>
        <form class='search-bar' method='GET'>
            <input type='text' name='query' placeholder='Tìm kiếm sản phẩm ...'>
            <button>Tìm kiếm</button>
        </form>
    </div>

</body>

</html>