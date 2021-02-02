<?php
require "connection.php";
 require "functions.php";
// session_start();

// auto_session();

if (empty($_SESSION['log'])) {
    header('Location:register.php');
    die();
}

//FOR UPDATE PROFILE

$err_msg = "";
$suc_msg = "";

if (isset($_POST['sub-mit'])) {
$err_type = "";

    $id = mysqli_real_escape_string($connect, $_POST['id']);

    if (empty($_POST['f-name']) || empty($_POST['l-name']) || empty($_POST['e-mail']) || empty($_POST['mo-bile']) || empty($_POST['log-id']) || empty($_POST['p-wd']) || empty($_POST['a-dr'])) {
         $err_type = "emp";
        $err_msg = "<p style='color:red;'>All the firlds are required to be filled</p>";
    } else {

        $fname = mysqli_real_escape_string($connect, $_POST['f-name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $fname)) {
             $err_type = "fn";
            $err_msg = "<p style='color:red;'>Only Letters and White space are allowed</p>";
        }
        $lname = mysqli_real_escape_string($connect, $_POST['l-name']);
        if (!preg_match("/^[a-zA-Z-' ]*$/", $lname)) {
             $err_type = "ln";
            $err_msg = "<p style='color:red;'>Only Letters and White space are allowed</p>";
        }

        $email = mysqli_real_escape_string($connect, $_POST['e-mail']);
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
             $err_type = "em";
            $err_msg = "<p style='color:red;'>Your Email Id is not valid</p>";
        }

        $mobile = mysqli_real_escape_string($connect, $_POST['mo-bile']);
        if (!preg_match("/^[6-9]\d{9}$/", $mobile)) {
             $err_type = "mb";
            $err_msg = "<p style='color:red;'>This is not a valid mobile number</p>";
        }
        $user_id = mysqli_real_escape_string($connect, $_POST['log-id']);

        $pwd = mysqli_real_escape_string($connect, $_POST['p-wd']);
        if (strlen($pwd) < 6) {
             $err_type = "pw";
            $err_msg = "<p style='color:red;'>Minimum 6 characters</p>";
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
            $err_msg = "<p style='color:red;'>File Size is Greater than 2mb</p>";
        } else if (!in_array($file_ext, $ext_arr)) {
             $err_type = "image";
            $err_msg = "<p style='color:red;'>This File Extension is Not Allowed</p>";
        } else if (!in_array($mime_file, $mime_arr)) {
             $err_type = "image";
            $err_msg = "<p style='color:red;'>This Mime is Not Allowed</p>";
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
            $suc_msg = "<p style='color:green;'>Successfully Updated</p>";
            // header("Location:edit.php");
        }
    }
}





$id = $_SESSION['log']['id'];
$select = "select cust_fname from customers where cust_id = ?";
$stmt = $connect->prepare($select);
$stmt->bind_param("i", $id);
$stmt->execute();
$stmt->bind_result($fn);
$stmt->fetch();






?>



<!DOCTYPE html>
<html lang="en-IN">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <!--link rel="icon" href="#"-->

    <title><?php echo $fn; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/theme.min.css" rel="stylesheet">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Raleway:500,800" rel="stylesheet">

    <!-- Icons -->
    <link href="assets/fonts/icofont/icofont.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/46b79071a9.js" crossorigin="anonymous"></script>

    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
        <![endif]-->
    <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous"> -->

    <style>
        .p-viewer {
            position: absolute;
            top: 0;
            right: 15px;
            display: inline-block;
            width: 50px;
            height: 50px;
            /* border: 1px solid black; */
            border-radius: 0 3px 3px 0;
            background-color: #e6e6e6;
            cursor: pointer;
            text-align: center;
        }

        #eye1,
        #eye2 {
            color: red;
            margin: 17px;

        }
    </style>
</head>

<body id="body">

    <!-- 
        PRELOADER
        =============================================== -->
    <div class="preloader">
        <img src="images/preloader.gif" alt="">
    </div>
    <!-- END: PRELOADER -->

    <!-- 
        NAVBAR
        =============================================== -->
    <?php

    include "navbar.php";

    ?>
    <!-- END: NAVBAR -->




    <div class="container">

        <!-- 
            CONTENT
            =============================================== -->
        <div class="row block none-padding-top">

            <div class="col-xs-12">
                <div class="sdw-block">
                    <div class="wrap bg-white">

                        <!-- Authirize form -->
                        <div class="row head-block">

                            <!-- Header & nav -->
                            <div class="col-md-12">

                                <!-- Header -->
                                <h1 class="header text-uppercase">
                                     <?php  echo $fn; ?>
                                    <span>
                                        Update Profile
                                    </span>
                                </h1>
                            </div>
                        </div>
                        <!-- Authirize form -->

                        <div class="row ">

                            <!-- Header & nav -->
                            <div class="col-md-3">

                                <!-- Text -->
                                <p class="text">
                                    Magni labore ratione maiores, laborum quaerat molestiae excepturi. Corporis, necessitatibus earum.
                                </p>

                                <!-- Nav -->
                                <div class="asside-nav no-bg">
                                    <ul class="nav-vrt border">
                                        <li class="active">
                                            <a href="#" class="btn-material">Privacy policy</a>
                                        </li>

                                        <li>
                                            <a href="#" class="btn-material">Terms and conditions</a>
                                        </li>

                                        <li>
                                            <a href="#" class="btn-material">FAQ</a>
                                        </li>
                                    </ul>
                                </div>

                            </div>

                            <div class="col-md-9">

                                <div class="panel-group">

                                    <div class="panel panel-default">
                                        <div class="panel-heading" id="profileInfo">
                                            <h4 class="panel-title">
                                                <a>
                                                    <!-- <span class="panel-indicator"></span> -->
                                                    CUSTOMER PROFILE INFORMATION
                                                </a>
                                            </h4>
                                        </div>
                                        <div id="bankTransrerColl">
                                            <div class="panel-body">
                
                                                <form class="form-horizontal" id="editForm" enctype="multipart/form-data" action="" method="POST">
                                                    <input type="hidden" name="id" id="id" value="<?php echo htmlspecialchars($_SESSION['log']['id']); ?>">
                                                    <div class="form-group text-center">
                                                        <img src="uploads/customer_avatar.jpg" alt="" id="cust-Profile" width="100px" height="100px" style="cursor: pointer;">
                                                        <label for="" style="display:block;">Profile Image</label>
                                                        <input type="file" name="cust_image" id="cust_image" style="display: none;">
                                                        <p id="image-Error" class="text-center" style="color:red;display:none;"></p>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="frName" class="col-sm-3 control-label text-darkness">Your first name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control text-capitalize" id="f-name" name="f-name">
                                                            <p id="fn-Msg" class="text-center" style="color:red;display:none;"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="lnName" class="col-sm-3 control-label text-darkness">Your last name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control text-capitalize" id="l-name" name="l-name">
                                                            <p id="ln-Msg" class="text-center" style="color:red;display:none;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pd-none">
                                                        <label for="email" class="col-sm-3 control-label text-darkness">Enter your email</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" class="form-control" id="e-mail" name="e-mail">
                                                            <p id="em-Msg" class="text-center" style="color:red;display:none;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="form-group pd-none">
                                                        <label for="mobile" class="col-sm-3 control-label text-darkness">Enter your mobile no.</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="mo-bile" name="mo-bile">
                                                            <p id="mb-Msg" class="text-center" style="color:red;display:none;"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="slLogin" class="col-sm-3 control-label text-darkness">Select User Id</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="log-id" name="log-id">
                                                            <p class="text-center" style="color:red;display:none;" id="id-Msg"></p>
                                                        </div>
                                                    </div>



                                                    <div class="form-group pd-none">
                                                        <label for="password" class="col-sm-3 control-label text-darkness">Enter your password</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control pwd" id="p-wd" name="p-wd">
                                                            <span class="p-viewer border border-dark" id="pw1"><i class="fas fa-eye" id="eye1"></i></span>
                                                            <p id="pw-Msg" class="text-center" style="color:red;display:none;"></p>
                                                        </div>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="autocomplete" class="col-sm-3 control-label text-darkness">Address</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control text-capitalize" id="a-dr" name="a-dr">
                                                            <p id="ad-Msg" class="text-center" style="color:red;display:none;"></p>
                                                        </div>
                                                    </div>
                                                    <div class="from-group pd-none text-center">
                                                        <?php echo $err_msg; ?>
                                                        <button class="btn btn-primary" name="sub-mit" id="sub-mit" type="submit">SUBMIT</button>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>


                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
        <!-- END: CONTENT -->

    </div>









    <!-- <--   FOOTER
        =============================================== -->
    <?php
    include "footer.php";

    ?>
    <!-- END: FOOTER -->


    <!-- Bootstrap core JavaScript
        ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <!-- <script src="assets/js/jquery.min.js"></script> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/jquery-ui.min.js"></script>
    <script src="assets/js/owl.carousel.min.js"></script><!-- OWL Carousel -->
    <script src="assets/js/lv-ripple.jquery.min.js"></script><!-- BTN Material effects -->
    <script src="assets/js/SmoothScroll.min.js"></script><!-- SmoothScroll -->
    <script src="assets/js/jquery.TDPageEvents.min.js"></script><!-- Page Events -->
    <script src="assets/js/jquery.TDParallax.min.js"></script><!-- Parallax -->
    <script src="assets/js/jquery.TDTimer.min.js"></script><!-- Timer -->
    <script src="assets/js/selectize.min.js"></script><!-- Select customize -->
    <script src="js/main.min.js"></script>

    <!-- Google API -->
    <script src="https://maps.googleapis.com/maps/api/js?key=GOOGLE_MAPS_API_KEY&libraries=places&callback=initAutocomplete" async defer></script><!-- / Google API -->

    <script src="myJquery.js"></script>


</body>

</html>