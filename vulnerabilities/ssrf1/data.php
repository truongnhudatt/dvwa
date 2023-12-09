<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        $idProduct = isset($_GET['idProduct']) ? $_GET['idProduct'] : null;
        $idCity = isset($_GET['idCity']) ? $_GET['idCity'] : null;
        $message = null;
        if ($idProduct !== null && $idCity !== null) {
            $sql = "SELECT *
            FROM city_product
            WHERE id_city = ".$idCity." AND id_product = ".$idProduct.";";
            include("db_helper.php");
            $result = excuteSQL($sql);
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    $message = $row['amount'];
                    
                }
            }
        } else {
            $message = "Còn thiếu thông tin.";
        }

        $response = [
            "code" => "200",
            "message" => $message
        ];
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>