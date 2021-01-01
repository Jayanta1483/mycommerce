<?php
require "connection.php";

if (isset($_POST['op']) && $_POST['op'] == "insert") {
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $user_id = $_POST['logid'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
    $address = $_POST['adr'];

    if (isset($_FILES['file']) && $_FILES['file'] !== "") {
        $photo = $_FILES['file'];
        $file = $photo['name'];
        $file = str_replace(' ', '', $file);
        $file_name = pathinfo($file, PATHINFO_FILENAME);
        $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
        $file_name = $file_name . '_' . date('d-m-Y h-m-sa') . '.' . $file_ext;
        $file_size = $photo['size'];
        $temp_file = $photo['tmp_name'];
        $file_info = @getimagesize($temp_file);
        $mime_file = $file_info['mime'];
        $ext_arr = array('jpg', 'jpeg', 'png', 'webp');
        $mime_arr = array('image/jpeg', 'image/png', 'image/webp');
        

        if ($file_size > 2000000) {
            $err_type = "image";
            $err_msg = "File Size is Greater than 2mb";
        } else if (!in_array($file_ext, $ext_arr)) {
            $err_type = "image";
            $err_msg = "This File Extension is Not Allowed";
        } else if (!in_array($mime_file, $mime_arr)) {
            $err_type = "image";
            $err_msg = "This Mime is Not Allowed";
        } else {
            $err_type = "";
            move_uploaded_file($temp_file, "uploads/".$file_name);
        }
    } else {
        $file_name = "customer_avatar.jpg";
    }

    if ($photo == "" || $err_type == "") {

        $insert = "INSERT INTO `customers`( `cust_fname`, `cust_lname`, `cust_address`, `cust_email`, `cust_mobile`, `user_id`, `password`, `photo`) VALUES (?,?,?,?,?,?,?,?)";
        $stmt = $connect->prepare($insert);
        $stmt->bind_param("ssssisss", $fname, $lname, $address, $email, $mobile, $user_id, $pwd, $file_name);
        ($stmt->execute()) ? $execute = true : $execute = false;

        if ($execute) {
            $last_id = $connect->insert_id;
            $select = "select cust_fname from customers where cust_id = ?";
            $sel_stmt = $connect->prepare($select);
            $sel_stmt->bind_param("i", $last_id);
            $sel_stmt->execute();
            $sel_stmt->bind_result($fn);
            while ($sel_stmt->fetch()) {
                echo json_encode($fn);
            }
        }
    } else {
        $error = array("type"=>$err_type, "msg"=>$err_msg);
        echo json_encode($error);
    }
} else {
    echo "error";
}
