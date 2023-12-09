<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Đặt lại mật khẩu</title>
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

        <h1>Đặt lại mật khẩu</h1>
        <form action="" method="post">
            <input type="password" name="newPassword" id="password" placeholder="Nhập mật khẩu mới">

            <input type="password" name="retypePassword" id="password" placeholder="Nhập lại mật khẩu mới">

            <button type="submit" value="Submit">
                Submit
            </button>
        </form>
    </div>
    <?php

    include("variable.php");
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    if (isset($_GET['token'])) {
        $token = $_GET['token'];
        if (strlen($token) === 32) {
            // Kiểm tra token và xác định email
            $sql = "SELECT email FROM users WHERE token='$token'";
            $result = $conn->query($sql);

            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $user_email = $row['email'];

                if (
                    isset($_POST['newPassword']) && !empty($_POST['newPassword']) &&
                    isset($_POST['retypePassword']) && !empty($_POST['retypePassword'])
                ) {
                    $newPassword = $_POST['newPassword'];
                    $retypePassword = $_POST['retypePassword'];

                    if ($newPassword === $retypePassword) {
                        // Cập nhật mật khẩu
                        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
                        $updateSql = "UPDATE users SET password='$hashedPassword', token=NULL WHERE email='$user_email'";
                        $conn->query($updateSql);

                        echo '<script>window.onload = function() { alert("Đặt lại mật khẩu thành công"); window.location.href = "login.php"; }</script>';
                        header("refresh:5;URL=login.php");
                        exit();
                    } else {
                        echo '<div class="alert">Mật khẩu không khớp.</div>';
                    }
                } else {
                    echo '<div class="alert">Vui lòng nhập đầy đủ thông tin!</div>';
                }
            } else {
                echo '<div class="alert">Token không hợp lệ.</div>';
                header("Location: login.php");
                exit();
            }
        } else {
            echo '<div class="alert">Đường dẫn không hợp lệ.</div>';
            header("Location: login.php");
            exit();
        }
    } else {
        echo '<div class="alert">Đường dẫn không hợp lệ.</div>';
        header("Location: login.php");
        exit();
    }

    // Đóng kết nối database
    $conn->close();
    ?>

</body>

</html>