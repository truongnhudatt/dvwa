<?php
// Request khởi tạo database.
if (isset($_REQUEST["install.php"])) {
}
include("variable.php");
// Ket noi database
$link = new mysqli($db_server, $db_username, $db_password);
if ($link->connect_error) {
    die("Error fail: " . $link->connect_error);
}
function passwordHash($password)
{
    return $hashed_password = password_hash($password, PASSWORD_DEFAULT);
}

$result = $link->query("SHOW DATABASES LIKE '$db_name'");
// Kiem tra database ton tai
if ($result->num_rows == 0) {
    // Tao database
    $sql = "CREATE DATABASE IF NOT EXISTS " . $db_name;
    $recordset = $link->query($sql);
    if (!$recordset) {
        die("Error: " . $link->error);
    }
    // Chon database
    mysqli_select_db($link, $db_name);
    // Tao bang user
    $sql = "CREATE TABLE IF NOT EXISTS user (
            id INT AUTO_INCREMENT PRIMARY KEY, 
            username VARCHAR(255), 
            password TEXT, 
            role TEXT,
            fullname TEXT, 
            email TEXT, 
            address TEXT, 
            phone_number TEXT, 
            avatar TEXT
        );";
    $recordset = $link->query($sql);
    if (!$recordset) {
        die("Error: " . $link->error);
    }
    $sql = "CREATE TABLE IF NOT EXISTS product (
        id INT AUTO_INCREMENT PRIMARY KEY, 
        value LONGTEXT
    );";
    $recordset = $link->query($sql);
    if (!$recordset) {
        die("Error: " . $link->error);
    }

    $sql = "INSERT INTO user (username, password, role, fullname, email, address, phone_number, avatar) VALUES
        ('admin', '" . passwordHash('ptit@123') . "', 'admin','ADMIN 1', 'email1@gmail.com', 'Hai Phong', '0123456789', './assets/img/male.jpg'),
        ('ptit1', '" . passwordHash('ptit@123') . "', 'user','PTIT 1', 'email2@gmail.com', 'Yen Bai', '0123456789', './assets/img/female.jpg'),
        ('ptit2', '" . passwordHash('ptit@123') . "', 'user','PTIT 2', 'email2@gmail.com', 'Ha Noi', '0123456789', './assets/img/male.jpg'),
        ('ptit3', '" . passwordHash('ptit@123') . "', 'user','PTIT 3', 'email3@gmail.com', 'Quang Ninh', '0123456789', './assets/img/female.jpg'),
        ('ptit4', '" . passwordHash('ptit@123') . "', 'user','PTIT 4', 'email4@gmail.com', 'Cao Bang', '0123456789', './assets/img/female.jpg'),
        ('ptit5', '" . passwordHash('ptit@123') . "', 'user','PTIT 5', 'email5@gmail.com', 'Ha Giang', '0123456789', './assets/img/male.jpg'),
        ('ptit6', '" . passwordHash('ptit@123') . "', 'user','PTIT 6', 'email6@gmail.com', 'Moc Chau', '0123456789', './assets/img/male.jpg'),
        ('ptit7', '" . passwordHash('ptit@123') . "', 'user','PTIT 7', 'email7@gmail.com', 'Thanh Hoa', '0123456789', './assets/img/female.jpg'),
        ('ptit8', '" . passwordHash('ptit@123') . "', 'user','PTIT 8', 'email8@gmail.com', 'Nghe An', '0123456789', './assets/img/female.jpg'),
        ('ptit9', '" . passwordHash('ptit@123') . "', 'user','PTIT 9', 'email9@gmail.com', 'Sapa', '0123456789', './assets/img/female.jpg'),
        ('ptit10', '" . passwordHash('ptit@123') . "', 'user','PTIT 10', 'email10@gmail.com', 'Dien Bien', '0123456789', './assets/img/male.jpg');";
    $recordset = $link->query($sql);
    $sql = "INSERT INTO product (value) VALUES
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product1.jpg\'></div><div class=\'product-details\'><h3>Product 1</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 1</div><a href=\'product.php?id=1\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product2.jpg\'></div><div class=\'product-details\'><h3>Product 2</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 2</div><a href=\'product.php?id=2\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product3.jpg\'></div><div class=\'product-details\'><h3>Product 3</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 3</div><a href=\'product.php?id=3\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product4.jpg\'></div><div class=\'product-details\'><h3>Product 4</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 4</div><a href=\'product.php?id=4\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product5.jpg\'></div><div class=\'product-details\'><h3>Product 5</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 5</div><a href=\'product.php?id=5\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product6.jpg\'></div><div class=\'product-details\'><h3>Product 6</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 6</div><a href=\'product.php?id=6\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product7.jpg\'></div><div class=\'product-details\'><h3>Product 7</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 7</div><a href=\'product.php?id=7\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product8.jpg\'></div><div class=\'product-details\'><h3>Product 8</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 8</div><a href=\'product.php?id=8\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product9.jpg\'></div><div class=\'product-details\'><h3>Product 9</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 9</div><a href=\'product.php?id=9\'>Xem chi tiết</a></div></div>'),
    ('<div class=\'product\'><div class=\'product-image\'><img src=\'./assets/img/product10.jpg\'></div><div class=\'product-details\'><h3>Product 10</h3><div class=\'rating\'></div><div class=\'truncate-text\'>Decription product 10</div><a href=\'product.php?id=10\'>Xem chi tiết</a></div></div>')";
    $recordset = $link->query($sql);
    if (!$recordset) {
        die("Error: " . $link->error);
    }
} else {
    // echo "Database đã tồn tại.";
}
