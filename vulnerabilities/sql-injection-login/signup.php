<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đăng ký</title>
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
        <h1>Đăng ký</h1>
        <form action="" method="post">
            <input type="text" name="username" id="username" placeholder="Username">

            <input type="password" name="password" id="password" placeholder="Password">

            <button type="submit" value="Đăng ký">
                Đăng ký
            </button>

        </form>

        <?php
        // Kết nối với database
        $conn = mysqli_connect('localhost', 'root', '', 'lab');

        // Kiểm tra kết nối
        if (!$conn) {
            die('Không thể kết nối với database: ' . mysqli_connect_error());
        }

        // Kiểm tra nếu có dữ liệu được gửi từ form
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Kiểm tra dữ liệu nhập vào
            if (empty($_POST['username']) || empty($_POST['password'])) {
                echo 'Vui lòng nhập đầy đủ thông tin.';
            } else {
                // Lấy giá trị từ form
                $username = mysqli_real_escape_string($conn, $_POST['username']);
                $password = mysqli_real_escape_string($conn, $_POST['password']);

                // Kiểm tra xem tên đăng nhập đã tồn tại chưa
                $checkUserQuery = "SELECT * FROM users WHERE username = '$username'";
                $checkUserResult = mysqli_query($conn, $checkUserQuery);

                if (mysqli_num_rows($checkUserResult) > 0) {
                    // Tên đăng nhập đã tồn tại
                    echo 'Tên đăng nhập đã tồn tại. Vui lòng chọn tên đăng nhập khác.';
                } else {
                    // Tên đăng nhập chưa tồn tại, thêm mới vào database
                    $insertQuery = "INSERT INTO users (username, password) VALUES ('$username', '$password')";
                    $result = mysqli_query($conn, $insertQuery);

                    if ($result) {
                        // Hiển thị thông báo đăng ký thành công bằng JavaScript
                        echo 'Đăng ký thành công.';
                    } else {
                        // Hiển thị thông báo đăng ký thất bại
                        echo 'Đăng ký thất bại.';
                    }
                }
            }
        }

        // Ngắt kết nối với database
        mysqli_close($conn);
        ?>



</body>

</html>