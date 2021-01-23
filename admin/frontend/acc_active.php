<?php
require "connection.php";

if (isset($_REQUEST['t'])) {
    $token = mysqli_real_escape_string($connect, $_REQUEST['t']);
    $status = "active";
    $update = "UPDATE `customers` SET `status` = ? WHERE `token` = ?";
    if ($stmt = $connect->prepare($update)) {
        $stmt->bind_param("ss", $status, $token);
        $stmt->execute();
        echo "<h3 style='color:green;text-align:center;'>Your Account has been activated...You can now login to your account.</h3>";
    }
}
