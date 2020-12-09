<?php
ob_start();
session_start();
if (empty($_SESSION["login"])) {
    header("location:index.php");
}

require "connection.php";

if (isset($_GET["page"]) && $_GET["page"] !== "") {
    $page = mysqli_real_escape_string($connect, $_GET["page"]);
    $id = mysqli_real_escape_string($connect, $_GET["id"]);
}
    if(isset($_GET["type"]) && $_GET["type"]!==""){
    $type = $_GET["type"];
        
        if ($type === "active") {
            $status = 0;
        } else {
            $status = 1;
        }
        if ($_GET["page"] === "catagories") {
            $update = "UPDATE catagories SET cat_status = ? WHERE cat_id=?";
            $stmt = mysqli_stmt_init($connect);
            mysqli_stmt_prepare($stmt, $update);
            mysqli_stmt_bind_param($stmt, "ii", $status, $id);
            mysqli_stmt_execute($stmt);
        }

        if ($_GET["page"] === "products") {
            $update = "UPDATE products SET prod_status = ? WHERE product_id=?";
            $stmt = mysqli_stmt_init($connect);
            mysqli_stmt_prepare($stmt, $update);
            mysqli_stmt_bind_param($stmt, "ii", $status, $id);
            mysqli_stmt_execute($stmt);
        }
    
};

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
        <ul class="navbar-nav bg-gradient-primary sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3">My Admin</div>
            </a>

            <!-- Nav Item - Pages Collapse Menu -->
            <hr class="sidebar-divider">

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
            </li>


            <!-- Divider -->
            <hr class="sidebar-divider">


            <!-- Sidebar Toggler (Sidebar) -->
            <div class="text-center d-none d-md-inline">
                <button class="rounded-circle border-0" id="sidebarToggle"></button>
            </div>

        </ul>
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
                            <h6 class="m-0 font-weight-bold text-primary">Edit
                                <?php echo htmlspecialchars(ucwords($page)); ?></h6>
                        </div>
                        <div class="card-body">
                            <!--#####################################################################################################################################################################################################################################################
                                                    CATAGORIES
##########################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === 'catagories') {

                                // For select query and Display data on edit page

                                $sql = "select cat_name from catagories where cat_id = ?";
                                $stmt = mysqli_stmt_init($connect);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "<div style='color:red;'>SQL Error Occured!!</div>";
                                    die();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "i", $id);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $cat_name = $row["cat_name"];
                                    }
                                }

                                //For update query and update data

                                if (isset($_POST["submit"])) {

                                    $name = mysqli_real_escape_string($connect, $_POST["cat_name"]);

                                    $update = "UPDATE catagories SET cat_name = ? WHERE cat_id =?";
                                    $stmt_update = mysqli_stmt_init($connect);
                                    if (!mysqli_stmt_prepare($stmt_update, $update)) {
                                        echo "<div style='color:red;'>SQL Error Occured!!</div>";
                                        die();
                                    } else {
                                        mysqli_stmt_bind_param($stmt_update, "si", $name, $id);
                                        mysqli_stmt_execute($stmt_update);
                                        header("location:tables.php?page=catagories");
                                    }
                                }


                            ?>
                                <form method="POST">
                                    <div class="form-row">
                                        <div class="form-group col-sm">
                                            <label>Edit Catagory Name</label>
                                            <input type="text" class="form-control" id="exampleFormControlInput1" name="cat_name" value="<?php echo htmlspecialchars(ucwords($cat_name)); ?>">
                                        </div>
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

                                // For select query and Display data on edit page

                                $sql = "select * from products where product_id = ?";
                                $stmt = mysqli_stmt_init($connect);
                                if (!mysqli_stmt_prepare($stmt, $sql)) {
                                    echo "<div style='color:red;'>SQL Error Occured!!</div>";
                                    die();
                                } else {
                                    mysqli_stmt_bind_param($stmt, "i", $id);
                                    mysqli_stmt_execute($stmt);
                                    $result = mysqli_stmt_get_result($stmt);

                                    while ($row = mysqli_fetch_assoc($result)) {
                                        $prod_name = $row["prod_name"];
                                        $cat_fk = $row["cat_fk"];
                                        $prod_mrp = $row["prod_mrp"];
                                        $prod_price = $row["prod_price"];
                                        $prod_qty = $row["prod_qty"];
                                        $prod_desc = $row["prod_desc"];
                                        $prod_image = $row["prod_image"];
                                        $prod_status = $row["prod_status"];
                                    }
                                }

                                //For update query and update data

                                if (isset($_POST["sub-prod"])) {

                                    $p_name = mysqli_real_escape_string($connect, $_POST["prod_name"]);
                                    $c_fk = mysqli_real_escape_string($connect, $_POST["cat_fk"]);
                                    $p_mrp = mysqli_real_escape_string($connect, $_POST["prod_mrp"]);
                                    $p_price = mysqli_real_escape_string($connect, $_POST["prod_price"]);
                                    $p_qty = mysqli_real_escape_string($connect, $_POST["prod_qty"]);
                                    $p_desc = mysqli_real_escape_string($connect, $_POST["prod_desc"]);
                                    $p_image = mysqli_real_escape_string($connect, $_POST["prod_image"]);
                                    //$p_name = mysqli_real_escape_string($connect, $_POST["prod_name"]);

                                    $update = "UPDATE products SET cat_fk= ?,prod_name= ?,prod_mrp= ?,prod_price= ?,prod_qty=?,prod_image=?,prod_desc=? WHERE product_id = ?";
                                    $stmt_update = mysqli_stmt_init($connect);
                                    if (!mysqli_stmt_prepare($stmt_update, $update)) {
                                        echo "<div style='color:red;'>SQL Error Occured!!</div>";
                                        die();
                                    } else {
                                        mysqli_stmt_bind_param($stmt_update, "isiiissi", $c_fk, $p_name, $p_mrp, $p_price, $p_qty, $p_image, $p_desc, $id);
                                        mysqli_stmt_execute($stmt_update);
                                        header("location:tables.php?page=products");
                                    }
                                }


                            ?>
                                <form method="POST">
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
                                                 <td style="float: right;"><img <?php  
                                                                            if(!empty($p_image)){
                                                                                ?> src="<?php echo $p_image; ?>"
                                                                           <?php } else { ?>
                                                                           src="placeholder-item.webp" <?php } ?>width="80px" height="100px" id="image"><br><input type="file" name="prod_image" id="image-input"></td>
                                             </tr>
                                             <tr>
                                                 <th>PRODUCT NAME</th>
                                                 <td style="float: right;"><input type="text" name="prod_name" class="form-control" value="<?php echo $prod_name; ?>"></td>
                                             </tr>
                                             <tr>
                                                 <th>CATAGORY_fk</th>
                                                 <td style="float: right;"><input type="text" name="cat_fk" id="" class="form-control" value="<?php echo $cat_fk; ?>"></td>
                                             </tr>
                                             <tr>
                                                 <th>MRP</th>
                                                 <td style="float: right;"><input type="number" name="prod_mrp" id="" class="form-control" value="<?php echo $prod_mrp; ?>"></td>
                                             </tr>
                                             <tr>
                                                 <th>SELL PRICE</th>
                                                 <td style="float: right;"><input type="number" name="prod_price" id="" class="form-control" value="<?php echo $prod_price; ?>"></td>
                                             </tr>
                                             <tr>
                                                 <th>QTY</th>
                                                 <td style="float: right;"><input type="number" name="prod_qty" id="" class="form-control" value="<?php echo $prod_qty; ?>"></td>
                                             </tr>
                                             <tr>
                                                 <th>STATUS</th>
                                                 <td style="float: right;"><?php
                                                  if($prod_status==1){
                                                      echo "<a href='edit.php?page=products&type=active&id=$id' style='color:green;text-decoration:none'>ACTIVE</a>";
                                                  }else{
                                                    echo "<a href='edit.php?page=products&type=deactive&id=$id' style='color:red;text-decoration:none'>DEACTIVE</a>";
                                                  }
                                                  ?></td>
                                             </tr>
                                             <tr>
                                                 <th>DESCRIPTION</th>
                                                 <td style="float: right;"><textarea name="prod_desc" id="" cols="30" rows="10" class="form-control" value="<?php echo $prod_desc; ?>"></textarea></td>
                                             </tr>
                                         </tbody>
                                        </table>
                                    </div>
                                    <div class="form-group col-sm">
                                        <button class="btn btn-primary btn-block" name="sub-prod">SUBMIT</button>
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
imageInput.addEventListener("change", function(){
    let file = this.files[0];
    
    let reader = new FileReader();

    reader.onload = (e)=>image.src = e.target.result;
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