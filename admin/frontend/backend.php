<?php
require "connection.php";

if($_POST['op'] == 'insert'){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $user_id = $_POST['logid'];
    $pwd = $_POST['pwd'];
    $address = $_POST['adr'];

    
   
}else{
    echo "error";
}
?>