<?php
session_start();
if (!empty($_SESSION["login"])) {
    header("location:tables.php?page=catagories");
}
require "connection.php";

if (isset($_POST["login"])) {
    $email = mysqli_real_escape_string($connect, $_POST["email"]);
    $password = mysqli_real_escape_string($connect, $_POST["pwd"]);

    $sql = "select * from admin_user where email = ?";

    // CREATE A PREPARED STATEMENT
    $stmt = $connect->prepare($sql);


    //BIND PARAMETERS TO placeholder
    $stmt->bind_param("s", $email);

    //RUN PARAMETERS INSIDE DATABASE
    $stmt->execute();
    //$result = $stmt->get_result();
    $stmt->bind_result($adm_id, $adm_email, $adm_pass);

    $em_msg = $pass_msg = "";

    while ($stmt->fetch()) {


        if (empty($adm_email)) {

            header("location:index.php?e=em");
        } elseif ($password !== $adm_pass) {

            header("location:index.php?e=pw");
        } else {
            $_SESSION["login"] = "yes";
            $_SESSION["email"] = $email;
            header("location:tables.php?page=catagories");
        }
    }

    $stmt->close();
}

?>



<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>My Admin - Login</title>

    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">
    <link href="css/sb-admin-2.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
</head>

<body class="bg-gradient-primary">

    <div class="container">

        <!-- Outer Row -->
        <div class="row justify-content-center">

            <div class="col-xl-10 col-lg-12 col-md-9">

                <div class="card o-hidden border-0 shadow-lg my-5">
                    <div class="card-body p-0">
                        <!-- Nested Row within Card Body -->
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-block bg-login-image"></div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h1 class="h4 text-gray-900 mb-4">Welcome Back!</h1>
                                    </div>
                                    <form class="user" method="post">
                                        <div class="form-group">
                                            <input type="email" class="form-control form-control-user" id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter Email Address..." name="email" required>
                                            <?php


                                            ?>
                                        </div>
                                        <div class="form-group pv">
                                            <input type="password" class="form-control form-control-user" id="Password" placeholder="Password" name="pwd" required>
                                            <span class="p-viewer"><i class="fas fa-eye" id="pwd"></i></span>
                                            <?php


                                            ?>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-checkbox small">
                                                <input type="checkbox" class="custom-control-input" id="customCheck">
                                                <label class="custom-control-label" for="customCheck">Remember
                                                    Me</label>
                                            </div>
                                        </div>
                                        <button class="btn btn-primary btn-user btn-block" name="login">
                                            Login
                                        </button>
                                        <!-- <hr>
                                        <a href="index.html" class="btn btn-google btn-user btn-block">
                                            <i class="fab fa-google fa-fw"></i> Login with Google
                                        </a>
                                        <a href="index.html" class="btn btn-facebook btn-user btn-block">
                                            <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                                        </a> -->
                                        <?php
                                        if (isset($_GET["e"])) {

                                            if ($_GET["e"] === "em") {
                                                $em_msg = "Invalid Email Id";
                                                echo "<p style='color:red;padding-left:14px;text-align:center;'>$em_msg</p>";
                                            }

                                            if ($_GET["e"] === "pw") {
                                                $pass_msg = "Invalid Password";
                                                echo "<p style='color:red;padding-left:14px;text-align:center;'>$pass_msg</p>";
                                            }
                                        }

                                        ?>
                                    </form>
                                    <hr>
                                    <div class="text-center">
                                        <a class="small" href="forgot-password.html">Forgot Password?</a>
                                    </div>
                                    <div class="text-center">
                                        <a class="small" href="register.html">Create an Account!</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

        </div>

    </div>



    <script>
        $(document).ready(function() {
            function togglePassword(pass) {
                if (pass.attr("type") === "password") {
                    pass.attr("type", "text");
                } else {
                    pass.attr("type", "password");
                }
            }

            let pwd = $("#Password");

            $(".p-viewer").click(() => {
                $("#pwd").toggleClass("fa-eye fa-eye-slash");
                togglePassword($(pwd));

            })



        })
    </script>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

</body>

</html>
<?php

$connect->close();

?>