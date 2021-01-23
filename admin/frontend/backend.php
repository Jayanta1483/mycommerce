<?php
require "connection.php";
require "functions.php";

if (isset($_POST['csrf']) && isset($_POST['op']) && $_POST['op'] == "insert") {

    $err_type = "";
    $err_msg = "";

    if (!hash_equals($_SESSION['key'], $_POST['csrf'])) {
        $err_type = "tk";
        $err_msg = "Invalid Token!!";
    } else {

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
                $stmt->close();
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
    }
    if ($err_type == "") {
        $token = bin2hex(random_bytes(15));
        $status = "inactive";
        $insert = "INSERT INTO `customers`( `cust_fname`, `cust_lname`, `cust_address`, `cust_email`, `cust_mobile`, `user_id`, `password`, `photo`, `token`, `status`) VALUES (?,?,?,?,?,?,?,?,?,?)";
        $stmt = $connect->prepare($insert);
        $stmt->bind_param("ssssisssss", $fname, $lname, $address, $email, $mobile, $user_id, $pwd, $file_name,$token, $status);
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

                // FOR SENDING EMAIL TO NEWLY REGISTERED CUSTOMER

                $to = $email;
                $subject = "Registration Confirmation & Account activation";
                $message = "Congratulation " . htmlspecialchars($fname) . " !! You have Successfully Registered.Your user_id is :" . htmlspecialchars($user_id) . " and password is :" . htmlspecialchars($_POST['pwd']).".
                            Please click the following link to activate your account: http://localhost/Jayanta/mycommerce/admin/frontend/acc_active.php?t=$token";
                $header = "nemojoy2001@gmail.com";
                mail($to, $subject, $message, $header);




                $stmt->close();
                unset($_SESSION['key']);

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
            echo "<span style='color:green;'>User Id is Available!!</span>";
        } else {
            echo "<span style='color:red;'>User Id is Not Available!!</span>";
        }
    }
    $stmt->close();
}

//FOR LOGIN VERIFICATION

if (isset($_POST['log-sub'])) {



    $uid = mysqli_real_escape_string($connect, $_POST['log']);
    $password = mysqli_real_escape_string($connect, $_POST['lpw']);

    $select = "select cust_id, cust_fname, password, cust_email, status from customers where user_id = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param('s', $uid);
    $stmt->execute();
    $stmt->bind_result($id, $fn, $pass, $em, $status);
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        while ($stmt->fetch()) {
         if($status == "active"){
            if (!password_verify($password, $pass)) {
                echo "pw";
            } else {
                if (isset($_POST['remember'])) {
                    setcookie("ud", $uid, time() + (86400 * 365));
                    setcookie("pd", $password, time() + 86400);
                    $_SESSION['log'] = array(
                        'fn' => $fn,
                        'id' => $id
                    );
                } else {
                    $_SESSION['log'] = array(
                        'fn' => $fn,
                        'id' => $id
                    );
                   
                }

                setcookie("nm", $fn, time() + (86400 * 365));
                session_regenerate_id(true);
                $data = array("fn" => $fn, "id" => $id);
                echo json_encode($data);
            }
        }else{
            echo "st";
        }
        }
    } else {
        echo "id";
    }
    $stmt->close();
}


// FOR SIGNOUT

if (isset($_REQUEST['op'])) {
    if ($_REQUEST['op'] == 'signout') {
        setcookie("ud", "", time() - 86400);
        setcookie("pd", "", time() - 86400);
        session_destroy();
        echo "signout";
    }
}

//PROFILE DISPLAY

if (isset($_POST['op']) && $_POST['op'] == 'display') {
    $id = mysqli_real_escape_string($connect,  $_POST['id']);
    $select = "SELECT `cust_fname`, `cust_lname`, `cust_address`, `cust_email`, `cust_mobile`, `user_id`, `photo` FROM `customers` WHERE `cust_id` = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param("i", $id);
    $stmt->execute();
    $stmt->bind_result($fn, $ln, $adr, $em, $mb, $uid, $ph);
    while ($stmt->fetch()) {
        $data = array(
            'fn' => $fn,
            'ln' => $ln,
            'adr' => $adr,
            'em' => $em,
            'mb' => $mb,
            'uid' => $uid,
            'ph' => $ph
        );
    }

    echo json_encode($data);
}


//FOR PASSWORD CONFIRM EDIT PAGE 
if (isset($_POST['op']) && $_POST['op'] == 'pchk') {
    $id = mysqli_real_escape_string($connect,  $_POST['id']);
    $pass = mysqli_real_escape_string($connect, $_POST['pw']);
    $select = "SELECT `password` FROM `customers` WHERE `cust_id` = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->bind_result($password);
    $stmt->fetch();
    if (!password_verify($pass, $password)) {
        echo 0;
    } else {
        echo 1;
    }
}

//FOR UPDATE PROFILE 

if (isset($_POST['sub-mit'])) {

    $err_type = "";
    $err_msg = "";

    $id = mysqli_real_escape_string($connect, $_POST['id']);

    if (empty($_POST['f-name']) || empty($_POST['l-name']) || empty($_POST['e-mail']) || empty($_POST['mo-bile']) || empty($_POST['log-id']) || empty($_POST['p-wd']) || empty($_POST['a-dr'])) {
        $err_type = "emp";
        $err_msg = "All the firlds are required to be filled";
    } else {

        $fname = mysqli_real_escape_string($connect, $_POST['f-name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
            $err_type = "fn";
            $err_msg = "Only Letters and White space are allowed";
        }
        $lname = mysqli_real_escape_string($connect, $_POST['l-name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
            $err_type = "ln";
            $err_msg = "Only Letters and White space are allowed";
        }

        $email = mysqli_real_escape_string($connect, $_POST['e-mail']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $err_type = "em";
            $err_msg = "Your Email Id is not valid";
        }

        $mobile = mysqli_real_escape_string($connect, $_POST['mo-bile']);
        if (!preg_match("/^[6-9]\d{9}$/", $mobile)) {
            $err_type = "mb";
            $err_msg = "This is not a valid mobile number";
        }
        $user_id = mysqli_real_escape_string($connect, $_POST['log-id']);

        $pwd = mysqli_real_escape_string($connect, $_POST['p-wd']);
        if (strlen($pwd) < 6) {
            $err_type = "pw";
            $err_msg = "Minimum 6 characters";
        } else {
            $pwd = password_hash($pwd, PASSWORD_BCRYPT);
        }

        $address = mysqli_real_escape_string($connect, $_POST['a-dr']);
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
        $select = "select photo from customers where cust_id = ?";
        $stmt = $connect->prepare($select);
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $stmt->bind_result($img);
        $stmt->fetch();
        $file_name = $img;
        $stmt->close();
    }

    if ($err_type == "") {

        $update = "UPDATE `customers` SET `cust_fname`= ?,`cust_lname`= ?,`cust_address`= ?,`cust_email`= ?,`cust_mobile`= ?,`user_id`= ?,`password`= ?,`photo`= ? WHERE `cust_id` = ?";
        if ($stmt = $connect->prepare($update)) {
            $stmt->bind_param("ssssisssi", $fname, $lname, $address, $email, $mobile, $user_id, $pwd, $file_name, $id);
            $stmt->execute();
            $stmt->close();
            header("Location:edit.php");
        }
    }
}











$connect->close();
