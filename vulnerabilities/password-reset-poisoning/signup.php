<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .container {
            width: 500px;
            margin: 0 auto;
        }

        form {
            position: relative;
            margin-bottom: 100px;
        }

        input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        button {
            background-color: rgb(26, 115, 232);
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            left: 50%;
            bottom: -50px;
            transform: translate(-50%, 50%);
        }

        a {
            color: #0080ff;
            text-decoration: none;
        }

        .alert {
            display: flex;
            justify-content: center;
            text-align: center;
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đăng ký</h1>
        <form method="post">
            <input type="text" id="email" name="email" required placeholder="Email"><br>

            <input type="password" id="password" name="password" required placeholder="Password"><br>

            <button type="submit" value="Đăng kí">
                Đăng kí
            </button>
        </form>
    </div>

    <?php
    include("db_helper.php");

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $email = $_POST["email"];
        $password = $_POST["password"];

        // Mã hóa mật khẩu
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            echo '<script>alert("Định dạng email không hợp lệ. Vui lòng nhập một địa chỉ email hợp lệ.");</script>';
            exit();
        }
        // Tạo một token ngẫu nhiên với 32 ký tự (có thể điều chỉnh độ dài nếu cần)
        $token = bin2hex(random_bytes(16));


        // Chuẩn bị câu lệnh SQL
        $sql = "INSERT INTO users (email, password, token) VALUES (?, ?, ?)";

        // Kết nối đến cơ sở dữ liệu
        include("variable.php");
        $conn = new mysqli($db_server, $db_username, $db_password, $db_name);

        // Kiểm tra kết nối
        if ($conn->connect_error) {
            die("Kết nối không thành công: " . $conn->connect_error);
        }

        // Chuẩn bị câu lệnh SQL
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("sss", $email, $hashed_password, $token);

        // Thực hiện truy vấn SQL
        if ($stmt->execute()) {
            echo '<script>window.onload = function() { alert("Đăng kí thành công!"); window.location.href = "index.php"; }</script>';
            header("refresh:5;URL=index.php");
            exit();
        } else {
            echo '<script>alert("Tài khoản không tồn tại.");</script>';
        }

        $stmt->close();
        $conn->close();
    }
    ?>


</body>

</html>