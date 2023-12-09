<!DOCTYPE html>
<html lang="vi">

<head>
    <meta charset="UTF-8">
    <title>Quên mật khẩu</title>
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
        <h1>Quên mật khẩu</h1>
        <form action="" method="post">
            <input type="text" name="email" id="email" placeholder="Nhập email của bạn">

            <button type="submit" value="">
                Submit
            </button>
        </form>
    </div>
    <?php
    require 'vendor/autoload.php';

    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;

    $mail = new PHPMailer(true);

    include("variable.php");
    $conn = mysqli_connect($db_server, $db_username, $db_password, $db_name);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $mail = new PHPMailer(true);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_email = $_POST["email"];

        $token = bin2hex(random_bytes(16));
        $_SESSION['reset_token'] = $token;

        try {
            //Server settings
            $mail->isSMTP();
            $mail->Host       = 'smtp.gmail.com';
            $mail->SMTPAuth   = true;
            $mail->Username   = 'mail.no.reply.2023@gmail.com';
            $mail->Password   = 'ymlk mzjv wxpk iyty';
            $mail->SMTPSecure = 'tls';
            $mail->Port       = 587;

            //Recipients
            $mail->setFrom('mail.no.reply.2023@gmail.com', 'LAB');
            $mail->addAddress($user_email, 'User');

            //Content
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body = 'Click the following link to reset your password: http://' . $_SERVER['HTTP_HOST'] . '/dvwa/vulnerabilities/password-reset-poisoning/reset-password.php?token=' . $token;

            // Lưu token vào database
            $sql = "UPDATE users SET token='$token' WHERE email='$user_email'";
            $conn->query($sql);

            $mail->send();
            echo '<div class="alert">Email khôi phục mật khẩu đã được gửi. Vui lòng kiểm tra email của bạn!.</div>';
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        }
    }

    // Đóng kết nối database
    $conn->close();
    ?>

</body>

</html>