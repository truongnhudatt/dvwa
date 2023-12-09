<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng nhập</title>
    <style>
        body {
            font-family: sans-serif;
        }

        h1 {
            text-align: center;
            margin-bottom: 50px;
        }

        .container {
            width: 500px;
            margin: 100px auto;
            border: 1px solid #dadce0;
            border-radius: 8px;
            padding: 50px 10px 50px 10px;
        }

        form {
            position: relative;
            margin-bottom: 100px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
        }

        input {
            width: 60%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            margin-bottom: 20px;
            outline: none;
        }

        input:focus {
            outline: #1A73E8 2px solid;
        }

        button {
            background-color: rgb(26, 115, 232);
            color: #fff;
            padding: 12px 15px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            position: absolute;
            left: 50%;
            bottom: -50px;
            transform: translate(-50%, 50%);
        }
    </style>
</head>

<body>
    <div class="container">
        <h1>Đăng nhập</h1>
        <form action="" method="post">
            <input type="text" name="username" id="username" placeholder="Username">

            <input type="password" name="password" id="password" placeholder="Password">

            <button type="submit" value="Đăng ký">
                Đăng nhập
            </button>

        </form>
    </div>
    <?php
    session_start();
    // Kết nối với database
    $conn = mysqli_connect('localhost', 'root', '', 'lab_sql_login');

    // Kiểm tra kết nối
    if (!$conn) {
        die('Không thể kết nối với database: ' . mysqli_connect_error());
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Kiểm tra dữ liệu nhập vào
        if (empty($_POST['username']) || empty($_POST['password'])) {
            echo '<script>alert("Vui lòng nhập đầy đủ thông tin!");</script>';
        } else {
            // Lấy giá trị từ form
            $username = $_POST["username"];
            $password = $_POST["password"];

            // Kiểm tra xem username có tồn tại trong cơ sở dữ liệu hay không
            $checkUsernameQuery = "SELECT * FROM users WHERE username = '$username'";
            $checkUsernameResult = mysqli_query($conn, $checkUsernameQuery);

            if ($checkUsernameResult && mysqli_num_rows($checkUsernameResult) > 0) {
                // Nếu username tồn tại, kiểm tra mật khẩu
                $sql = "SELECT * FROM users WHERE username = '$username' AND password = '$password'";
                $result = mysqli_query($conn, $sql);

                if ($result && mysqli_num_rows($result) > 0) {
                    // Lấy thông tin người dùng
                    $user = mysqli_fetch_assoc($result);
                    $_SESSION['username'] = $user['username'];

                    // Hiển thị thông báo đăng nhập thành công và thông tin người dùng (không bao gồm mật khẩu) bằng JavaScript
                    echo '<script>window.onload = function() { alert("Đăng nhập thành công. Xin chào ' . $user['username'] . '!"); window.location.href = "index.php"; }</script>';
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