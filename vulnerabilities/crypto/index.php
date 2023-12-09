<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.jsdelivr.net/npm/node-forge@1.0.0/dist/forge.min.js"></script>
    <script src="https://bundle.run/buffer@6.0.3"></script>
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
            background-color: rgba(255, 255, 255, 0.9); /* Màu nền trắng với độ trong suốt 90% */
            position: relative; /* Đặt vị trí của container là relative */
            z-index: 1; /* Đặt chỉ số z để đè lên phần nền */
        }

        .background {
            background: url('background.jpg') no-repeat center center fixed;
            background-size: cover;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            z-index: 0; /* Đặt chỉ số z của phần nền thấp hơn để nó nằm sau container */
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
            margin-left: auto; /* Đẩy phần search-bar sang bên phải */
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
            justify-content: flex-start; /* Bắt đầu từ trái sang phải */
            gap: 30px; /* Khoảng cách giữa các sản phẩm */
        }

        .product {
            width: calc(25% - 30px); /* 25% để hiển thị 4 sản phẩm trên 1 hàng */
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
            object-fit:cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-details h3 {
            text-align:left;
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
            max-height: 3.6em; /* Chiều cao tối đa 3 dòng */
        }
    </style>

</head>
<?php
    include('install.php');
?>
<body>
    <!-- <div>
        <input type="text" class="name">
        <button onclick="submit()">Submit</button>
    </div> -->
    <header>
        <div class="header-container">
            <h1>Store</h1>
            <nav>
                <ul>
                    <li><a href="#">Trang chủ</a></li>
                    <li><a href="#">Sản phẩm</a></li>
                </ul>
            </nav>
        </div>
    </header>
    <div class="container">
        <div class="search-bar">
            <input type="text" class="query" name="query" placeholder="Tìm kiếm sản phẩm ...">
            <button onclick="submit('http://<?php echo $_SERVER['HTTP_HOST']; ?>/DVWA/vulnerabilities/crypto/image/')">Tìm kiếm</button>
        </div>
    </div>
    <div class="container query-result" style="margin-top: 15px;">
        
    </div> 
    <div class="container">
        <div id="product-list" class="product-container" >
            <!-- Product list -->
        </div>
    </div>
</body>
    <script src="script.js"></script>
    <script>
        var urlImage = 'http://<?php echo $_SERVER['HTTP_HOST']; ?>/DVWA/vulnerabilities/crypto/image/';
        var productList = document.querySelector('.product-container');
        async function fetchDataAndUse() {
            try {
                var products = await fetchAllProduct();
                for (var i = 0; i < products.length; i++) {
                    let product = products[i];
                    var productDiv = document.createElement('div');
                    productDiv.className = 'product';

                    var productImageDiv = document.createElement('div');
                    productImageDiv.className = 'product-image';
                    var image = document.createElement('img');
                    image.src = `${urlImage}${products[i].link_image}`;
                    image.alt = '';
                    productImageDiv.appendChild(image);

                    var productDetailsDiv = document.createElement('div');
                    productDetailsDiv.className = 'product-details';
                    var nameHeader = document.createElement('h3');
                    nameHeader.textContent = products[i].name;
                    var ratingDiv = document.createElement('div');
                    ratingDiv.className = 'rating';
                    var truncateTextDiv = document.createElement('div');
                    truncateTextDiv.className = 'truncate-text';
                    truncateTextDiv.textContent = products[i].des;
                    var link = document.createElement('a');
                    link.href = '#';
                    link.textContent = 'Xem chi tiết';
                    productDetailsDiv.appendChild(nameHeader);
                    productDetailsDiv.appendChild(ratingDiv);
                    productDetailsDiv.appendChild(truncateTextDiv);
                    productDetailsDiv.appendChild(link);

                    // Thêm các phần tử vào productDiv
                    productDiv.appendChild(productImageDiv);
                    productDiv.appendChild(productDetailsDiv);

                    productList.appendChild(productDiv);
                }
                // console.log("Hi");
                // console.log(productList);
            } catch (error) {
            // Xử lý lỗi ở đây nếu có
                console.log(error);
            }
        }
        fetchDataAndUse();
    </script>
</html>