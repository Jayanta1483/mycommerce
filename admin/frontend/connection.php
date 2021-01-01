<?php
$server = "localhost";
$user = "root";
$password = "";
$db = "e_comm";

$connect = new mysqli($server, $user, $password, $db);
if($connect->connect_error){
    echo "<h3 style='color:red;'>Connection Error Occured...Please Check Connection..!!</div>";
}

date_default_timezone_set("Asia/Kolkata");

?>