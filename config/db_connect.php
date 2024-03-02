<?php 
$connection = mysqli_connect('localhost', 'mahdi', '<PASSWORD>','test_db');
if(mysqli_connect_errno()){
    echo 'connention faild'. mysqli_connect_error();
}
?>