<?php 
$connection = mysqli_connect('localhost', 'mahdi', '159875321MM','test_db');
if(mysqli_connect_errno()){
    echo 'connention faild'. mysqli_connect_error();
}
?>