<?php
require "connection.php";


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

    <title>Customer Registration</title>

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
        .p-viewer{
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
        #eye{
          color: red;
           margin: 17px;
           
        }

        div#messageModal{
            background-color: rgba(0,0,0,0);
            
        }
    </style>
</head>

<body>

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
                                    New user
                                    <span>
                                        registration
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

                                <div class="panel-group" >

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
                                            <div class="panel-body" >
                                            <div class="alert alert-danger" role="alert" id="profileAlert" style="display:none;"></div>
                                                <form class="form-horizontal" id="myForm" enctype="multipart/form-data">
                                                    <div class="form-group text-center">
                                                        <img src="customer_avatar.jpg" alt="" id="custProfile" width="100px" height="100px" style="cursor: pointer;" >
                                                        <label for=""style="display:block;">Profile Image</label>
                                                        <input type="file" name="cust-image" id="cust-image" style="display: none;">
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="frName" class="col-sm-3 control-label text-darkness">Your first name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="fname" name="fname">
                                                        </div>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="lnName" class="col-sm-3 control-label text-darkness">Your last name</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="lname" name="lname">
                                                        </div>
                                                    </div>
                                                    <div class="form-group pd-none">
                                                        <label for="email" class="col-sm-3 control-label text-darkness">Enter your email</label>
                                                        <div class="col-sm-8">
                                                            <input type="email" class="form-control" id="email" name="email">
                                                        </div>
                                                    </div>
                                                    <div class="form-group pd-none">
                                                        <label for="mobile" class="col-sm-3 control-label text-darkness">Enter your mobile no.</label>
                                                        <div class="col-sm-8">
                                                            <input type="number" class="form-control" id="mobile" name="mobile">
                                                        </div>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="slLogin" class="col-sm-3 control-label text-darkness">Select User Id</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="logid" name="logid">
                                                        </div>
                                                    </div>



                                                    <div class="form-group pd-none">
                                                        <label for="password" class="col-sm-3 control-label text-darkness">Enter your password</label>
                                                        <div class="col-sm-8">
                                                            <input type="password" class="form-control" id="pwd" name="pwd">
                                                            <span class="p-viewer border border-dark"><i class="fas fa-eye" id="eye"></i></span>
                                                        </div>
                                                    </div>

                                                    <div class="form-group pd-none">
                                                        <label for="autocomplete" class="col-sm-3 control-label text-darkness">Address</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="adr" name="adr">
                                                        </div>
                                                    </div>
                                                    <div class="from-group pd-none text-center">
                                                        <buttom class="btn btn-primary" name="submit" id="submit">SUBMIT</buttom>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- <div class="panel panel-default">
                                        <div class="panel-heading" id="addressSet">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#collapseTwo">
                                                    <span class="panel-indicator"></span>
                                                    Address settings
                                                </a>
                                            </h4>
                                        </div>
                                         <div id="collapseTwo" class="panel-collapse collapse">
                                            <div class="panel-body"> -->

                                    <!-- <form class="form-horizontal"> -->

                                    <!-- Authocompille -->



                                    <!-- / Authocompille -->

                                    <!-- <div class="form-group pd-sm">
                                                        <div class="col-sm-offset-3 col-sm-7">
                                                            <div class="checkbox padding">
                                                                <input type="checkbox" id="chackAddress" checked>
                                                                <label for="chackAddress">
                                                                    <span class="checkbox-input">
                                                                        <span class="off">yes</span>
                                                                        <span class="on">no</span>
                                                                    </span>
                                                                    this delively addres is valid
                                                                </label>
                                                            </div>
                                                        </div>
                                                    </div> -->

                                    <!-- </form> -->

                                    <!-- 
                                            </div>
                                        </div>
                                    </div> -->

                                    <!-- <div class="panel panel-default"> -->
                                    <!-- <div class="panel-heading" id="headingTwo">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#creditCard">
                                                    <span class="panel-indicator"></span>
                                                    Credit card payment
                                                </a>
                                            </h4>
                                        </div> -->
                                    <!-- <div id="creditCard" class="panel-collapse collapse">
                                            <div class="panel-body"> -->

                                    <!-- <div class="col-xs-2"> -->

                                    <!-- <div class="form-group pd-none">
                                                        <div class="checkbox vers-2 pd-none">
                                                            <input type="radio" name="group1" id="item-check-1">
                                                            <label for="item-check-1">
                                                                <i class="icofont icofont-check-alt"></i>
                                                                <span class="text-icon icofont icofont-american-express"></span>
                                                            </label>
                                                        </div>
                                                    </div> -->

                                    <!-- <div class="form-group pd-none">
                                                        <div class="checkbox vers-2 pd-none">
                                                            <input type="radio" name="group1" id="item-check-2">
                                                            <label for="item-check-2">
                                                                <i class="icofont icofont-check-alt"></i>
                                                                <span class="text-icon icofont icofont-visa"></span>
                                                            </label>
                                                        </div>
                                                    </div> -->

                                    <!-- <div class="form-group pd-none">
                                                        <div class="checkbox vers-2 pd-none">
                                                            <input type="radio" name="group1" id="item-check-3">
                                                            <label for="item-check-3">
                                                                <i class="icofont icofont-check-alt"></i>
                                                                <span class="text-icon icofont icofont-mastercard"></span>
                                                            </label>
                                                        </div>
                                                    </div> -->
                                    <!-- </div> -->

                                    <!-- <div class="col-xs-10 col-sm-5">
                                                    <div class="form-group">
                                                        <label for="cardHolder">Card holder first name</label>
                                                        <input type="password" class="form-control" id="cardHolder">
                                                    </div>
                                                </div> -->

                                    <!-- <div class="col-xs-10 col-sm-5">
                                                    <div class="form-group">
                                                        <label for="cardHolderLast">Card holder last name</label>
                                                        <input type="password" class="form-control" id="cardHolderLast">
                                                    </div>
                                                </div> -->

                                    <!-- <div class="col-xs-10 col-sm-6">
                                                    <div class="form-group">
                                                        <label for="cardNum">Card number</label>
                                                        <input type="password" class="form-control" id="cardNum">
                                                    </div>
                                                </div> -->

                                    <!-- <div class="col-xs-5 col-sm-2">
                                                    <div class="form-group">
                                                        <label for="expiryDate">Expiry Date</label>
                                                        <input type="password" class="form-control" id="expiryDate">
                                                    </div>
                                                </div> -->

                                    <!-- <div class="col-xs-5 col-sm-2">
                                                    <div class="form-group">
                                                        <label for="cvc">CVV/CVC</label>
                                                        <input type="password" class="form-control" id="cvc">
                                                    </div>
                                                </div> -->

                                    <!-- <div class="col-xs-12">
                                                    <div class="form-group row">
                                                        <div class="col-sm-offset-2 col-sm-8">
                                                            <button type="button" class="btn btn-primary btn-material">
                                                                <span class="body">Save method</span>
                                                                <i class="icon icofont icofont-check-circled"></i>
                                                            </button>
                                                        </div>
                                                    </div>
                                                </div> -->
                                    <!-- </div>
                                        </div> -->
                                    <!-- </div>  -->

                                    <!-- <div class="panel panel-default">
                                        <div class="panel-heading" id="headingOne">
                                            <h4 class="panel-title">
                                                <a class="collapsed" data-toggle="collapse" data-parent="#accordion" href="#payPall">
                                                    <span class="panel-indicator"></span>
                                                    PayPal account
                                                </a>
                                            </h4>
                                        </div> -->
                                    <!-- <div id="payPall" class="panel-collapse collapse">
                                            <div class="panel-body">
                                                <form class="form-horizontal">
                                                    <div class="form-group pd-none">
                                                        <label for="PayPal" class="col-sm-3 control-label text-darkness">PayPal account</label>
                                                        <div class="col-sm-8">
                                                            <input type="text" class="form-control" id="PayPal">
                                                        </div>
                                                    </div>

                                                    <div class="form-group">
                                                        <div class="col-sm-offset-3 col-sm-7">
                                                            <a href="#" class="sdw-hover btn btn-material btn-yellow ripple-cont">Next</a>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div> -->
                                    <!-- </div>  -->
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