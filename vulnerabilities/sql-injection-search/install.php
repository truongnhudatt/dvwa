<?php
function hashPassword($password)
{
    // Mã hóa mật khẩu bằng phương thức password_hash
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    
    return $hashedPassword;
}
// Request khởi tạo database.
if (isset($_REQUEST["install.php"])) {
}
include("variable.php");
// Ket noi database
$link = new mysqli($db_server, $db_username, $db_password);

if ($link->connect_error) {
    die("Error fail: " . $link->connect_error);
}

$check_db_query = "SHOW DATABASES LIKE '$db_name'";
$check_db_result = $link->query($check_db_query);

if ($check_db_result->num_rows == 0) {
    // Cơ sở dữ liệu chưa tồn tại, hãy tạo mới
    $create_db_query = "CREATE DATABASE $db_name";
    $create_db_result = $link->query($create_db_query);

    if (!$create_db_result) {
        die("Error creating database: " . $link->error);
    }

    // Chon database
    mysqli_select_db($link, $db_name);

    /////////////////////////// KHỞI TẠO DỮ LIỆU DATABASE TỪ ĐÂY.///////////////////////////////////////

    // Tao bang product
    $sql = "CREATE TABLE IF NOT EXISTS product (
            id INT AUTO_INCREMENT NOT NULL,
            name_ VARCHAR(255),
            des_ TEXT,
            link_image VARCHAR(255),
            price INT,
            PRIMARY KEY (id)
        );";

    $recordset = $link->query($sql);

    if (!$recordset) {

        die("Error: " . $link->error);
    }

    // Tao bang user
    $sql = "CREATE TABLE useraccount (
        id INT AUTO_INCREMENT PRIMARY KEY,
        email VARCHAR(255) NOT NULL,
        password VARCHAR(255) NOT NULL,
        token VARCHAR(255)
    );";
    $recordset = $link->query($sql);
    if (!$recordset) {

        die("Error: " . $link->error);
    }

    //  Chèn dữ liệu bảng product
    $sql = "INSERT INTO product (name_, des_, link_image, price) VALUES
    ('iPhone 13 Pro', 'Một chiếc điện thoại thông minh mạnh mẽ và đầy đủ tính năng từ Apple. Trang bị vi xử lý A15 Bionic mới nhất, màn hình ProMotion, và hệ thống camera tiên tiến.', 'image1.jpg', 999),
    ('Samsung Galaxy S21', 'Điện thoại Android cao cấp của Samsung với một màn hình đẹp, vi xử lý mạnh mẽ Exynos/Snapdragon, và hệ thống camera đa dạng.', 'image2.jpg', 899),
    ('Google Pixel 6', 'Thiết bị Pixel mới nhất của Google với một camera tuyệt vời sử dụng công nghệ chụp ảnh tính toán, trải nghiệm Android thuần túy, và hiệu suất nhanh chóng.', 'image3.jpg', 799),
    ('OnePlus 9', 'Điện thoại cao cấp từ OnePlus, nổi tiếng với giao diện OxygenOS mượt mà, sạc nhanh, và sự hợp tác với Hasselblad cho tối ưu hóa camera.', 'image4.jpg', 749),
    ('Xiaomi Mi 11', 'Một chiếc flagship giá phải chăng từ Xiaomi, cung cấp vi xử lý Snapdragon, màn hình với tốc độ làm mới cao, và hệ thống camera đa dạng.', 'image5.jpg', 699),
    ('Huawei P50 Pro', 'Điện thoại cao cấp của Huawei với hệ thống camera mạnh mẽ, vi xử lý Kirin tiên tiến, và thiết kế thanh lịch.', 'image6.jpg', 1099),
    ('Sony Xperia 1 III', 'Thiết bị Xperia cao cấp của Sony nổi tiếng với màn hình OLED 4K, camera mạnh mẽ với quang học Zeiss, và khả năng âm thanh xuất sắc.', 'image7.jpg', 1299),
    ('OnePlus Nord 2', 'Một sản phẩm tầm trung từ OnePlus với sự tập trung vào trải nghiệm người dùng mượt mà, hiệu suất camera khá, và kết nối 5G.', 'image8.jpg', 499),
    ('Samsung Galaxy Z Fold 3', 'Điện thoại có thể gập độc đáo từ Samsung cung cấp một màn hình lớn có thể gập, hỗ trợ S Pen, và một thiết kế cao cấp.', 'image9.jpg', 1799),
    ('Google Pixel 5a', 'Sản phẩm Pixel giá rẻ của Google với sự tập trung vào chất lượng camera, Android gốc và pin lâu dài.', 'image10.jpg', 449);
    ";
    $recordset = $link->query($sql);
    if (!$recordset) {

        die("Error: " . $link->error);
    }

    $token = bin2hex(random_bytes(16));

    $userData = array(
        array('lab.username01@gmail.com', hashPassword('123'), hashPassword($token)),
        array('lab.victim@gmail.com', hashPassword('123'), hashPassword($token)),
        array('ndssadsandnnmmssn@gmail.com', hashPassword('123'), hashPassword($token)),
        array('user4@example.com', hashPassword('123'), hashPassword($token)),
        array('user5@example.com', hashPassword('123'), hashPassword($token))
    );


    // Chuẩn bị câu lệnh SQL INSERT
    $sql = "INSERT INTO useraccount (email, password, token) VALUES ";

    // Lặp qua mảng dữ liệu người dùng và thêm vào câu lệnh SQL
    foreach ($userData as $user) {
        $sql .= "('" . $user[0] . "', '" . $user[1] . "', '" . $user[2] . "'),";
    }

    // Loại bỏ dấu phẩy cuối cùng
    $sql = rtrim($sql, ',');
    $recordset = $link->query($sql);
    if (!$recordset) {

        die("Error: " . $link->error);
    }
    
} else {
    // echo "Database đã tồn tại.";
}
