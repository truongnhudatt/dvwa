<!DOCTYPE html>
<html>
<head>
    <title>Trang Đăng Nhập</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            text-align: center;
        }

        .login-box {
            width: 500px;
            margin: 150px auto;
            background: #fff;
            padding: 20px;
            padding-bottom:50px
            border-radius: 5px;
            box-shadow: 0px 0px 10px 0px #000;
        }

        .login-box h1 {
            font-size: 30px;
            margin-top:10px;
            margin-bottom: 30px;
            
        }

        .textbox {
            margin: 15px 0;
            
        }
        .textbox label {
            padding-left:50px;
            display: block;
            text-align: left;
            margin-top: 10px;
            font-size: 16px;
            margin-bottom: 8px;
        }

        .textbox input {
            width: 80%;
            padding: 10px;
            border: 2px solid #000000;
            border-radius: 20px;
            padding-left:12px;
            font-size: 16px;
            outline: none;
            margin-top: 5px;
        }

        .textbox input[type="text"], .textbox input[type="password"] {
            background-color: #f5f5f5;
        }

        .textbox input[type="submit"] {
            background-color: #4CAF50;
            color: #fff;
            border: none;
            border-radius: 5px;
            font-size: 18px;
            padding: 10px 20px;
            cursor: pointer;
        }

        .textbox input[type="submit"]:hover {
            background-color: #45a049;
        }
        .custom-button {
            background-color: #000;
            color: #fff;
            padding: 15px 50px;
            border: none;
            border-radius: 20px;
            font-size: 13px;
            cursor: pointer;
            margin-top: 20px;
            transition: background-color 0.3s;
        }

        .custom-button:hover {
            background-color: #007bff;
        }
        .wrapper {
            display: flex;
            justify-content: center; /* Căn giữa theo chiều ngang */
            align-items: center;
        }
        .error-message {
            display:none;
            width: 80%;
            color: black;
            margin: 0 auto;
            font-size: 12px;
            padding: 10px;
            text-align: center;
            border-radius: 5px;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <div class="wrapper">
    </div>
    <div class="login-box">
        <h1>Đăng nhập</h1>
        <form class="form" method="POST" action="login.php">
            <div class="textbox">
                <label for="username">Tên đăng nhập</label>
                <input id="username" type="text" name="username" placeholder="">
            </div>
            <div class="textbox">
                <label for="password">Mật khẩu</label>
                <input id="password" type="password" name="password" placeholder="">
            </div>
            <div class="error-message"></div>
            <input class="custom-button" type="submit" name="submit" value="Đăng nhập">
        </form>
    </div>
</body>
<?php
    session_start();
    if (isset($_POST['submit']) && $_POST['username']!="" && $_POST['password']!="") {
        $username = $_POST['username'];
        $password = $_POST['password'];
        include("variable.php");
        function passwordHash($password){
            return $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        }
        $conn = mysqli_connect($db_server, $db_username, $db_password,$db_name);

        if ($conn->connect_error) {
            $response = [
                        'status' => 'error',
                        'message' => 'Kết nối cơ sở dữ liệu thất bại.'
                    ];
        }
        $sql = "SELECT id, username, password FROM user WHERE username = ?";
        $id = null;
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($user_id, $db_username, $db_password);

            $stmt->bind_result($user_id, $db_username, $db_password);
            if ($stmt->fetch()) {
                if (password_verify($password, $db_password)) {
                    $_SESSION['username'] = $username;
                    header("Location: index.php");
                } else {
                    echo "Thông tin đăng nhập không chính xác.";
                }
            } else {
               echo "Thông tin đăng nhập không chính xác.";
            }
        }
        else {
            $response = [
                'status' => 'error',
                'message' => 'Sai tên đăng nhập hoặc mật khẩu.'
            ];
        }
    }
?>
</html>