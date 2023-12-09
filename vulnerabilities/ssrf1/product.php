<!DOCTYPE html>
<html>
<head>
    <title>Chi tiết sản phẩm</title>
    <link rel="stylesheet" href="product_detail.css">
</head>
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
    <?php
    // Simulate product data
    include("variable.php");
    $id = 1;
    $product = null;
    if (isset($_GET['id'])) {
        $id = $_GET['id'];
        
    }
    try {
        $pdo = new PDO("mysql:host=localhost;dbname=ssrf1", $db_username, $db_password); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $stmt = $pdo->prepare("SELECT * FROM product WHERE id = :id");
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
    
        if ($product) {
            $product = [
                "image" => $product["link_image"],
                "name" => $product["name"],
                "description" => $product["des"],
                "price" => $product["price"],
                "rating" => 4
        
            ];
        } else {
            echo "Không tìm thấy sản phẩm với ID: " . $id;
        }
    } catch (PDOException $e) {
        echo "Lỗi: " . $e->getMessage();
    }
    ?>
    <header>
        <div class="header-container">
            <h1>Toys Store</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Trang chủ</a></li>
                    <li><a href="index.php">Sản phẩm</a></li>
                </ul>
            </nav>
            <div class="user-info">
                <span><?php echo $username ?></span>
                <a href="logout.php">Đăng xuất</a>
            </div>
        </div>
    </header>
    <div class="product-detail-full">
        <h1><?php echo $product['name']; ?></h1>
        <img class="image-product" src="<?php echo "./image/".$product['image']; ?>" alt="<?php echo $product['name']; ?>">
        <p><?php echo $product['description']; ?></p>
        <div class="rating">
            <?php
            echo "<br>Price: ".$product["price"]."$ <br>";
            echo "Rating: ";
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
        <?php
            $cities = null;
            try {
                $pdo = new PDO("mysql:host=localhost;dbname=ssrf1", $db_username, $db_password); 
                $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                $stmt = $pdo->query("SELECT * FROM city");
                $cities = $stmt->fetchAll(PDO::FETCH_ASSOC);
            
            } catch (PDOException $e) {
                echo "Lỗi: " . $e->getMessage();
            }
        ?>
        <div style="margin-top:20px"></div>
        <div class="quantity-check">
            <label for="location">Chọn địa điểm kiểm tra số lượng còn hàng:</label>
            <div class="custom-select">
                <select id="location">
                    <?php
                    foreach($cities as $city)
                        echo "<option value='".$city['id']."'>".$city['name']."</option>";
                    ?>
                </select>
                <div class="select-arrow"></div>
            </div>
            <button id="check-button">Kiểm tra</button>
            <div class="product-count"></div>
            <div style="margin-top:20px"></div>
            <label for="quantity">Số lượng:</label>
            <input type="number" id="quantity" value="1" min="1" max="10">
            <button id="add-to-cart">Thêm vào giỏ hàng</button>
        </div>
    </div>
    <footer>
        <p class="text-footer">&copy; 2023 Cửa hàng của chúng tôi. Tất cả quyền được bảo vệ.</p>
    </footer>
    <script>
        document.getElementById("check-button").addEventListener("click", function () {
            var idCity = document.getElementById("location").value;
            var productCountElement = document.querySelector(".product-count");
            var idProduct = <?php echo $id ?>;
            var url = `check-stock.php`;
            var apiUrl = `http://<?php echo $_SERVER['HTTP_HOST']; ?>/dvwa/vulnerabilities/ssrf1/data.php?idProduct=${idProduct}&idCity=${idCity}`;
            fetch(url, {
                method: "POST", 
                body: JSON.stringify({ url: apiUrl }),
                headers: {
                    "Content-Type": "application/json"
                }
            })
            .then(response => response.json())
            .then(data => {
                // Xử lý dữ liệu từ phản hồi API ở đây
                productCountElement.innerHTML = `Số lượng hàng còn lại tại kho là: ${data.message}`;
                console.log(data.message);
            })
            .catch(error => {
                console.error("Lỗi khi gửi yêu cầu API: " + error);
            });
        });
    </script>
</body>
</html>
