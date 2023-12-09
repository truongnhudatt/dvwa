<?php
session_start();
include("./variable.php");

if (!isset($_SESSION["loggedin"])) {
  header("Location: index.php");
  exit;
}

$id = $_SESSION["id"];
$role = $_SESSION["role"];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
  $newUserId = $_SESSION['newUserId'];
  $newFullname = $_POST["fullname"];
  $newEmail = $_POST["email"];
  $newAddress = $_POST["address"];
  $newPhone = $_POST["phone"];
  if ($_FILES['file']['error'] == 4) {
  } else {
    if ($_FILES['file']['name'] != '') {
      $avatar = $_FILES['file']['name'];
    }
  }

  $db = new mysqli($db_server, $db_username, $db_password, $db_name);

  if ($db->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
  }

  $query = "UPDATE user SET fullname = '$newFullname', email = '$newEmail', address = '$newAddress', phone_number = '$newPhone', avatar = './assets/img/$avatar' WHERE id = $newUserId";
  if ($_FILES['file']['name'] != '') {
    move_uploaded_file($_FILES["file"]["tmp_name"], "./assets/img/" . $_FILES["file"]["name"]);
  }

  if ($db->query($query) === TRUE) {
    echo '<script>alert("Cập nhật thành công");</script>';
  } else {
    echo "Lỗi khi cập nhật: " . $db->error;
  }
  $db->close();
}

if (isset($_GET["id"])) {
  $newUserId = $_GET["id"];
  $_SESSION['newUserId'] = $_GET["id"];
  $_SESSION['id'] = $_GET["id"];
  $db = new mysqli($db_server, $db_username, $db_password, $db_name);

  if ($db->connect_error) {
    die("Kết nối đến cơ sở dữ liệu thất bại: " . $db->connect_error);
  }
  $query = "SELECT * FROM user WHERE id = $newUserId";
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
if (isset($_GET['returnUrl'])) {
  $returnUrl = $_GET['returnUrl'];
}
if (isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true && isset($_SESSION["username"]) && isset($_GET['returnUrl'])) {
  echo "<script>window.location.href='$returnUrl';</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <title>
    Trang cá nhân
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <link href="https://maxcdn.bootstrapcdn.com/font-awesome/latest/css/font-awesome.min.css" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
  <!-- CSS Files -->
  <link href="./assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="./assets/css/paper-dashboard.css?v=2.0.1" rel="stylesheet" />
  <!-- CSS Just for demo purpose, don't include it in your project -->
  <link href="./assets/demo/demo.css" rel="stylesheet" />
  <link rel="stylesheet" type="text/css" href="profile.css">
</head>

<body class="">
  <div>
    <div class="sidebar" data-color="white" data-active-color="danger">
      <div class="logo">
        <a class="simple-text logo-mini">
          <div class="logo-image-small">
            <img src="<?php echo $avatar; ?>">
          </div>
        </a>
        <a class="simple-text logo-normal">
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
            <a href="./user.php?id=<?php echo ($id); ?>">
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
    <div class="profile-container" style="margin-top:50px; margin-left: 350px;">
      <div class="profile-container-col">
        <h1>Thông tin cá nhân</h1>
        <form action="<?php echo ($_SERVER["SCRIPT_NAME"]) . '?id=' . $id; ?>" method="POST" enctype="multipart/form-data">
          <label for="fullname">Họ và tên:</label>
          <input type="text" id="fullname" name="fullname" value="<?php echo ($fullname); ?>" required>

          <label for="email">Địa chỉ email:</label>
          <input type="email" id="email" name="email" value="<?php echo ($email); ?>" required>

          <label for="phone">Số điện thoại:</label>
          <input type="text" id="phone" name="phone" value="<?php echo ($phone); ?>" required>

          <label for="address">Địa chỉ:</label>
          <input type="text" id="address" name="address" value="<?php echo ($address); ?>" required>

          <label for="avatar">Ảnh đại diện:</label>
          <input type="file" id="avatar" name="file">
          <input type="hidden" name="MAX_FILE_SIZE" value="10">
          <input id="button_submit" type="submit" name="form" value="Lưu thông tin"></input>
        </form>
      </div>

      <div class="profile-container-col">
        <img id="image-preview" src="<?php echo $avatar; ?>" alt="Mô tả ảnh">
      </div>
    </div>
  </div>
  <script>
    const imageInput = document.getElementById('avatar');
    const imagePreview = document.getElementById('image-preview');
    imageInput.addEventListener('change', function() {
      const file = imageInput.files[0];

      if (file) {
        const reader = new FileReader();

        reader.onload = function(e) {
          imagePreview.src = e.target.result;
        };

        reader.readAsDataURL(file);
      } else {
        imagePreview.src = '';
      }
    });
  </script>
  <!--   Core JS Files   -->
  <script src="./assets/js/core/jquery.min.js"></script>
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