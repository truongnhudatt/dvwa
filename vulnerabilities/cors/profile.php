
<?php
if(isset($_SERVER['HTTP_ORIGIN'])){
    $origin = $_SERVER['HTTP_ORIGIN'];
    header('Access-Control-Allow-Origin:'.$origin);

}
session_set_cookie_params(['samesite' => 'None']);
session_start();
// header('Access-Control-Allow-Origin: http://127.0.0.1:5500');
header('Access-Control-Allow-Credentials:true');
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type");

if (isset($_SESSION['username'])) {
    http_response_code(200);
    header('Content-Type: application/json; charset=utf-8');
    $username = $_SESSION['username'];
    echo json_encode(array(
        'success' => 'true',
        'username'=> $username, 
        'email'=> 'ptit@example.com',
        'session_id' => session_id(),
        'fullname'=> 'PTIT',
        'position'=>'Pentest',
        'company' => 'PTIT',
        'url_img' => 'https://www.w3schools.com/w3images/team2.jpg',
    
    ));
}
else {
    http_response_code(400);
    echo json_encode(array('error' => 'true'));
    exit();
}
session_write_close();
?>