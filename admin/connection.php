<?php
$connect = mysqli_connect("localhost","root", "", "e_comm");
if(!$connect){
    echo "<p color='red'>Some Error Occured</p>";
    die();
}
?>