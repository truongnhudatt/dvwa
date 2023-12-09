<?php 
function log_query($content){
    $file = 'query_log.txt';
    // Ghi nội dung vào tệp tin
    $content= $content."\n";
    if (file_put_contents($file, $content,FILE_APPEND) !== false) {
        $content ="";
    }
}
?>