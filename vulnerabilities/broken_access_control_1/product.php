<?php
session_start();
include("./variable.php");

if (!isset($_SESSION["loggedin"])) {
    header("Location: index.php");
    exit;
}

$id = $_SESSION["id"];
$role = $_SESSION["role"];

if ($role == 'user') {
    header("Location: tables.php");
    exit;
}

if ($id) {
    $db = new mysqli($db_server, $db_username, $db_password, $db_name);

    if ($db->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
    }
    $query = "SELECT * FROM user WHERE id = $id";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $fullname = $row['fullname'];
        $email = $row['email'];
        $address = $row['address'];
        $phone = $row['phone_number'];
        $avatar = $row['avatar'];
    }
    $db->close();
}
if (isset($_GET['id'])) {
    $db = new mysqli($db_server, $db_username, $db_password, $db_name);
    if ($db->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
    }
    $productId = $_GET['id'];
    $query = "SELECT * FROM product WHERE id = $productId";
    $result = $db->query($query);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $product = $row;
    }
}
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newValue = $_POST["valueProduct"];
    $db = new mysqli($db_server, $db_username, $db_password, $db_name);

    if ($db->connect_error) {
        die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
    }

    $query = "UPDATE product SET value = $newValue WHERE id = $productId";

    if ($db->query($query) === TRUE) {
        header("Location: tables.php");
        echo '<script>alert("Cập nhật thành công");</script>';
    } else {
        echo "Lỗi khi cập nhật: " . $db->error;
    }
    $db->close();
}
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8" />
    <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
    <link rel="icon" type="image/png" href="../assets/img/favicon.png">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
    <title>
        Trang chủ
    </title>
    <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
    <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
    <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
    <link href="./assets/demo/demo.css" rel="stylesheet" />
    <style>
        .card {
            /* width: 300px; */
            border: 1px solid #ccc;
            border-radius: 5px;
            padding: 10px;
            margin: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card img {
            width: 100%;
            border-radius: 5px;
            margin-bottom: 10px;
        }

        .card h2 {
            font-size: 18px;
            margin-bottom: 5px;
        }

        .card p {
            font-size: 14px;
            color: #555;
        }

        .product-container {
            margin-top: 50px;
            display: flex;
            flex-wrap: wrap;
            justify-content: flex-start;
            /* Bắt đầu từ trái sang phải */
            gap: 30px;
            /* Khoảng cách giữa các sản phẩm */
        }

        .product {
            width: calc(25% - 30px);
            /* 25% để hiển thị 4 sản phẩm trên 1 hàng */
            margin-bottom: 20px;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ddd;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
            text-align: center;
            transition: transform 0.2s, box-shadow 0.2s;
        }


        .product:hover {
            transform: scale(1.05);
        }

        .product-image img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            border-radius: 8px;
            margin-bottom: 10px;
        }

        .product-details h3 {
            text-align: left;
            font-size: 18px;
            margin: 10px 0;
        }

        .rating {
            font-size: 20px;
            margin: 10px 0;
        }

        .star {
            color: #FFD700;
        }

        a {
            text-decoration: none;
            color: #007bff;
            font-weight: 500;
        }

        a:hover {
            text-decoration: underline;
            color: #0056b3;
        }

        .truncate-text {
            margin-bottom: 10px;
            font-size: 14px;
            text-align: left;
            /* white-space: nowrap; */
            overflow: hidden;
            text-overflow: ellipsis;
            max-height: 3.6em;
            /* Chiều cao tối đa 3 dòng */
        }

        .modal {
            display: none;
            position: fixed;
            z-index: 1;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.4);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 60%;
        }

        .close {
            position: absolute;
            right: 10px;
            margin-top: -15px;
            color: #aaa;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>

<body class="">
    <div class="wrapper">
        <div class="sidebar" data-color="white" data-active-color="danger">
            <div class="logo">
                <a href="https://www.creative-tim.com" class="simple-text logo-mini">
                    <div class="logo-image-small">
                        <img src="<?php echo $avatar; ?>">
                    </div>
                </a>
                <a href="https://www.creative-tim.com" class="simple-text logo-normal">
                    <?php echo $fullname; ?>
                </a>
            </div>
            <div class="sidebar-wrapper">
                <ul class="nav">
                    <?php
                    if ($role == 'admin') {
                    ?>
                        <li>
                            <a href="./tables.php">
                                <i class="nc-icon nc-tile-56"></i>
                                <p>Quản lý sản phẩm</p>
                            </a>
                        </li>
                    <?php
                    } else {
                    ?>
                        <li>
                            <a href="./tables.php">
                                <i class="nc-icon nc-tile-56"></i>
                                <p>Danh sách sản phẩm</p>
                            </a>
                        </li>
                    <?php
                    }
                    ?>
                    <li class="active ">
                        <a href="./product.php?id=<?php echo $productId; ?>">
                            <i class="nc-icon nc-single-02"></i>
                            <p>Chi tiết sản phẩm</p>
                        </a>
                    </li>
                    <li>
                        <a href="./user.php?id=<?php echo $id; ?>">
                            <i class="nc-icon nc-single-02"></i>
                            <p>Trang cá nhân</p>
                        </a>
                    </li>
                    <li>
                        <a href="./logout.php" style="display: flex;">
                            <i class="fas fa-sign-out-alt"></i>
                            <p>Đăng xuất</p>
                        </a>
                    </li>
                </ul>
            </div>
        </div>
        <div class="main-panel wrapper">
            <div class="content">
                <div class="row" style="margin-left: 30px;">
                    <form action="<?php echo ($_SERVER["SCRIPT_NAME"]) . '?id=' . $productId; ?>" method="POST" enctype="multipart/form-data">
                        <textarea name="valueProduct" rows="20" cols="150"><?php echo json_encode($product['value']); ?></textarea>
                        <input type="submit" name="form" style="background-color: #007bff;color: #fff;padding: 10px 20px;border: none;border-radius: 20px;cursor: pointer;margin-top: 20px;transition: background-color 0.3s;" value="Lưu thông tin"></input>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src=" ./assets/js/core/jquery.min.js"></script>
    <script src="./assets/js/core/popper.min.js"></script>
    <script src="./assets/js/core/bootstrap.min.js"></script>
    <script src="./assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
    <!--  Google Maps Plugin    -->
    <script src="https://maps.googleapis.com/maps/api/js?key=YOUR_KEY_HERE"></script>
    <!-- Chart JS -->
    <script src="./assets/js/plugins/chartjs.min.js"></script>
    <!--  Notifications Plugin    -->
    <script src="./assets/js/plugins/bootstrap-notify.js"></script>
    <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
    <script src="./assets/js/paper-dashboard.min.js?v=2.0.1" type="text/javascript"></script>
    <!-- Paper Dashboard DEMO methods, don't include it in your project! -->
    <script src="./assets/demo/demo.js"></script>
</body>

</html>