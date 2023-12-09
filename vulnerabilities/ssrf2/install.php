<?php

    function passwordHash($password){
        return $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    }
    include('variable.php');
    $link = new mysqli($db_server, $db_username, $db_password);
    if ($link->connect_error) {
        die("Error fail: " . $link->connect_error);
    }
    $result = $link->query("SHOW DATABASES LIKE '$db_name'");
    // Kiem tra database ton tai
    if($result->num_rows == 0){
        // echo "Khởi tạo database thành công.";
        // Tao database
        $sql = "CREATE DATABASE IF NOT EXISTS ".$db_name;
        $recordset = $link->query($sql);
        
        if(!$recordset)
        {

            die("Error: " . $link->error);

        }

        // Chon database
        mysqli_select_db($link,$db_name);

        /////////////////////////// KHỞI TẠO DỮ LIỆU DATABASE TỪ ĐÂY.///////////////////////////////////////
        
        // Tao bang product
        $sql = "CREATE TABLE IF NOT EXISTS product (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255),
            des TEXT,
            link_image VARCHAR(255),
            price INT,
            PRIMARY KEY (id)
        );";

        $recordset = $link->query($sql);

        if(!$recordset)
        {

            die("Error: " . $link->error);
        }
        //  Chèn dữ liệu bảng product
        $sql = "INSERT INTO product (name, des, link_image, price) VALUES
        ('Awesome Plastic Gloves', 'Neque eveniet impedit accusantium laborum laudantium accusantium deleniti ducimus.\nRatione ea et accusantium doloribus tempore eaque eius eaque beatae.\nAccusamus aspernatur voluptatibus non.\nCumque architecto quam autem.', 'image11.jpg', 100),
        ('Bespoke Plastic Chair', 'Dignissimos dignissimos repudiandae recusandae repellat error atque at. Quae deserunt quidem a voluptas facere. Quasi atque tempore accusantium atque perspiciatis. Fugit culpa voluptas maxime corrupti corporis minus. Inventore aspernatur esse.', 'image2.jpg', 150),
        ('Handmade Cotton Car', 'Eum libero alias facere cupiditate accusamus illo nihil consequuntur minima. Sed voluptas reprehenderit ad fugit iste sunt ea sit aliquam. Pariatur maxime nulla fugiat eum libero. Voluptate enim placeat omnis fuga. Fugit nesciunt corporis odio esse ducimus accusantium. Dolore consectetur molestias quas nulla veniam sint.', 'image3.jpg', 75),
        ('Elegant Concrete Gloves', 'Quae similique quisquam doloribus. Cum repellendus possimus amet quasi at alias iure tempora in. Quasi exercitationem ipsa magnam. Consequuntur maxime suscipit. Id ex officiis perferendis sed aperiam veritatis magnam.', 'image4.jpg', 120),
        ('Oriental Plastic Car', 'Ex cupiditate cum. Veritatis accusantium molestiae atque. Voluptate sapiente id suscipit eius tenetur dicta culpa. Provident laborum explicabo exercitationem placeat illum iste recusandae. Quis praesentium laborum vel quam totam. Doloremque iure corrupti aliquam magni.\nEarum quia voluptatem. Unde suscipit soluta omnis laudantium ea quos maxime tempora adipisci. Nostrum magnam similique consequatur dolorum molestiae dolores nam eos. Modi dolorum sint aliquid debitis iusto nam harum. Doloribus explicabo vitae doloribus rerum enim eum beatae maiores. Explicabo aperiam quia facilis nihil illo voluptates error dicta.\nNesciunt tenetur sapiente corporis alias natus tempore ipsum error. Iusto repellendus dolores pariatur earum alias hic corrupti. Veritatis nobis veritatis quod aliquam tempora. Consectetur maiores dignissimos esse eum labore. Voluptatibus repudiandae eum praesentium cupiditate. Blanditiis alias aliquam recusandae odio.', 'image5.jpg', 90),
        ('Luxurious Granite Sausages', 'Aperiam accusantium excepturi eveniet. Quas delectus enim quia aut corrupti dolorum at voluptate. Dolore dolorem impedit assumenda odit aliquam consequatur eligendi hic.\nNatus cum tempore ipsam illo saepe commodi. Atque vitae id iste placeat fugiat possimus deserunt minima praesentium. Aperiam sunt possimus perferendis ea dolorum. Reprehenderit aspernatur laboriosam quo ipsum atque ad ut sit excepturi.\nNostrum fugiat nulla nemo delectus iusto molestias labore sunt officia. Quasi vero fuga consectetur expedita. Alias occaecati veniam natus repellat.', 'image6.jpg', 200),
        ('Rustic Rubber Shirt', 'Quo quam quidem tempore quo atque. Iste error nostrum deserunt perspiciatis officia et asperiores unde doloremque. Beatae natus dolorem similique facere.\nBeatae eius quaerat possimus officia vero sapiente incidunt porro. Repellat architecto quia laboriosam impedit eaque sit reprehenderit consequuntur qui. Provident voluptatum natus magni eum velit. Pariatur voluptatibus veniam consequuntur quis placeat saepe ipsam. Provident similique quae mollitia asperiores sit debitis impedit placeat corrupti. Consequatur sed odio architecto.\nIpsam quasi blanditiis amet aut voluptates. Ipsam modi accusamus sint. Explicabo officiis aliquam assumenda.', 'image7.jpg', 50),
        ('Gorgeous Steel Soa', 'Repellendus alias molestias veritatis ducimus exercitationem necessitatibus. Sint rerum libero deserunt perferendis quam ullam placeat. Quo eos temporibus. Voluptatibus odio debitis voluptate molestias culpa error perferendis consequuntur.', 'image8.jpg', 180),
        ('Handcrafted Bronze Chips', 'Neque eveniet impedit accusantium laborum laudantium accusantium deleniti ducimus.\nRatione ea et accusantium doloribus tempore eaque eius eaque beatae.\nAccusamus aspernatur voluptatibus non.\nCumque architecto quam autem.', 'image9.jpg', 110),
        ('Electronic Steel Table', 'Tempora iure molestias consequatur odit autem reprehenderit suscipit iure rerum. Ipsa adipisci quidem explicabo voluptate voluptatibus. Sapiente voluptate quaerat veniam.', 'image10.jpg', 130);";
        $recordset = $link->query($sql);
        if(!$recordset)
        {

            die("Error: " . $link->error);

        }

        //  Init table
        $sql = "CREATE TABLE user (
            id INT AUTO_INCREMENT PRIMARY KEY,
            fullname VARCHAR(255) NOT NULL,
            email VARCHAR(255) NOT NULL UNIQUE,
            phone VARCHAR(20),
            password VARCHAR(255) NOT NULL,
            username VARCHAR(50) NOT NULL UNIQUE
        );
        ";

        $recordset = $link->query($sql);     
        if(!$recordset)
        {
            die("Error: " . $link->error);
        }
        $sql = "INSERT INTO user (fullname, email, phone, password, username) VALUES
        ('PTIT', 'ptit@example.com', '123456789', '" . passwordHash('ptit@123') . "', 'ptit'),
        ('Người dùng 2', 'user2@example.com', '987654321', '" . passwordHash('mật khẩu 2') . "', 'username2'),
        ('Người dùng 3', 'user3@example.com', NULL, '" . passwordHash('mật khẩu 3') . "', 'username3'),
        ('Người dùng 4', 'user4@example.com', '555555555', '" . passwordHash('mật khẩu 4') . "', 'username4'),
        ('Người dùng 5', 'user5@example.com', '888888888', '" . passwordHash('mật khẩu 5') . "', 'username5')";
        $recordset = $link->query($sql);     
        if(!$recordset)
        {
            die("Error: " . $link->error);
        }
        $sql = "CREATE TABLE IF NOT EXISTS city (
            id INT AUTO_INCREMENT NOT NULL,
            name VARCHAR(255),
            des TEXT,
            PRIMARY KEY (id)
        );
        ";
        $recordset = $link->query($sql);     
        if(!$recordset)
        {
            die("Error: " . $link->error);
        }
        $sql = "INSERT INTO city (name, des) VALUES
        ('Thái Bình', 'Thành phố Thái Bình'),
        ('Hà Nội', 'Thủ đô Hà Nội'),
        ('Nam Định', 'Thành phố Nam Định');
        ";
        $recordset = $link->query($sql);     
        if(!$recordset)
        {
            die("Error: " . $link->error);
        }
        $sql = "CREATE TABLE city_product (
            id INT AUTO_INCREMENT PRIMARY KEY,
            id_city INT,
            id_product INT,
            amount INT
        );";
        $recordset = $link->query($sql);     
        if(!$recordset)
        {
            die("Error: " . $link->error);
        }
        $sql = "INSERT INTO city_product (id_city, id_product, amount) VALUES
        (1, 1, 520),
        (2, 1, 150),
        (3, 1, 530),
        (1, 2, 0),
        (2, 2, 5),
        (3, 2, 5),
        (1, 3, 12),
        (2, 3, 123),
        (3, 3, 14),
        (1, 4, 15),
        (2, 4, 17),
        (3, 4, 18),
        (1, 5, 23),
        (2, 5, 11),
        (3, 5, 33),
        (1, 6, 111),
        (2, 6, 43),
        (3, 6, 33),
        (1, 7, 123),
        (2, 7, 111),
        (3, 7, 222),
        (1, 8, 90),
        (2, 8, 12),
        (3, 8, 123),
        (1, 9, 111),
        (2, 9, 52),
        (3, 9, 55),
        (1, 10, 78),
        (2, 10, 90),
        (3, 10, 510);
        ";
        $recordset = $link->query($sql);     
        if(!$recordset)
        {
            die("Error: " . $link->error);
        }
    }
    else {
        // echo "Database đã tồn tại.";
    }
?>