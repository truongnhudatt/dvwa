<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link rel="stylesheet" href="profile-1.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Courier+Prime&family=Montserrat:wght@300&display=swap" rel="stylesheet">
</head>
<body>
    <div class="wrapper">
        <div class="container">
            <div class="profile">
                <div class="img">
                    <img src="avatar.jpg" class="url_img" alt="">
                </div>

                <div class="infomation">
                    <div class="wrap-content">
                        <div class="title">Họ tên</div>
                        <div class="content fullname"></div>
                    </div>

                    <div class="wrap-content">
                        <div class="title">Email</div>
                        <div class="content" class="email"></div>
                    </div>
                    <div class="wrap-content">
                        <div class="title">Đơn vị</div>
                        <div class="content company"></div>
                    </div>
                </div>
            </div>

            <div class="update-profile">
                <p class="heading">Cập nhật thông tin tài khoản</p>
                <div class="body-update">
                    <div class="items">
                        <label for="" class="label-item">Họ tên</label>
                        <div class="wrap-input">
                            <input type="text" class="input fullname_input">
                        </div>

                    </div>
                    <div class="items">
                        <label for="" class="label-item">Tài Khoản</label>
                        <div class="wrap-input">
                            <input type="text" class="input username_input">
                        </div>

                    </div>
                    <div class="items">
                        <label for="" class="label-item">Email</label>
                        <div class="wrap-input">
                            <input type="text" class="input email_input">
                        </div>

                    </div>
                    <div class="items">
                        <label for="" class="label-item">Mật Khẩu Cũ</label>
                        <div class="wrap-input">
                            <input type="text" class="input">
                        </div>

                    </div>
                    <div class="items">
                        <label for="" class="label-item">Mật Khẩu Mới</label>
                        <div class="wrap-input">
                            <input type="text" class="input">
                        </div>

                    </div>
                    <div class="items">
                        <label for="" class="label-item">Xác Nhận Mật Khẩu</label>
                        <div class="wrap-input">
                            <input type="text" class="input">
                        </div>

                    </div>

                    <div class="wrap-btn">
                        <button class="btn-submit">
                            Lưu thông tin
                        </button>
                        <button class="btn-submit" onclick="logout()">
                            Đăng xuất
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
<script>
    const apiUrl = 'http://<?php echo $_SERVER['HTTP_HOST'] ?>/DVWA/vulnerabilities/cors/profile.php'; 
    var fullnameElement = document.querySelector('.fullname');
    var inputFullname = document.querySelector('.fullname_input');
    var inputEmail = document.querySelector('.email_input');
    var inputUsername = document.querySelector('.username_input');
    var company = document.querySelector('.company');
    var img = document.querySelector('.url_img');

    fetch(apiUrl)
    .then(response => response.json())
    .then(data => {
        // Xử lý phản hồi từ backend
        if(data.error){
            window.location.href = "index.html";
        }
        else {
            fullnameElement.innerHTML = data.fullname;
            company.innerHTML = data.company;
            inputFullname.value = data.fullname;
            inputEmail.value = data.email;
            inputUsername.value = data.username;
            img.src = data.url_img;
            console.log("OK");
        }
        console.log(data);
    })
    .catch(error => {
        console.error('Error:', error);
    });
    function logout(){
        window.location.href= "http://localhost:8081/DVWA/vulnerabilities/cors/logout.php";
    }
</script>
</html>