<?php
session_start();

if (empty($_SESSION["login"])) {
    header("location:index.php");
}

require "connection.php";

if (isset($_GET["type"]) && $_GET["type"] !== "") {
    if ($_GET["type"] === "status") {
        $operation = mysqli_real_escape_string($connect, $_GET["operation"]);
        $id = mysqli_real_escape_string($connect, $_GET["id"]);
        if ($operation === "active") {
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
            $update = "UPDATE products SET prod_status = ? WHERE prod_id=?";
            $stmt = mysqli_stmt_init($connect);
            mysqli_stmt_prepare($stmt, $update);
            mysqli_stmt_bind_param($stmt, "ii", $status, $id);
            mysqli_stmt_execute($stmt);
        }
    }
}


if (isset($_GET["page"]) && $_GET["page"] !== "") {
    $page = $_GET["page"];
}
?>
<!DOCTYPE html>
<html lang="en-IN">

<head>

    <meta charset="utf-8">
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
                <a class="nav-link" href="tables.php?page=catagories">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Catagories</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php?page=products">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Products</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php?page=customers">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Customers</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php?page=orders">
                    <i class="fas fa-angle-double-right"></i>
                    <span>Orders</span>
                </a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href="tables.php?page=contacts">
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION["email"]); ?></span><span class="mr-2"><i class="fas fa-caret-down"></i></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">

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

                            <!--#################################################################################################################################################################################################################################################################################################################################
                                             FOR CATAGORIES TABLE
#####################################################################################################################################################################################################################################################################################################################################-->
                            <?php

                            if ($page === "catagories") {
                                $sql = "select * from catagories";
                                $query = mysqli_query($connect, $sql); ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>CATAGORY NAME</th>
                                                <th>STATUS</th>
                                                <th>EDIT</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($result = mysqli_fetch_array($query)) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($result["cat_name"])); ?></td>
                                                    <td><?php
                                                        if ($result["cat_status"] == 1) {
                                                            echo "<a href='?page=catagories&type=status&operation=active&id=" . htmlspecialchars($result["cat_id"]) . "' style='color:green; text-decoration:none;'>ACTIVE</a>";
                                                        } else {
                                                            echo "<a href='?page=catagories&type=status&operation=deactive&id=" . htmlspecialchars($result["cat_id"]) . "' style='color:red;text-decoration:none;'>DEACTIVE</a>";
                                                        }

                                                        ?></td>
                                                    <td><a href="edit.php?page=catagories&id=<?php echo htmlspecialchars($result["cat_id"]); ?>" style="text-decoration:none;"><i class="fas fa-edit"></i></a></td>
                                                    <td><a href="#" style="color:red;text-decoration:none;"><i class="fas fa-trash"></i></a></td>
                                                </tr>

                                            <?php  } ?>
                                        </tbody>
                                    </table>
                                </div> <?php } ?>

                            <!--################################################################################################################################################################################################################################################################################################################################
                                                                FOR PRODUCTS
####################################################################################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "products") {
                                $sql = "SELECT catagories.cat_name, products.product_id, products.prod_name, products.prod_image,products.prod_mrp,products.prod_price,products.prod_qty,products.prod_status FROM catagories RIGHT JOIN products ON catagories.cat_id = products.cat_fk ORDER BY catagories.cat_name";
                                $query = mysqli_query($connect, $sql); ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>CATAGORIES</th>
                                                <th>PRODUCTS</th>
                                                <th>IMAGE</th>
                                                <th>MRP</th>
                                                <th>PRICE</th>
                                                <th>QTY</th>
                                                <th>STATUS</th>
                                                <th>EDIT</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cat_name"])); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["prod_name"])); ?></td>
                                                    <td><img src="<?php echo htmlspecialchars($row["prod_image"]); ?>"></td>
                                                    <td><?php echo htmlspecialchars($row["prod_mrp"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["prod_price"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["prod_qty"]); ?></td>
                                                    <td><?php
                                                        if ($row["prod_status"] == 1) {
                                                            echo "<span style='color:green;'>ACTIVE</span>";
                                                        } else {
                                                            echo "<span style='color:red;'>DEACTIVE</span>";
                                                        }
                                                        ?></td>
                                                    <td><a href="edit.php?page=products&id=<?php echo htmlspecialchars($row['product_id']); ?>" style="text-decoration:none;"><i class="fas fa-edit"></i></a></td>
                                                    <td><a href="#" style="color:red;text-decoration:none;"><i class="fas fa-trash"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>

                            <!--##########################################################################################################################################################################################################################################################################################################################################
                                                                FOR CUSTOMERS
############################################################################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "customers") {
                                $sql = "select * from customers";
                                $query = mysqli_query($connect, $sql);
                            ?>


                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>CUSTOMER NAME</th>
                                                <th>ADDRESS</th>
                                                <th>EMAIL</th>
                                                <th>MOBILE</th>
                                                <th>PHOTO</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_fname"]))." ".htmlspecialchars(ucwords($row["cust_lname"])); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_address"])); ?></td>
                                                    <td><?php echo htmlspecialchars($row["cust_email"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["cust_mobile"]); ?></td>
                                                    <td><?php echo $row["photo"]; ?></td>
                                                    <td></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            <!--#############################################################################################################################################################################################################################################################
                                                                  FOR ORDER LIST
################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "orders") {

                                $sql = "SELECT customers.cust_fname, customers.cust_lname, customers.cust_email, products.prod_name, orders.order_qty, orders.order_time FROM customers JOIN products ON customers.product_fk = products.product_id JOIN orders ON customers.cust_id = orders.customers_fk";
                                $query = mysqli_query($connect, $sql);
                            ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>CUSTOMER NAME</th>
                                                <th>EMAIL</th>
                                                <th>PRODUCT(S)</th>
                                                <th>QTY</th>
                                                <th>TIME</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($query)) { ?>
                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_fname"]))." ".htmlspecialchars(ucwords($row["cust_lname"])); ?></td>
                                                    <td><?php echo htmlspecialchars($row["cust_email"]); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["prod_name"])); ?></td>
                                                    <td><?php echo htmlspecialchars($row["order_qty"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["order_time"]); ?></td>
                                                    <td><?php  ?></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            <!--#######################################################################################################################################################################################################################################################################################
                                                           FOR CONTACTS
######################################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "contacts") {

                                $sql = "SELECT customers.cust_fname, customers.cust_lname, customers.cust_email, customers.cust_mobile, contacts.comments, contacts.time FROM customers LEFT JOIN contacts ON customers.cust_id = contacts.customers_fk ORDER BY customers.cust_fname";
                                $query = mysqli_query($connect, $sql);
                            ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>CUSTOMER NAME</th>
                                                <th>EMAIL ID</th>
                                                <th>MOBILE</th>
                                                <th>COMMENTS</th>
                                                <th>TIME</th>
                                                <th>DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = mysqli_fetch_assoc($query)) {

                                            ?>

                                                <tr>
                                                    <td><?php echo $i++; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_fname"])) . " " . htmlspecialchars(ucwords($row["cust_lname"])); ?></td>
                                                    <td><a href="mailto:<?php echo htmlspecialchars($row["cust_email"]); ?>" style="text-decoration:none;" ><?php echo htmlspecialchars($row["cust_email"]) ; ?></a></td>
                                                    <td><?php echo htmlspecialchars($row["cust_mobile"]); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["comments"]));   ?></td>
                                                    <td><?php echo htmlspecialchars($row["time"]);       ?></td>
                                                    <td><a href="#" style="color:red;text-decoration:none;"><i class="fas fa-trash"></i></a></td>
                                                </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
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