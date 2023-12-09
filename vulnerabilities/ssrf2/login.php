<!DOCTYPE html>
<html>
<?php 
    include('install.php');
?>
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
            padding: 8px;
            border: 2px solid #000000;
            border-radius: 20px;
            font-size: 16Wpx;
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
        <div class="form">
            <div class="textbox">
                <label for="username">Tên đăng nhập</label>
                <input id="username" type="text" name="username" placeholder="">
            </div>
            <div class="textbox">
                <label for="password">Mật khẩu</label>
                <input id="password" type="password" name="password" placeholder="">
            </div>
            <div class="error-message"></div>
            <input onClick="submitLogin()" class="custom-button" type="submit" name="submit" value="Đăng nhập">
        </div>
    </div>
</body>
<script>
    function submitLogin() {
            const username = document.getElementById('username').value;
            const password = document.getElementById('password').value;
            
            // Tạo dữ liệu XML
            const xmlData = `
                <login>
                    <username>${username}</username>
                    <password>${password}</password>
                </login>
            `;
            // console.log(xmlData);
            // Gửi yêu cầu POST XML đến máy chủ
            console.log("Request ...")
            fetch('handle_login.php', {
                method: 'POST',
                body: xmlData,
                headers: {
                    'Content-Type': 'text/xml'
                }
            })
            .then(response => response.json())
            .then(data => {
                if (data.status === 'success') {
                    console.log("Đăng nhập thành công:", data.message);
                    // Chuyển hướng người dùng
                    window.location.href = 'index.php';
                } else {
                    console.error('Lỗi:', data.message);
                    const errorMessage = document.querySelector('.error-message');
                    errorMessage.textContent = data.message;
                    errorMessage.style.display = 'block';
                }
            })
            .catch(error => {
                console.error('Lỗi:', error);
            });
        }
</script>
</html>
