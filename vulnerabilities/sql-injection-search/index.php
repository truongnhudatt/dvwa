<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link href='https://fonts.googleapis.com/css?family=Montserrat' rel='stylesheet'>
    <link href="https://fonts.googleapis.com/css2?family=Courier+Prime&display=swap" rel="stylesheet">
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
            /* Màu nền trắng với độ trong suốt 90% */
            position: relative;
            /* Đặt vị trí của container là relative */
            z-index: 1;
            /* Đặt chỉ số z để đè lên phần nền */
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

        .logo {
            font-family: Montserrat, sans-serif;
            font-weight: bold;

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

        .search-bar {
            display: flex;
            align-items: center;
            margin-left: auto;
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
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            cursor: pointer;
            transition: transform 0.2s, box-shadow 0.2s;

        }


        .product:hover {
            transform: scale(1.05);
        }

        .product-image img {
            width: 200px;
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
            text-align: left;
            font-size: 20px;
            margin: 10px 0;
            color: #d0021c;
        }

        .star {
            color: #FFD700;
        }

        a {
            text-decoration: none;
            color: #fff;
            font-weight: 500;
        }

        a:hover {
            text-decoration: none;
            opacity: 0.8;
        }

        .truncate-text {
            margin-bottom: 10px;
            font-size: 14px;
            text-align: justify;
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3.6em;
        }

        .btn {
            background-color: #ca5357;
            opacity: 1;
            color: #fff;
            padding: 10px;
            border: none;
            border-radius: 5px;
            text-decoration: none !important;
        }

        .btn:hover {
            opacity: 0.8;
        }

        .user-info>span {
            margin-right: 40px;
        }

        .detail-btn {
            color: black;

        }

        .detail-btn:hover,
        h3:hover {
            color: #0056b3;
        }

        .image {
            width: 100%;

        }
    </style>
    <title>Trang chủ</title>
</head>

<body>
    <?php
    include("install.php")
    ?>
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
                <span>Tài khoản: Labtainer</span>
                <a class="btn" href="#">Đăng xuất</a>
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
            <!-- Sản phẩm 1 -->
            <?php
            $sql = "SELECT * FROM product";
            if (isset($_GET['query'])) {
                $query = $_GET['query'];
                $sql = "SELECT * FROM product WHERE name_ LIKE '%" . $query . "%';";
            }
            // $sql = "SELECT * FROM lab.product WHERE name_ LIKE '%aaa%' or 1=1 #%';";
            // echo $sql;
            include("db_helper.php");
            $result = excuteSQL($sql);
            include("log.php");
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo "	<div class='product'>
                                <div class='product-image'>
                                    <img class='image' src='./img/{$row['link_image']}' alt='{row['name_']}'>
                                </div>
                                <div class='product-details'>
                                    <h3>{$row['name_']}</h3>
                                    <div class='truncate-text'>
                                    {$row['des_']}
                                    </div>
                                    <div class='rating'>
                                    {$row['price']}$
                                    </div>
                                    <a class='detail-btn' href='product.php'>Xem chi tiết</a>
                                </div>
                            </div>";
                    // log_query($row['name_']);
                    // log_query($row['des_']);
                }
            } else {
                echo "Không tìm thấy sản phẩm nào.";
            }
            ?>


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