<?php
session_start();
include("variable.php");

if (!isset($_SESSION["loggedin"])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION["id"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_SESSION['newUsername'];
    $newFullname = $_POST["fullname"];
    $newEmail = $_POST["email"];
    $newAddress = $_POST["address"];
    $newPhone = $_POST["phone"];
    $newAge = $_POST["age"];

    $db = new mysqli($db_server, $db_username, $db_password, $db_name);

    if ($db->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
    }

    $query = "UPDATE user SET fullname = '$newFullname', email = '$newEmail', address = '$newAddress', phone_number = '$newPhone', age = $newAge WHERE username = '$newUsername'";

    if ($db->query($query) === TRUE) {
        echo '<script>alert("Cập nhật thành công");</script>';
    } else {
        echo "Lỗi khi cập nhật: " . $db->error;
    }
    $db->close();
}

if (isset($_GET["id"])) {
    // Lấy tên người dùng từ URL
    $newUsername = $_GET["username"];
    $_SESSION['newUsername'] = $_GET["username"];
    $db = new mysqli($db_server, $db_username, $db_password, $db_name);

    if ($db->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
    }
    $query = "SELECT * FROM user WHERE id = '$newUsername'";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone_number'];
        $age = $row['age'];
    }
    $db->close();
}
?>
<!DOCTYPE html>
<html>

<head>
    <title>Chỉnh sửa thông tin cá nhân</title>
    <style>
        h2 {
            text-align: center;
            /* Căn giữa nội dung theo chiều ngang */
            display: block;
            /* Để ngăn phần tử h2 từ việc chia sẻ không gian với các phần tử khác */
        }

        /* CSS để tạo khung vuông */
        .form-wrapper {
            border: 1px solid #ccc;
            padding: 20px;
            max-width: 600px;
            /* Điều chỉnh kích thước của form theo chiều rộng tại đây */
            margin: 0 auto;
            background-color: #f5f5f5;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            /* Hiệu ứng bóng đổ */
        }

        /* CSS cho tiêu đề h2 */
        .form-wrapper h2 {
            font-size: 24px;
            margin-bottom: 20px;
        }

        /* CSS cho .form-container */
        .form-container {
            display: flex;
            justify-content: space-between;
        }

        /* CSS cho .form-column */
        .form-column {
            flex: 1;
            padding: 0 10px;
        }

        /* CSS để điều chỉnh khoảng cách giữa label và input */
        .form-group {
            margin-bottom: 20px;
        }

        /* CSS cho nhãn label */
        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 18px;
            margin-bottom: 10px;
            color: #333;
            /* Màu văn bản */
        }

        /* CSS cho input */
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Tạo hiệu ứng hover cho input */
        .form-group input:hover {
            border-color: #007bff;
        }

        /* Tạo hiệu ứng focus cho input */
        .form-group input:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* CSS cho input[type="number"] */
        .form-group input[type="number"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            font-size: 16px;
        }

        /* Tạo hiệu ứng hover cho input[type="number"] */
        .form-group input[type="number"]:hover {
            border-color: #007bff;
        }

        /* Tạo hiệu ứng focus cho input[type="number"] */
        .form-group input[type="number"]:focus {
            outline: none;
            border-color: #007bff;
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
        }

        /* CSS cho nút submit */
        .form-wrapper input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            font-size: 18px;
            margin-top: 20px;
        }

        .form-wrapper input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .form-group label {
            display: block;
            font-weight: bold;
            font-size: 20px;
            margin-bottom: 33px;
            color: #333;
            line-height: 1.4;
        }
    </style>
</head>

<body>
    <div class="form-wrapper">
        <h2>Chỉnh sửa thông tin cá nhân</h2>
        <form method="post" action="<?php echo $_SERVER["REQUEST_URI"]; ?>">
            <div class="form-container">
                <div class="form-column">
                    <div class="form-group">
                        <label for="fullname">Tên người dùng:</label>
                    </div>

                    <div class="form-group">
                        <label for="email">Địa chỉ email:</label>
                    </div>

                    <div class="form-group">
                        <label for="address">Địa chỉ:</label>
                    </div>

                    <div class="form-group">
                        <label for="phone">Số điện thoại:</label>
                    </div>

                    <div class="form-group">
                        <label for="age">Tuổi:</label>
                    </div>
                </div>

                <div class="form-column">
                    <div class="form-group">
                        <input type="text" id="fullname" name="fullname" value="<?php echo $fullname; ?>">
                    </div>

                    <div class="form-group">
                        <input type="text" id="email" name="email" value="<?php echo $email; ?>">
                    </div>

                    <div class="form-group">
                        <input type="text" id="address" name="address" value="<?php echo $address; ?>">
                    </div>

                    <div class="form-group">
                        <input type="text" id="phone" name="phone" value="<?php echo $phone; ?>">
                    </div>

                    <div class="form-group">
                        <input type="number" id="age" name="age" value="<?php echo $age; ?>">
                    </div>
                </div>
            </div>

            <input type="submit" value="Lưu">
        </form>
    </div>
</body>

</html>