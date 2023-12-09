<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include("encrypt_helper.php");
        include("db_helper.php");
        $sql = "SELECT * FROM product";

        $data = [];
        $result = [
            "code" => 400,
            "data" => []
        ];
        $result = excuteSQL($sql);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                $product = [
                    "id" => $row['id'],
                    "name" => $row['name_'],
                    "des" => $row['des_'],
                    "link_image" => $row['link_image'],
                    "price" => $row['price'],
                ];
                $data[]=$product;
            }
            $result = [
                "code" => 200,
                "data" => $data
            ];
        } 
        $data = json_decode(file_get_contents("php://input"), true);
        $dataRequest = decrypt($data,$serverPriKey);
        $dataResponse = encrypt(json_encode($result),$dataRequest);
        $jsonResult = json_encode($dataResponse);

        // Thiết lập tiêu đề HTTP để báo cho trình duyệt biết rằng đây là JSON
        header('Content-Type: application/json');

        // Xuất kết quả JSON
        echo $jsonResult;
        
    }

    
?>