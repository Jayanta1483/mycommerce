<!-- 
        NAVBAR
        =============================================== -->
<nav class="navbar navbar-default">

    <div class="container">

        <!-- Brand and toggle get grouped for better mobile display -->
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#">
                <img src="images/main-brand.png" alt="" class="brand">
            </a>
        </div>

        <!-- Collect the nav links, forms, and other content for toggling -->
        <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">

            <!-- Top panel / search / phone -->
            <div class="top-panel">

                <div class="phone text-blue">
                    <i class="icofont icofont-phone-circle"></i>
                    +1 234 567 89 10
                </div>

                <form class="search bg-grey-light btn-material">
                    <input type="text" class="search-form" id="top-search">
                    <label for="top-search">search</label>
                </form>

                <div class="btn-cols">

                    <ul class="list-btn-group">
                        <li>

                            <a href="#" data-toggle="modal" data-target="#myModal">
                                Sing in
                            </a>

                        </li>
                        <?php if (!empty($_SESSION['log'])) { ?>
                            <li>
                                <a href="#" id="signOut">
                                    <b>Sing out</b>
                                </a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a href="register.php" target="_blank">
                                    <b>Sing up</b>
                                </a>
                            </li>
                        <?php } ?>
                    </ul>
                </div>
            </div>

            <ul class="nav navbar-nav navbar-right info-panel">

                <!-- Profile -->
                <?php
                if (!empty($_SESSION['log'])) { ?>
                    <li class="profile">
                        <span class="wrap">

                            <!-- Image -->
                            <span class="image bg-white text-center">

                                <!-- New message badge -->
                                <span class="badge bg-blue hidden-xs hidden-sm"></span>

                                <span class="icon">
                                    <i class="icofont icofont-user-alt-4 text-blue"></i>
                                </span>

                                <!-- <img id="p-img" src="customer_avatar.jpg" alt="" class="img-profile rounded-circle"> -->

                                <!-- img src="images/profile/profile-img.jpg" alt="" -->
                            </span>

                            <!-- Info -->
                            <span class="info">
                                <!-- Name -->

                                <span class="name text-uppercase"><?php echo $fn; ?></span>
                                <a href="edit.php">edit profile</a>
                            </span>
                        </span>
                    </li>

                    <!-- Cart -->
                    <li class="cart">

                        <a href="#" class="cart-icon hidden-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">

                            <span class="badge bg-blue"></span>

                            <i class="icofont icofont-cart-alt"></i>
                        </a>

                        <a href="#" class="visible-xs" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false">
                            <i class="icofont icofont-cart-alt"></i>
                            Shopping cart
                        </a>

                        <!-- Dropdown items list -->
                        <ul class="dropdown-menu">

                            <!-- Item -->
                            <li>
                                <div class="wrap">

                                    <!-- Image -->
                                    <div class="image">
                                        <img src="images/shop/img-01.jpg" alt="">
                                    </div>

                                    <!-- Caption -->
                                    <div class="caption">
                                        <span class="comp-header st-1 text-uppercase">
                                            T-SHIPT
                                            <span>
                                                MEN COLLECTION
                                            </span>
                                            <span>
                                                FAKE BRAND
                                            </span>
                                        </span>

                                        <span class="price">
                                            <span class="text-grey-dark">$</span>
                                            257 <small class="text-grey-dark">.00</small>
                                        </span>
                                    </div>

                                    <!-- Remove btn -->
                                    <span class="remove-btn bg-blue">
                                        <i class="icofont icofont-bucket"></i>
                                    </span>
                                </div>
                            </li>

                            <!-- Item -->
                            <li>
                                <div class="wrap">

                                    <!-- Image -->
                                    <div class="image">
                                        <img src="images/shop/img-01.jpg" alt="">
                                    </div>

                                    <!-- Caption -->
                                    <div class="caption">
                                        <span class="comp-header st-1 text-uppercase">
                                            T-SHIPT
                                            <span>
                                                MEN COLLECTION
                                            </span>
                                            <span>
                                                FAKE BRAND
                                            </span>
                                        </span>

                                        <span class="price">
                                            <span class="text-grey-dark">$</span>
                                            257 <small class="text-grey-dark">.00</small>
                                        </span>
                                    </div>

                                    <!-- Remove btn -->
                                    <span class="remove-btn bg-blue">
                                        <i class="icofont icofont-bucket"></i>
                                    </span>
                                </div>
                            </li>

                            <!-- Item -->
                            <li>
                                <div class="wrap">

                                    <!-- Image -->
                                    <div class="image">
                                        <img src="images/shop/img-01.jpg" alt="">
                                    </div>

                                    <!-- Caption -->
                                    <div class="caption">
                                        <span class="comp-header st-1 text-uppercase">
                                            T-SHIPT
                                            <span>
                                                MEN COLLECTION
                                            </span>
                                            <span>
                                                FAKE BRAND
                                            </span>
                                        </span>

                                        <span class="price">
                                            <span class="text-grey-dark">$</span>
                                            257 <small class="text-grey-dark">.00</small>
                                        </span>
                                    </div>

                                    <!-- Remove btn -->
                                    <span class="remove-btn bg-blue">
                                        <i class="icofont icofont-bucket"></i>
                                    </span>
                                </div>
                            </li>


                            <li class="more-btn sdw">
                                <a href="card-page-step-1.html" class="btn-material btn-primary">
                                    View order <i class="icofont icofont-check-circled"></i>
                                </a>
                            </li>


                        </ul>
                    </li>
                <?php } ?>
            </ul>

            <ul class="nav navbar-nav">
                <li class="active">
                    <a href="index.php">
                        home
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        categories <i class="icofont icofont-curved-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="#">Man line</a></li>
                        <li><a href="#">Woman</a></li>
                        <li><a href="#">Jewerly</a></li>
                        <li><a href="#">Electronics</a></li>
                        <li><a href="#">Clothes</a></li>
                    </ul>
                </li>
                <li>
                    <a href="index.html" class="dropdown-toggle" data-toggle="dropdown">
                        new
                    </a>
                </li>
                <li>
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                        pages <i class="icofont icofont-curved-down"></i>
                    </a>
                    <ul class="dropdown-menu">
                        <li><a href="shop-list.html">Shop category</a></li>
                        <li><a href="shop-item.html">Shop item</a></li>
                        <li><a href="card-page-step-1.html">Shopping card. Step 1</a></li>
                        <li><a href="card-page-step-2.html">Shopping card. Step 2</a></li>
                        <li><a href="card-page-step-3.html">Shopping card. Step 3</a></li>
                        <li><a href="register-page.html">Register page</a></li>
                        <li><a href="blog-item.html">Item blog</a></li>
                    </ul>
                </li>
            </ul>

        </div><!-- /.navbar-collapse -->
    </div><!-- /.container-fluid -->

</nav>
<!-- END: NAVBAR -->

<!-- 
        REGISTER MODAL
        =============================================== -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" id="log-close">
                    <span aria-hidden="true">
                        <i class="icofont icofont-close-line"></i>
                    </span>
                </button>
                <h4 class="modal-title" id="myModalLabel">
                    Authorization
                    <span>
                        required
                    </span>
                </h4>
            </div>

            <div class="modal-body">

                <!-- Authirize form -->
                <div class="row auth-form">
                    <div class="col-md-4">

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

                    <div class="col-md-5 col-md-offset-1 form-fields">
                        <div id="logMsg"></div>

                        <form id="logForm" method="post">
                            <input type="hidden" name="csrf-log" id="csrf-log" value="">
                            <div class="form-group">
                                <label for="exampleInputEmail1">User ID</label>
                                <input type="text" class="form-control" id="userid" name="log" placeholder="User ID" value="<?php if (isset($_COOKIE['ud'])) {
                                                                                                                                echo $_COOKIE['ud'];
                                                                                                                            }   ?>">
                            </div>
                            <div class="form-group log-pw-con">
                                <label for="exampleInputPassword1">Password</label>
                                <input type="password" class="form-control" id="log-pwd" name="lpw" placeholder="Password" value="<?php if (isset($_COOKIE['pd'])) {
                                                                                                                                        echo $_COOKIE['pd'];
                                                                                                                                    }   ?>">
                                <span class="p-viewer-log"><i class="fas fa-eye" id="log-eye"></i></span>
                            </div>
                            <div class="checkbox padding">
                                <input type="checkbox" id="inputCheckBox" name="remember">
                                <label for="inputCheckBox">
                                    <span class="checkbox-input">
                                        <span class="off">off</span>
                                        <span class="on">on</span>
                                    </span>
                                    remember password
                                </label>
                            </div>
                            <span class="sdw-wrap">
                                <button type="button" class="sdw-hover btn btn-yellow btn-lg ripple-cont" id="log-sub">Login</button>
                                <span class="sdw"></span>
                            </span>

                            <ul class="addon-login-btn">
                                <li>
                                    <a href="#">register</a>
                                </li>
                                <li>or</li>
                                <li>
                                    <a href="recov_pass.php" target="_blank">restore password</a>
                                </li>
                            </ul>
                        </form>
                    </div>
                </div>
                <!-- / Authirize form -->
            </div>
        </div>
    </div>
</div>
<!-- END: REGISTER MODAL -->

<!-- Bootstrap core JavaScript
        ================================================== -->
<!-- Placed at the end of the document so the pages load faster -->
<!-- <script src="assets/js/jquery.min.js"></script>
        <script src="assets/js/bootstrap.min.js"></script>
        <script src="assets/js/jquery-ui.min.js"></script>
        <script src="assets/js/owl.carousel.min.js"></script><!-- OWL Carousel -->
<!-- <script src="assets/js/lv-ripple.jquery.min.js"></script><!-- BTN Material effects -->
<!-- <script src="assets/js/SmoothScroll.min.js"></script>SmoothScroll -->
<!-- <script src="assets/js/jquery.TDPageEvents.min.js"></script><!-- Page Events -->
<!-- <script src="assets/js/jquery.TDParallax.min.js"></script>Parallax -->
<!-- <script src="assets/js/jquery.TDTimer.min.js"></script>Timer -->
<!-- <script src="assets/js/selectize.min.js"></script>Select customize -->
<!-- <script src="js/main.min.js"></script> -->