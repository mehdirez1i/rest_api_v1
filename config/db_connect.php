<?php 
include './db_info.php';
$connection = mysqli_connect($host, $username, $password, $db_name);
if(mysqli_connect_errno()){
    echo 'connention faild'. mysqli_connect_error();
}
?>