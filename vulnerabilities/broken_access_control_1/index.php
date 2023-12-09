<?php
session_start();
include("install.php");
$_SESSION = array();
?>
<!DOCTYPE html>
<html>

<head>
    <title>Trang Đăng Nhập</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!--===============================================================================================-->
    <link rel="icon" type="image/png" href="images/icons/favicon.ico" />
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/bootstrap/css/bootstrap.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="fonts/font-awesome-4.7.0/css/font-awesome.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/animate/animate.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/css-hamburgers/hamburgers.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="vendor/select2/select2.min.css">
    <!--===============================================================================================-->
    <link rel="stylesheet" type="text/css" href="css/util.css">
    <link rel="stylesheet" type="text/css" href="css/main.css">
</head>

<body>
    <?php
    include("variable.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $username = $_POST["username"];
        $password = $_POST["password"];
        $conn = new mysqli($db_server, $db_username, $db_password, $db_name);
        if ($conn->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
        }
        $sql = "SELECT id, username, password FROM user WHERE username = ?";
        $id = null;
        if ($stmt = $conn->prepare($sql)) {
            $stmt->bind_param("s", $username);
            $stmt->execute();
            $stmt->bind_result($user_id, $user_username, $user_password);

            $stmt->bind_result($user_id, $user_username, $user_password);
            if ($stmt->fetch()) {
                if (password_verify($password, $user_password)) {
                    $_SESSION["loggedin"] = true;
                    $_SESSION["id"] = $user_id;
                } else {
                    echo "Thông tin đăng nhập không chính xác.";
                }
            } else {
                echo "Thông tin đăng nhập không chính xác.";
            }
        }
        $conn->close();
    }
    if (isset($_GET['returnUrl'])) {
        $returnUrl = $_GET['returnUrl'];
    }
    if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["id"])) {
        $userId = $_SESSION["id"];

        $db = new mysqli($db_server, $db_username, $db_password, $db_name);
        if ($db->connect_error) {
            die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
        }
        $query_role = "SELECT role FROM user WHERE id = '$userId'";
        $result_role = $db->query($query_role);
        if ($result_role) {
            $row_role = $result_role->fetch_assoc();
            $role = $row_role['role'];
            $_SESSION["role"] = $role;
            header("Location: tables.php");
            exit;
        }
        $db->close();
    } else {
    ?>
        <div class="limiter">
            <div class="container-login100">
                <div class="wrap-login100">
                    <div class="login100-pic js-tilt" data-tilt>
                        <img src="images/img-01.png" alt="IMG">
                    </div>
                    <form class="login100-form validate-form" method="post" action="<?php echo $_SERVER["PHP_SELF"]; ?>">
                        <span class="login100-form-title">
                            Login
                        </span>
                        <div class="wrap-input100 validate-input" data-validate="Valid email is required: ex@abc.xyz">
                            <input class="input100" type="text" id="username" name="username" required placeholder="Email">
                        </div>
                        <div class="wrap-input100 validate-input" data-validate="Password is required">
                            <input class="input100" type="password" id="password" name="password" required placeholder="Password">
                        </div>
                        <div class="container-login100-form-btn">
                            <input class="login100-form-btn" type="submit" value="Login">
                        </div>
                        <div class="text-center p-t-12">
                            <span class="txt1">
                            </span>
                            <a class="txt2" href="#">
                            </a>
                        </div>
                        <div class="text-center p-t-136">
                            <a class="txt2" href="#">
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <script src="vendor/jquery/jquery-3.2.1.min.js"></script>
        <script src="vendor/bootstrap/js/popper.js"></script>
        <script src="vendor/bootstrap/js/bootstrap.min.js"></script>
        <script src="vendor/select2/select2.min.js"></script>
        <script src="vendor/tilt/tilt.jquery.min.js"></script>
        <script>
            $('.js-tilt').tilt({
                scale: 1.1
            })
        </script>
    <?php
    }
    ?>
</body>

</html>