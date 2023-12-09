<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div class="container">
        <div>
            <div class="imgcontainer">
              <img src="https://www.w3schools.com/howto/img_avatar2.png" alt="Avatar" class="avatar">
            </div>
          
            <div class="container">
              <label for="uname"><b>Username</b></label>
              <input class="username" type="text" placeholder="Enter Username" name="uname" required>
          
              <label for="psw"><b>Password</b></label>
              <input class="password" type="password" placeholder="Enter Password" name="psw" required>
          
              <button type="submit" onclick="login()">Login</button>
            </div>
        
        </div> 
    </div>
</body>
<script>
function login(){
    var username = document.querySelector('.username');
    var password = document.querySelector('.password');
    const loginData = {
        username: username.value,
        password: password.value
    };
    const loginUrl = `http://<?php echo $_SERVER['HTTP_HOST']; ?>/DVWA/vulnerabilities/cors/login.php`;
    fetch(loginUrl, {
    method: 'POST',
    headers: {
        'Content-Type': 'application/json'
    },
    body: JSON.stringify(loginData)
    })
    .then(response => response.json())
    .then(data => {
        // Xử lý phản hồi từ backend
        if (data.success) {

            console.log('Login successful!');
            console.log('Session ID:', data.session_id);
            window.location.href = "http://<?php echo $_SERVER['HTTP_HOST']; ?>/DVWA/vulnerabilities/cors/info.php";
        
        } else {
        console.error('Login failed:', data.error);
       
        }
    })
    .catch(error => {
        console.error('Error:', error);
        // Xử lý lỗi kết nối hoặc lỗi khác
    });
}
</script>
</html>