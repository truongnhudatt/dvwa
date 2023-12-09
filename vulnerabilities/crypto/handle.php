<?php
$serverPriKey = "-----BEGIN RSA PRIVATE KEY-----
MIIEpAIBAAKCAQEApUQ0SPFCMYu/IrX28d7nhrV7rqL1sWl83NoyZYH9iYdcQOss
JiQkMYNKxcsfDF2gKA6rrIscDhGjt/y5SI5iOv8LRzT6HgQvcdLJ7dZ0HBvhma3C
eqixQ6sBzfxte+Z8iVyzXOWymJYDs8wz6Vljg4ValuvW7bdZBOWmnd2aAAPpnTYP
YquIg6wz3uGnqHZgiBZ5IAcI0L1IetoKaA7oIWKTqigtZ0qmHP5ShpfHK14cNtg6
SYLuIJoRzhhNer2zjDNcjPl/I3syYuPGrJTvVLWI1vdFYXLM/lEQkEyS8FnH7OyU
WuRSuJZDJRG+4Jb8e9dzfyXH2y24Nhl7gPFa8QIDAQABAoIBACBqiiHjlqL+wPkn
PX6QRRQObWniA3Su1wO/1cJE1sz+zLjcGA8MKEBA+y3kS10C0UsCI6jGqXRV/+mz
C8nASeK+C4GGUegI1KCMIrkAx0oLKvtYkoy6IXj/Ji237Wav3S4ZTYIzeM5GoIfI
DkefVa5ivhPbww7iF3cnL4EICjClwoXDHKXtn7CBBAZ+olmMHdmBeKwG356s4jc4
rcBB43s0ufpUi5MllinAV6oECW9/WPgpFDvraeEL0NoiWfHk5j6yuFXkwMRr/K+Q
tAF8M37j4vgsH9JIR1rn9Zq/GYQisdfHFeJivhU1sQsanX27NjglwQzYqwqrujUX
TujltfUCgYEA6G2TPFGVt+KVGHKiDPmygN0OwUhjs1yD3t0+/mECE77eDJEpXW4D
mtJMpMLXeBy6Qg+i0yFNU1JBjxUOjepOFD34SV4HaVhj5lZzkci1YDlSH8vpbF5u
seDYPZ8cDpY7LdGFPJNM2PlEwZLhBizjuJ0dPhaUrf1Fv7usxc2ZpW0CgYEAtgbx
QXvQMgUnNSmcPHJ2tz5ZPao7OKBXKt82TvUhBLxy6M79zv/C9TgsVLGHtj16olY0
5GqT2wg5ammsaTQk1uGEN2a0kzQSZp5voK4orTiqWsxFUMlNB/+J6SNZ0zcKVYfq
fRsG+/dfhWiiiGREFi7qOCUOYyvm8orQcXLJTRUCgYEA5OGqwRZyQi+9tOKF1BM8
BgwqEIoRrDnpnljvRJ8Q5ZLqpSN5wYipwhdf5Ev+1Ugs3wr4w8Kim+9/ocARogze
sK5Jxy3yTHn/fn8ZtbEZc1VfGvK5vb7McRxCtYPupCqqwjb2Zq2DWpM1cw4JzAP+
h/koJ9EivqePvPy6adtKd40CgYEArY2U/ZClguuy5FdWJbQlSLXjtI3YhTcrpS7J
wyKpZrCfByZEjNcC9XennODfunyHrrxvFdIgQ1hmFfXHc09KSK8gtwnv5eJiIQGz
AQrMscwzcPsOo+Yq0hNtVKJmBKKX8dDzXHEmiZrksnh/b3faCySUIRAD1b6IJn0A
HQsKr7kCgYA6KmQqr0dbPCgOv3hUoerYObmxGT43ouUXLUaBFON5/uWccKbtDq9T
XZh/Y8ingQuHM3YFCzrwbILMIbhmYWerzngM8UJXDzuySdIaQMKu8AyCWsx/Cyq1
jz7x9fZrzVLRQPo6ir8HksqOgJH0a2mZCqVcMysJH6SukrJjX0WAnw==
-----END RSA PRIVATE KEY-----";
// Kiểm tra xem yêu cầu là phương thức POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    header('Content-Type: application/json');
    // Lấy dữ liệu từ yêu cầu POST
    $data = json_decode(file_get_contents("php://input"), true);
    // Kiểm tra xem dữ liệu có hợp lệ không
    function decrypt_aes_ctr($cipherText, $key, $nonce) {
        $cipherMethod = 'aes-256-ctr';
    
        $decrypted = openssl_decrypt($cipherText, $cipherMethod, $key, OPENSSL_RAW_DATA, $nonce);
    
        return $decrypted;
    }
    function encrypt_aes_ctr($plainText, $key, $nonce) {
        $cipherMethod = 'aes-256-ctr';
    
        $encrypted = openssl_encrypt($plainText, $cipherMethod, $key, OPENSSL_RAW_DATA, $nonce);
    
        return $encrypted;
    }
    
    function encrypt($dataResponse,$dataRequest){
        $key = openssl_random_pseudo_bytes(32);
        $iv = openssl_random_pseudo_bytes(16);

        $clientPubKey = json_decode($dataRequest)->clientPubKey;
        $s_output_data = encrypt_aes_ctr($dataResponse,$key,$iv);
        openssl_public_encrypt(base64_encode($key), $k1, $clientPubKey);

        $combinedData = $iv . $s_output_data;
        return [
            'k' => base64_encode($k1),
            'd' =>  base64_encode($combinedData),       
        ];
    }
    function decrypt($data,$serverPriKey){
        $k = $data['k'];
        $d = $data['d'];
        $dataToDecrypt = base64_decode($k);
        
        openssl_private_decrypt($dataToDecrypt, $t, $serverPriKey);
        
        $t = base64_decode($t);
        $d = base64_decode($d);
        $i = substr($d, 0, 16);
        $dataEncrypt = substr($d, 16);
        $plaintext = decrypt_aes_ctr($dataEncrypt, $t, $i);

        return $plaintext;
    }
    if ($data) {
        include("variable.php");



        $plaintext =  decrypt($data,$serverPriKey);
        // Encrypt
        $datas = [];
        try {
            $pdo = new PDO("mysql:host=$db_server;dbname=$db_name", $db_username, $db_password);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            $userInput = json_decode($plaintext)->data;
            $userInput = "%".$userInput."%";
            $stmt = $pdo->prepare("SELECT * FROM product WHERE name_ LIKE :searchTerm");
            $stmt->bindParam(':searchTerm', $userInput, PDO::PARAM_STR);
            
            $stmt->execute();
            // Lấy kết quả
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            // Hiển thị kết quả
            foreach ($results as $row) {
                $product = [
                            "id" => $row['id'],
                            "name" => $row['name_'],
                            "des" => $row['des_'],
                            "link_image" => $row['link_image'],
                            "price" => $row['price'],
                        ];
                $datas[]=$product;
            }
        } catch (PDOException $e) {
            echo "Lỗi kết nối cơ sở dữ liệu: " . $e->getMessage();
        }
        $dataResponse = 
        [   
            'message' => $datas,
            'code' => '200'
        ];
        $pattern = '/<\s*(script|iframe|object|embed|form|frame|input|textarea|button|svg|applet|meta|base|xml|blink|link|style|img|on\w+)\s*[^>]*>/i';
        if(preg_match($pattern, json_decode($plaintext)->data)){
            $dataResponse = 
            [   
                'message' => "Bạn đã nhập nội dung chứa kí tự không hợp lệ.",
                'code' => '400'
            ];
        }
        $dataResponse = json_encode($dataResponse);
        $res = encrypt($dataResponse,$plaintext);
        echo json_encode($res);

        
    } else {
        // Trả về lỗi nếu dữ liệu không hợp lệ
        http_response_code(400);
        echo json_encode(['error' => 'Dữ liệu không hợp lệ']);
    }
} else {
    // Trả về lỗi nếu yêu cầu không phải là POST
    http_response_code(405);
    echo json_encode(['error' => 'Phương thức không hợp lệ']);
}
