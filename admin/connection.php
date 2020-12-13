<?php
$connect = new mysqli("localhost","root", "", "e_comm");
if(!$connect){
    echo "<p color='red'>Connection Error Occured</p>";
    die();
}
?>