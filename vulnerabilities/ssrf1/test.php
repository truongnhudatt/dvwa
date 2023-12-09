<?php 
    $url ="http://localhost:8081/lab/ssrf1/data.php?idProduct=2&idCity=1";
    $ch = curl_init();

    // Cấu hình cURL
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // Chuyển phản hồi về thay vì in ra
    // Cấu hình thêm các tùy chọn khác nếu cần

    // Thực hiện yêu cầu cURL và lấy phản hồi
    $response = curl_exec($ch);

    // Đóng kết nối cURL
    curl_close($ch);

    header('Content-Type: application/json');
    echo json_encode($response);
?>