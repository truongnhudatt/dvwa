<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
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
            padding: 10px;
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
        <h1>Đăng nhập</h1>
        <form action="" method="post">
            <input type="text" name="email" id="email" placeholder="Email">

            <input type="password" name="password" id="password" placeholder="Password">

            <button type="submit" value="Đăng nhập">
                Đăng nhập
            </button>
            <a href="forgot-password.php">Bạn quên mật khẩu?</a>
        </form>
    </div>


    <?php
    session_start();

    // Kết nối với database
    include("variable.php");
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    // Kiểm tra kết nối
    if (!$conn) {
        die('Không thể kết nối với database: ' . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kiểm tra dữ liệu nhập vào
        if (empty($_POST['email']) || empty($_POST['password'])) {
            echo '<script>alert("Vui lòng nhập đầy đủ thông tin!");</script>';
        } else {
            // Lấy giá trị từ form
            $email = $_POST["email"];
            $password = $_POST["password"];

            // Kiểm tra xem email có tồn tại trong cơ sở dữ liệu hay không
            $checkEmailQuery = "SELECT * FROM users WHERE email = '$email'";
            $checkEmailResult = mysqli_query($conn, $checkEmailQuery);

            if ($checkEmailResult && mysqli_num_rows($checkEmailResult) > 0) {
                // Nếu username tồn tại, kiểm tra mật khẩu
                $user = mysqli_fetch_assoc($checkEmailResult);

                if (password_verify($password, $user['password'])) {
                    // Lấy thông tin người dùng
                    $_SESSION['user_email'] = $user['email'];

                    // Hiển thị thông báo đăng nhập thành công và thông tin người dùng (không bao gồm mật khẩu) bằng JavaScript
                    echo '<script>window.onload = function() { alert("Đăng nhập thành công. Xin chào ' . $user['email'] . '!"); window.location.href = "index.php"; }</script>';
                    header("refresh:5;URL=index.php");
                } else {
                    // Đăng nhập thất bại
                    echo '<script>alert("Sai mật khẩu.");</script>';
                }
            } else {
                // Nếu username không tồn tại
                echo '<script>alert("Tài khoản không tồn tại.");</script>';
            }
        }
    }

    // Ngắt kết nối với database
    mysqli_close($conn);
    ?>

</body>

</html>