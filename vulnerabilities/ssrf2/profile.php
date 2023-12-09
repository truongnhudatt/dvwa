<!DOCTYPE html>
<html>
<head>
    <title>Thông tin cá nhân</title>
    <link rel="stylesheet" type="text/css" href="profile.css">
</head>
<body>
    <?php
        session_start();
        // Kiểm tra xem người dùng đã đăng nhập hay chưa
        if (!isset($_SESSION['id'])) {
            header("Location: login.php");
            exit;
        }

        // Lấy thông tin người dùng từ phiên làm việc
        $id = $_SESSION['id'];

    ?>
    <?php 
        $sql = "SELECT * FROM user WHERE id = $id;";
        include("db_helper.php");
        $result = excuteSQL($sql);
        $fullname= "";
        $phone= "";
        $email = "";
        $username = "";
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $fullname= $row['fullname'];
                $phone= $row['phone'];
                $email = $row['email'];
                $username = $row['username'];
            }
        }
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
    <?php
        if(isset($_POST["form"]))
        {
            $fullname = $_POST["full-name"];
            $email = $_POST["email"];
            $phone = $_POST["phone"];
            $sql = "UPDATE user SET fullname='$fullname', email='$email', phone='$phone' WHERE id = $id";
            excuteSQL($sql); 

        }    
    ?>
    <div class="profile-container" style="margin-top:50px">
        <div class="profile-container-col">
            <h1>Thông tin cá nhân</h1>
            <form action="<?php echo($_SERVER["SCRIPT_NAME"]);?>" method="POST" enctype="multipart/form-data">
                <label for="full-name">Họ và tên:</label>
                <input type="text" id="full-name" name="full-name" value="<?php echo($fullname);?>" required>

                <label for="email">Địa chỉ email:</label>
                <input type="email" id="email" name="email" value="<?php echo($email);?>" required>

                <label for="phone">Số điện thoại:</label>
                <input type="text" id="phone" name="phone" value="<?php echo($phone);?>" required>
                <input id="button_submit" type="submit" name="form" value="Lưu thông tin"></input>
            </form>
        </div>
    </div>
    <footer>
        <p>&copy; 2023 Cửa hàng của chúng tôi. Tất cả quyền được bảo vệ.</p>
    </footer>
</body>
</html>
