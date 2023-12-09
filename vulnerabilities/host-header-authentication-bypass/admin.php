<!DOCTYPE html>
<html>

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>Trang Quản trị</title>
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

        header {
            background-color: #333;
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

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .truncate-text {
            margin-bottom: 10px;
            font-size: 14px;
            text-align: left;
            /* white-space: nowrap; */
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3.6em;
            /* Chiều cao tối đa 3 dòng */
        }

        body {
            font-family: Arial, sans-serif;
        }

        nav {
            background-color: #333;
            color: white;
            padding: 10px;
        }

        nav ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        nav ul li {
            display: inline;
            margin-right: 20px;
        }

        .content {
            padding: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 50px;
        }

        table,
        th,
        td {
            border: 1px solid #ddd;
        }

        th,
        td {
            padding: 10px 0 10px 20px;
            text-align: left;
        }

        .btn {
            color: #fff;
            padding: 10px 18px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }

        .btn-update {
            background-color: #0abb87;
        }

        .btn-delete {
            background-color: #ad171c;
            opacity: 0.8;
        }



        .btn-add {
            background-color: #007bff;
            margin-right: 40px;
        }

        .wrap-btn {
            float: right;
        }

        .h1 {
            margin-top: 50px;
            margin-left: 30px;
        }
    </style>
</head>

<body>
    <?php
    $hostHeader = null;

    if (isset($_SERVER['HTTP_HOST'])) {
        $hostHeader = $_SERVER['HTTP_HOST'];

        if ($hostHeader !== 'localhost') {
            echo '<script>window.onload = function() { alert("Trang chỉ hợp lệ với localusers"); window.location.href = "index.php"; }</script>';
            header("refresh:5;URL=index.php");
        } else {
            echo '
            <header>
            <div class="header-container">
                <h1>Administrator</h1>
                <nav>
                    <ul>
                        <li><a href="#">Trang chủ</a></li>
                        <li><a href="#">Quản lý sản phẩm</a></li>
                    </ul>
                </nav>
                <div class="user-info">
                    <span>Tên tài khoản: Labtainer</span>
                    <a href="#">Đăng xuất</a>
                </div>
            </div>
            </header>
    
            <h1 class="h1">Quản lý điện thoại di động</h1>
        
            <form class="wrap-btn" action="" method="">
                <button class="btn btn-add" type="submit" name="themDienThoai">Thêm điện thoại</button>
            </form>
        
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Tên điện thoại</th>
                        <th>Giá</th>
                        <th>Thao tác</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>1</td>
                        <td>iPhone 13</td>
                        <td>20,000,000 VND</td>
                        <td>
                            <button class="btn btn-update" onclick="suaDienThoai(1)">Sửa</button>
                            <button class="btn btn-delete" onclick="xoaDienThoai(1)">Xoá</button>
                        </td>
                    </tr>
                    <tr>
                        <td>2</td>
                        <td>Samsung Galaxy S21</td>
                        <td>18,000,000 VND</td>
                        <td>
                            <button class="btn btn-update" onclick="suaDienThoai(2)">Sửa</button>
                            <button class="btn btn-delete" onclick="xoaDienThoai(2)">Xoá</button>
                        </td>
                    </tr>
                    <tr>
                        <td>3</td>
                        <td>Google Pixel 6</td>
                        <td>15,000,000 VND</td>
                        <td>
                            <button class="btn btn-update" onclick="suaDienThoai(3)">Sửa</button>
                            <button class="btn btn-delete" onclick="xoaDienThoai(3)">Xoá</button>
                        </td>
                    </tr>
                    <tr>
                        <td>4</td>
                        <td>OnePlus 9</td>
                        <td>17,000,000 VND</td>
                        <td>
                            <button class="btn btn-update" onclick="suaDienThoai(4)">Sửa</button>
                            <button class="btn btn-delete" onclick="xoaDienThoai(4)">Xoá</button>
                        </td>
                    </tr>
                    <tr>
                        <td>5</td>
                        <td>Xiaomi Mi 11</td>
                        <td>16,000,000 VND</td>
                        <td>
                            <button class="btn btn-update" onclick="suaDienThoai(5)">Sửa</button>
                            <button class="btn btn-delete" onclick="xoaDienThoai(5)">Xoá</button>
                        </td>
                    </tr>
                </tbody>
            </table>';
        }
    }
    ?>



</body>

</html>