<!DOCTYPE html>
<html>

<head>
    <title>Chi tiết sản phẩm</title>
    <style>
        /* style.css */
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        header {
            background-color: #ad171c;
            color: #fff;
            padding: 10px 0;
            text-align: center;
        }

        .logo {
            text-decoration: none;
            font-family: Montserrat, sans-serif;
            font-weight: bold;
            color: #FFF;
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

        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f2f2f2;
        }

        .product-detail-full {
            width: 100%;
            height: 100vh;
            background-color: #fff;
            padding: 20px;
        }

        h1 {
            font-size: 24px;
            margin: 10px 0;
        }

        .image-product {
            width: 100%;
            height: 600px;
            object-fit: cover;
            margin: 20px 0;
            border-radius: 5px;
        }

        p {
            font-size: 16px;
            margin: 10px 0;
            text-align: justify;
        }

        .rating {
            font-size: 20px;
            margin: 10px 0;
        }

        .star {
            color: #FFD700;
        }

        /* style.css */
        /* ... (các quy tắc CSS hiện có) */

        .custom-select {
            position: relative;
            display: inline-block;
            margin-right: 10px;
        }

        .custom-select select {
            appearance: none;
            -webkit-appearance: none;
            -moz-appearance: none;
            width: 200px;
            padding: 5px;
            border: 2px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
            outline: none;
            background-color: #fff;
        }

        .select-arrow {
            position: absolute;
            top: 50%;
            right: 10px;
            transform: translateY(-50%);
            width: 0;
            height: 0;
            border-left: 5px solid transparent;
            border-right: 5px solid transparent;
            border-top: 5px solid #777;
        }

        #check-button {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        #check-button:hover {
            background-color: #0056b3;
        }

        .quantity-check #quantity {
            width: 100px;
            text-align: center;
            padding: 5px;
            border: 2px solid #ccc;
            border-radius: 20px;
            font-size: 16px;
            outline: none;
            background-color: #fff;
        }

        .quantity-check #add-to-cart {
            background-color: #007bff;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 20px;
            cursor: pointer;
            transition: background-color 0.3s;
        }

        .quantity-check #add-to-cart:hover {
            background-color: #0056b3;
        }

        footer {
            background-color: #333;
            color: #fff;
            text-align: center !important;
            padding: 10px 0;
            bottom: 0;
            width: 100%;
            z-index: 1;
            /* Đặt chỉ số z để đè lên phần nền */
        }

        .text-footer {
            text-align: center;
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
    </style>
</head>

<body>
    <?php
    // Simulate product data
    $product = [
        'name' => 'Tên sản phẩm',
        'image' => "https://mekoong.com/wp-content/uploads/2022/12/Hinh-nen-4k-hoa-cuc-vang-scaled.jpg",
        'description' => 'Contrary to popular belief, Lorem Ipsum is not simply random text. It has roots in a piece of classical Latin literature from 45 BC, making it over 2000 years old. Richard McClintock, a Latin professor at Hampden-Sydney College in Virginia, looked up one of the more obscure Latin words, consectetur, from a Lorem Ipsum passage, and going through the cites of the word in classical literature, discovered the undoubtable source. Lorem Ipsum comes from sections 1.10.32 and 1.10.33 of "de Finibus Bonorum et Malorum" (The Extremes of Good and Evil) by Cicero, written in 45 BC. This book is a treatise on the theory of ethics, very popular during the Renaissance. The first line of Lorem Ipsum, "Lorem ipsum dolor sit amet..", comes from a line in section 1.10.32.',
        'rating' => 4.5
    ];
    ?>
    <header>
        <div class="header-container">
            <h1><a class="logo" href="index.php">PTIT Mobile</a></h1>
            <nav>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a></li>
                    <li><a href="#">Giỏ hàng</a></li>
                    <li><a href="#">Thông tin cá nhân</a></li>
                </ul>
            </nav>
            <div class="user-info">
                <span>Tên tài khoản: Labtainer</span>
                <a class="btn" href="#">Đăng xuất</a>
            </div>
        </div>
    </header>
    <div class="product-detail-full">
        <h1><?php echo $product['name']; ?></h1>
        <img class="image-product" src="<?php echo $product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <p><?php echo $product['description']; ?></p>
        <div class="rating">
            <?php
            $rating = $product['rating'];
            for ($i = 1; $i <= 5; $i++) {
                if ($i <= $rating) {
                    echo '<span class="star">&#9733;</span>';
                } else {
                    echo '<span class="star">&#9734;</span>';
                }
            }
            ?>
        </div>
        <div class="quantity-check">
            <label for="location">Chọn địa điểm kiểm tra số lượng còn hàng:</label>
            <div class="custom-select">
                <select id="location">
                    <option value="location1">Địa điểm 1</option>
                    <option value="location2">Địa điểm 2</option>
                    <option value="location3">Địa điểm 3</option>
                </select>
                <div class="select-arrow"></div>
            </div>
            <button id="check-button">Kiểm tra</button>
            <br>
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" value="1" min="1" max="10">
            <button id="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    </div>
</body>

</html>