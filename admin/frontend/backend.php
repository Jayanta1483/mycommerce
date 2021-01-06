<?php
require "connection.php";
//require "functions.php";

if (isset($_POST['op']) && $_POST['op'] == "insert") {

    $err_type = "";
    $err_msg = "";

    if (empty($_POST['fname']) || empty($_POST['lname']) || empty($_POST['email']) || empty($_POST['mobile']) || empty($_POST['logid']) || empty($_POST['pwd']) || empty($_POST['adr'])) {
        $err_type = "emp";
        $err_msg = "All the firlds are required to be filled";
    } else {
        $fname = mysqli_real_escape_string($connect, $_POST['fname']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $err_type = "fn";
            $err_msg = "Only Letters and White space are allowed";
        }
        $lname = mysqli_real_escape_string($connect, $_POST['lname']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $err_type = "ln";
            $err_msg = "Only Letters and White space are allowed";
        }

        $email = mysqli_real_escape_string($connect, $_POST['email']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err_type = "em";
            $err_msg = "Your Email Id is not valid";
        } else {
            $select = "select * from customers where cust_email = ?";
            $stmt = $connect->prepare($select);
            $stmt->bind_param("s", $email);
            $stmt->execute();
            $stmt->store_result();
            if ($stmt->num_rows > 0) {
                $err_type = "em";
                $err_msg = "You have already registered";
            }
        }

        $mobile = mysqli_real_escape_string($connect, $_POST['mobile']);
        if (!preg_match("/^[6-9]\d{9}$/", $mobile)) {
            $err_type = "mb";
            $err_msg = "This is not a valid mobile number";
        }
        $user_id = mysqli_real_escape_string($connect, $_POST['logid']);

        $pwd = mysqli_real_escape_string($connect, $_POST['pwd']);
        if (strlen($pwd) < 6) {
            $err_type = "pw";
            $err_msg = "Minimum 6 characters";
        } else {
            $pwd = password_hash($pwd, PASSWORD_BCRYPT);
        }

        $address = mysqli_real_escape_string($connect, $_POST['adr']);
    }








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

            move_uploaded_file($temp_file, "uploads/" . $file_name);
        }
    } else {
        $file_name = "customer_avatar.jpg";
    }

    if ($err_type == "") {

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
                echo json_encode(htmlspecialchars($fn));
            }
        }
    } else {
        $error = array("type" => $err_type, "msg" => $err_msg);
        echo json_encode($error);
    }
}



// FOR USER ID VERIFICATION


if (isset($_POST['ui'])) {

    $ui = mysqli_real_escape_string($connect, $_POST['ui']);
    $select = "select * from customers where user_id = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param("s", $ui);
    $stmt->execute();
    $stmt->store_result();
    if (!preg_match("/^(?=.*[a-z])[a-z0-9]{4,8}$/i", $ui)) {
        echo "<span style='color:red;'>This is not a valid user id</span>";
    } else {
        if (!$stmt->num_rows > 0) {
            "<span style='color:green;'>User Id is Available!!</span>";
        } else {
            echo "<span style='color:red;'>User Id is Not Available!!</span>";
        }
    }
}

//FOR LOGIN VERIFICATION
if (isset($_POST['log']) && !empty($_POST['log'])) {

    $id = mysqli_real_escape_string($connect, $_POST['log']);
    $password = mysqli_real_escape_string($connect, $_POST['lpw']);
    $select = "select cust_fname, password from customers where user_id = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->bind_result($fn, $pass);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        while ($stmt->fetch()) {
            if (!password_verify($password, $pass)) {
                echo "pw";
            } else {
                echo htmlspecialchars($fn);
            }
        }
    } else {
        echo "id";
    }
}


















$connect->close();
?>