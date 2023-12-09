<?php 
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $json_data = file_get_contents("php://input");
        $data = json_decode($json_data);
        $url = $data->url;
        $ch = curl_init();

        // Cấu hình cURL
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Chuyển phản hồi về thay vì in ra
        // Cấu hình thêm các tùy chọn khác nếu cần

        // Thực hiện yêu cầu cURL và lấy phản hồi
        $res = curl_exec($ch);
        $result = json_decode($res);

        // Đóng kết nối cURL
        curl_close($ch);
        $response = [
            "code" => 400,
            "message" => "Bad request."
        ];
        if($result->code == 200)
        {
            $response = [
                "code" => 200,
                "message" => $result->message
            ];
        }
        header('Content-Type: application/json');
        echo json_encode($response);
    }
?>