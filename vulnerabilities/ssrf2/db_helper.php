<?php
function excuteSQL($sql){
    include("variable.php");
    $link = mysqli_connect($db_server, $db_username, $db_password,$db_name);
    if (!$link) {
        die("Error: " . mysqli_connect_error());
    }
    $result = mysqli_query($link, $sql);
    if (!$result) {
        die("Error: " . mysqli_error($link));
    }
    return $result;
}
?>