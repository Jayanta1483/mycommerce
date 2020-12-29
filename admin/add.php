<?php
ob_start();
session_start();
if (empty($_SESSION["login"])) {
    header("location:index.php");
}

require "connection.php";

if (isset($_GET["page"]) && $_GET["page"] !== "") {
    $page = mysqli_real_escape_string($connect, $_GET["page"]);
}





// if (isset($_GET["type"]) && $_GET["type"] !== "") {
//     $type = $_GET["type"];
//     $operation = $_GET["operation"];

//     if ($operation === "active") {
//         $status = 1;
//     } else {
//         $status = 0;
//     }

// //********************************************** FOR CATAGORIES **********************************************************************************************
// if($page === "catagories"){
//   $status_update = "UPDATE catagories SET cat_status = ? WHERE cat_id =?";  

//   $stmt_status = mysqli_stmt_init($connect);
//     if (!mysqli_stmt_prepare($stmt_status, $status_update)) {
//         echo "<div style='color:red;'>SQL Error Occured!!</div>";
//         die();
//     } else {
//         mysqli_stmt_bind_param($stmt_status, "ii", $status, $id);
//         mysqli_stmt_execute($stmt_status);

//     }
// }
// //************************************************ FOR PRODUCTS ************************************************************************************************
// if($page === "products"){
// $status_update = "UPDATE products SET prod_status = ? WHERE product_id =?";  

//   $stmt_status = mysqli_stmt_init($connect);
//     if (!mysqli_stmt_prepare($stmt_status, $status_update)) {
//         echo "<div style='color:red;'>SQL Error Occured!!</div>";
//         die();
//     } else {
//         mysqli_stmt_bind_param($stmt_status, "ii", $status, $id);
//         mysqli_stmt_execute($stmt_status);

//     }
// }

//};



?>










<!DOCTYPE html>
<html lang="en-IN">

<head>
    <meta charset="utf-8(no BOM)">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>Dash Board - Tables</title>

    <!-- Custom fonts for this template -->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template -->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

    <!-- Custom styles for this page -->
    <link href="vendor/datatables/dataTables.bootstrap4.min.css" rel="stylesheet">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>

</head>


<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <!-- <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar"> -->

        <!-- Sidebar - Brand -->
        <!-- <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">My Admin</div>
            </a> -->

        <!-- Nav Item - Pages Collapse Menu -->
        <!-- <hr class="sidebar-divider">

            <li class="nav-item">
                <a href="tables.php?page=catagories" class="nav-link" aria-expanded="true">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Catagories</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="tables.php?page=products" class="nav-link" aria-expanded="true">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Products</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="tables.php?page=customers" class="nav-link" aria-expanded="true">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Customers</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="tables.php?page=orders" class="nav-link" aria-expanded="true">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a href="tables.php?page=contacts" class="nav-link" aria-expanded="true">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Contact Us</span>
                </a>
            </li> -->


        <!-- Divider -->
        <!-- <hr class="sidebar-divider"> -->


        <!-- Sidebar Toggler (Sidebar) -->
        <!-- <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul> -->
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <form class="form-inline">
                        <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                            <i class="fa fa-bars"></i>
                        </button>
                    </form>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>



                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo $_SESSION["email"]; ?></span>
                                <img class="img-profile rounded-circle mx-1" src="img/undraw_profile.svg"><span><i class="fas fa-caret-down"></i></span>

                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#" data-toggle="modal" data-target="#logoutModal">
                                    <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Logout
                                </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">

                    <!-- DataTales Example -->
                    <div class="card shadow mb-4">
                        <div class="card-header py-3">
                            <h6 class="m-0 font-weight-bold text-primary"><?php echo htmlspecialchars(ucwords($page)); ?></h6>
                        </div>
                        <div class="card-body">

                            <!--#####################################################################################################################################################################################################################################################
                                                    CATAGORIES
##########################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === 'catagories') {


                                if (isset($_POST["submit"])) {
                                    $cat_name = mysqli_real_escape_string($connect, $_POST["cat_name"]);
                                    $cat_status = mysqli_real_escape_string($connect, $_POST["cat_status"]);

                                    $insert = "INSERT INTO catagories(cat_id, cat_name, cat_status) VALUES (NULL,?,?)";

                                    if (!$stmt = $connect->prepare($insert)) {
                                        echo "<div style='color:red'>SQL Error Occured!!</div>";
                                    } else {
                                        $stmt->bind_param("si", $cat_name, $cat_status);
                                        $stmt->execute();
                                        header("location:tables.php?page=catagories");
                                    }
                                    $stmt->close();
                                }


                            ?>
                                <form method="POST">
                                    <div class="table-responsive">
                                        <table class="table table-borderless" width="100%" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <th>CATAGORY NAME</th>
                                                    <td class="text-center" style="float:right;"><input type="text" class="form-control" name="cat_name"></td>
                                                </tr>
                                                <tr>
                                                    <th>STATUS</th>
                                                    <td class="text-center" style="float:right;"><input type="text" class="form-control" name="cat_status"></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group">
                                        <button class="btn btn-primary mx-auto" name="submit">SUBMIT</button>
                                    </div>
                                </form>
                            <?php } ?>


                            <!--###########################################################################################################################################################################################################################################################################################################################################
                                                             PRODUCTS
###############################################################################################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === 'products') {


                                $error = $image_validation = "";

                                if (isset($_POST["sub-prod"])) {
                                    $prod_name = mysqli_real_escape_string($connect, $_POST["prod_name"]);
                                    $prod_mrp = mysqli_real_escape_string($connect, $_POST["prod_mrp"]);
                                    $prod_price = mysqli_real_escape_string($connect, $_POST["prod_price"]);
                                    $prod_qty = mysqli_real_escape_string($connect, $_POST["prod_qty"]);
                                    $prod_status = mysqli_real_escape_string($connect, $_POST["prod_status"]);
                                    $prod_desc = mysqli_real_escape_string($connect, $_POST["prod_desc"]);
                                    $cat_fk = mysqli_real_escape_string($connect, $_POST["cat_fk"]);
                                    $photo = $_FILES["prod_image"];

                                    date_default_timezone_set("Asia/Kolkata");
                                    $file_error = $photo["error"];

                                    if (!$file_error > 0) {


                                        $file = $photo["name"];
                                        $file = str_replace(' ', '', $file);
                                        $file_name = pathinfo($file, PATHINFO_FILENAME);
                                        
                                        $file_ext = strtolower(pathinfo($file, PATHINFO_EXTENSION));
                                        $file_name = $file_name . "_" . date('d-m-Y h-m-sa') . "." . $file_ext;
                                        
                                        $file_size = $photo["size"];
                                        $file_temp = $photo["tmp_name"];


                                        $file_info = @getimagesize($file_temp);
                                        $mime_type = $file_info['mime'];
                                        $mime_allowed = array("image/jpeg", "image/png", "image/webp");
                                        $ext_allowed = array("jpg", "jpeg", "png", "webp");
                                        $folder = "upload/" .$file_name;
                                        
                                        if ($file_size > 2000000) {

                                            $error = "File size is larger than recomended!!";
                                            $image_validation = false;
                                        } else if (!in_array($file_ext, $ext_allowed)) {

                                            $error = "This file extension is not allowed!!";
                                            $image_validation = false;
                                        } else if (!in_array($mime_type, $mime_allowed)) {

                                            $error = "This file mime is not allowed!!";
                                            $image_validation = false;
                                        } else {
                                            $image_validation = true;
                                            $error = "";
                                            move_uploaded_file($file_temp, $folder);
                                        
                                        }
                                    } else {
                                        $file_name = "placeholder-item.webp";
                                    }

                                    if ($file_error == 4 || $image_validation == true) {

                                        $insert = "INSERT INTO products(product_id, cat_fk, prod_name, prod_mrp, prod_price, prod_qty, prod_desc, prod_status, prod_image) VALUES (NULL ,? ,? ,? ,? ,? ,? ,?, ?)";
                                        
                                        if (!$stmt = $connect->prepare($insert)) {
                                            echo "<div style='color:red;'>SQL Error Occured!!</div>";
                                        } else {
                                            $stmt->bind_param("isiiisis",  $cat_fk, $prod_name, $prod_mrp, $prod_price, $prod_qty,  $prod_desc, $prod_status, $file_name);
                                            $stmt->execute();
                                            $stmt->close();
                                            header("location:tables.php?page=products");
                                        }
                                    }

                                    
                                }


                            ?>
                                <form method="POST" enctype="multipart/form-data">
                                    <!-- <div class="form-row">
                                        <div class="form-group col-sm">
                                            <label>Edit Product Name</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1" name="prod_name" value="<?php echo htmlspecialchars(ucwords($prod_name)); ?>">
                                        </div>
                                    </div> -->
                                    <div class="table-responsive">
                                        <table class="table table-borderless" width="100%" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <th>IMAGE</th>
                                                    <td style="float: right;"><img src="placeholder-item.webp" width="80px" height="100px" id="image"><br><input type="file" name="prod_image" id="image-input"></td>
                                                    <?php if ($image_validation == false) {
                                                        echo "<p class='text-center text-danger'>" . $error . "</p>";
                                                    }; ?>
                                                </tr>
                                                <tr>
                                                    <th>PRODUCT NAME</th>
                                                    <td style="float: right;"><input type="text" name="prod_name" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>CATAGORY_fk</th>
                                                    <td style="float: right;"><input type="number" name="cat_fk" id="" class="form-control"><span style="cursor:pointer;float:right;color:lightblue;" data-toggle="modal" data-target="#catagoryModal"><i class="fas fa-info-circle"></i></span></td>
                                                </tr>
                                                <tr>
                                                    <th>MRP</th>
                                                    <td style="float: right;"><input type="number" name="prod_mrp" id="" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>SELL PRICE</th>
                                                    <td style="float: right;"><input type="number" name="prod_price" id="" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>QTY</th>
                                                    <td style="float: right;"><input type="number" name="prod_qty" id="" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>STATUS</th>
                                                    <td style="float: right;"><input type="number" name="prod_status" id="" class="form-control"></td>
                                                </tr>
                                                <tr>
                                                    <th>DESCRIPTION</th>
                                                    <td style="float: right;"><textarea name="prod_desc" id="" cols="30" rows="10" class="form-control" value=""></textarea></td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group col-sm text-center">
                                        <button class="btn btn-primary btn-lg" name="sub-prod">SUBMIT</button>
                                    </div>
                                </form>
                            <?php } ?>
                        </div>
                    </div>

                </div>
                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Jayanta Sarkar <?php echo date("Y"); ?></span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- catgory ID Modal-->
    <div class="modal fade" id="catagoryModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Catagory IDs</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">
                    <div class="table-responsive">
                        <table class="table table-borderless">
                            <thead>
                                <tr>
                                    <th class="scope">Catagory ID</th>
                                    <th class="scope">Catagory Name</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sql = "select * from catagories";
                                $query = $connect->query($sql);


                                while ($res = $query->fetch_assoc()) {
                                ?>
                                    <tr>
                                        <td><?php echo htmlspecialchars($res["cat_id"]);  ?></td>
                                        <td><?php echo htmlspecialchars($res["cat_name"]);  ?></td>
                                    </tr>
                                <?php }
                                $connect->close(); ?>
                            </tbody>
                        </table>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">OK</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>


    <script>
        let imageInput = document.getElementById("image-input");
        let image = document.getElementById("image");
        imageInput.addEventListener("change", function() {
            let file = this.files[0];

            let reader = new FileReader();

            reader.onload = (e) => image.src = e.target.result;
            reader.readAsDataURL(file);
        })
    </script>
    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/datatables/jquery.dataTables.min.js"></script>
    <script src="vendor/datatables/dataTables.bootstrap4.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/datatables-demo.js"></script>

</body>

</html>