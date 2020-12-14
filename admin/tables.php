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
            $stmt = $connect->prepare($update);
            $stmt->bind_param ("ii", $status, $id);
            $stmt->execute();
        }

        if ($_GET["page"] === "products") {
            $update = "UPDATE products SET prod_status = ? WHERE prod_id=?";
            $stmt = $connect->prepare($update);
            $stmt->bind_param("ii", $status, $id);
            $stmt->execute();
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
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?php echo htmlspecialchars($_SESSION["email"]); ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg"><span><i class="fas fa-caret-down mx-2"></i></span>

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
                            <h6 class="m-0 font-weight-bold text-primary" style="display: inline;"><?php echo htmlspecialchars(ucwords($page)); ?></h6>
                            <?php
                            if ($page === "catagories") { ?>
                                <h6 class="m-0 font-weight-bold text-primary" style="display: inline;float:right;"><a href="add.php?page=<?php echo htmlspecialchars($page)  ?>" style="text-decoration:none;">+ADD</a></h6>
                            <?php } else if ($page === "products") { ?>
                                <h6 class="m-0 font-weight-bold text-primary" style="display: inline;float:right;"><a href="add.php?page=<?php echo htmlspecialchars($page)  ?>" style="text-decoration:none;">+ADD</a></h6>

                            <?php   }   ?>
                        </div>
                        <div class="card-body">

                            <!--#################################################################################################################################################################################################################################################################################################################################
                                             FOR CATAGORIES TABLE
#####################################################################################################################################################################################################################################################################################################################################-->
                            <?php

                            if ($page === "catagories") {
                                $sql = "select * from catagories";
                                $query = $connect->query($sql); ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">CATAGORY NAME</th>
                                                <th class="text-center">STATUS</th>
                                                <th class="text-center">EDIT</th>
                                                <th class="text-center">DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($result = $query->fetch_array()) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars(ucwords($result["cat_name"])); ?></td>
                                                    <td class="text-center"><?php
                                                                            if ($result["cat_status"] == 1) {
                                                                                echo "<span style='color:green;'>ACTIVE</span>";
                                                                            } else {
                                                                                echo "<span style='color:red;'>DEACTIVE</span>";
                                                                            }

                                                                            ?></td>
                                                    <td class="text-center"><a href="edit.php?page=catagories&id=<?php echo htmlspecialchars($result["cat_id"]); ?>" target="_blank" style="text-decoration:none;"><i class="fas fa-edit"></i></a></td>
                                                    <td class="text-center"><button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo htmlspecialchars($i); ?>" style="border:none;color:red;"><i class='fas fa-trash-alt'></i></button></td>
                                                </tr>

                                                <!-- Delete Modal-->
                                                <div class="modal fade" id="exampleModal-<?php echo htmlspecialchars($i); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete This Data?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-danger"><a href="delete.php?page=catagories&id=<?php echo htmlspecialchars($result['cat_id']); ?>" style="text-decoration:none;color:white;">Yes</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                            <?php $i++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>


                            <?php } ?>

                            <!--################################################################################################################################################################################################################################################################################################################################
                                                                FOR PRODUCTS
####################################################################################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "products") {
                                $sql = "SELECT catagories.cat_name, products.product_id, products.prod_name, products.prod_image, products.prod_desc, products.prod_mrp,products.prod_price,products.prod_qty,products.prod_status FROM catagories RIGHT JOIN products ON catagories.cat_id = products.cat_fk ORDER BY catagories.cat_name";
                                $query = $connect->query($sql); ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr>
                                                <th class="text-center">#</th>
                                                <th class="text-center">CATAGORIES</th>
                                                <th class="text-center">PRODUCTS</th>
                                                <th class="text-center">IMAGE</th>
                                                <th class="text-center">MRP</th>
                                                <th class="text-center">PRICE</th>
                                                <th class="text-center">QTY</th>
                                                <th class="text-center">STATUS</th>
                                                <th class="text-center">DESCRIPTION</th>
                                                <th class="text-center">EDIT</th>
                                                <th class="text-center">DELETE</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $i = 1;
                                            while ($row = $query->fetch_assoc()) { ?>
                                                <tr>
                                                    <td class="text-center"><?php echo $i; ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars(ucwords($row["cat_name"])); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars(ucwords($row["prod_name"])); ?></td>
                                                    <td><img <?php
                                                                if (empty($row["prod_image"])) { ?> src="placeholder-item.webp" <?php  } else {  ?> src="<?php echo $row["prod_image"]; ?>" <?php } ?> width="80px" height="100px"></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row["prod_mrp"]); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row["prod_price"]); ?></td>
                                                    <td class="text-center"><?php echo htmlspecialchars($row["prod_qty"]); ?></td>
                                                    <td class="text-center"><?php
                                                                            if ($row["prod_status"] == 1) {
                                                                                echo "<span style='color:green;'>ACTIVE</span>";
                                                                            } else {
                                                                                echo "<span style='color:red;'>DEACTIVE</span>";
                                                                            }
                                                                            ?></td>
                                                    <td>
                                                        <div style="border:none;"><?php echo htmlspecialchars(ucwords($row["prod_desc"])); ?></div>
                                                    </td>
                                                    <td class="text-center"><a href="edit.php?page=products&id=<?php echo htmlspecialchars($row['product_id']); ?>" target="_blank" style="text-decoration:none;"><i class="fas fa-edit"></i></a></td>
                                                    <td class="text-center"><button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo htmlspecialchars($i); ?>" style="border:none;color:red;"><i class='fas fa-trash-alt'></i></button></td>
                                                </tr>

                                                <!-- Delete Modal-->
                                                <div class="modal fade" id="exampleModal-<?php echo htmlspecialchars($i); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete This Data?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-danger"><a href="delete.php?page=products&id=<?php echo htmlspecialchars($row['product_id']); ?>" style="text-decoration:none;color:white;">Yes</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $i++;
                                            } ?>
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
                                $query = $connect->query($sql);
                            ?>


                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
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
                                            while ($row = $query->fetch_assoc()) { ?>
                                                <tr class="text-center">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_fname"])) . " " . htmlspecialchars(ucwords($row["cust_lname"])); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_address"])); ?></td>
                                                    <td><?php echo htmlspecialchars($row["cust_email"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["cust_mobile"]); ?></td>
                                                    <td><img <?php
                                                                if (empty($row["photo"])) { ?> src="customer_avatar.jpg" <?php  } else {  ?> src="<?php echo $row["photo"]; ?>" <?php } ?> width="80px" height="100px"></td>
                                                    <td><button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo htmlspecialchars($i); ?>" style="border:none;color:red;"><i class='fas fa-trash-alt'></i></button></td>
                                                </tr>

                                                <!-- Delete Modal-->
                                                <div class="modal fade" id="exampleModal-<?php echo htmlspecialchars($i); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete This Data?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-danger"><a href="delete.php?page=customers&id=<?php echo htmlspecialchars($row['cust_id']); ?>" style="text-decoration:none;color:white;">Yes</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $i++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            <!--#############################################################################################################################################################################################################################################################
                                                                  FOR ORDER LIST
################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "orders") {

                                $sql = "SELECT customers.cust_fname, customers.cust_lname, customers.cust_email, products.prod_name, orders.order_id, orders.order_qty, orders.order_time FROM customers JOIN orders ON orders.customers_fk = customers.cust_id JOIN products ON products.product_id = orders.product_fk";
                                $query = $connect->query($sql);
                            ?>

                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
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
                                            while ($row = $query->fetch_assoc()) { ?>
                                                <tr class="text-center">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_fname"])) . " " . htmlspecialchars(ucwords($row["cust_lname"])); ?></td>
                                                    <td><?php echo htmlspecialchars($row["cust_email"]); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["prod_name"])); ?></td>
                                                    <td><?php echo htmlspecialchars($row["order_qty"]); ?></td>
                                                    <td><?php echo htmlspecialchars($row["order_time"]); ?></td>
                                                    <td><button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo htmlspecialchars($i); ?>" style="border:none;color:red;"><i class='fas fa-trash-alt'></i></button></td>
                                                </tr>

                                                <!-- Delete Modal-->
                                                <div class="modal fade" id="exampleModal-<?php echo htmlspecialchars($i); ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete This Data?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-danger"><a href="delete.php?page=orders&id=<?php echo htmlspecialchars($row['order_id']); ?>" style="text-decoration:none;color:white;">Yes</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $i++;
                                            } ?>
                                        </tbody>
                                    </table>
                                </div>
                            <?php } ?>
                            <!--#######################################################################################################################################################################################################################################################################################
                                                           FOR CONTACTS
######################################################################################################################################################################################################################################################################################-->
                            <?php
                            if ($page === "contacts") {

                                $sql = "SELECT customers.cust_fname, customers.cust_lname, customers.cust_email, customers.cust_mobile, contacts.contact_id, contacts.comments, contacts.time FROM customers JOIN contacts ON customers.cust_id = contacts.customers_fk ORDER BY customers.cust_fname";
                                $query = $connect->query($sql);
                            ?>
                                <div class="table-responsive">
                                    <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                                        <thead>
                                            <tr class="text-center">
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
                                            while ($row = $query->fetch_assoc()) {

                                            ?>

                                                <tr class="text-center">
                                                    <td><?php echo $i; ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["cust_fname"])) . " " . htmlspecialchars(ucwords($row["cust_lname"])); ?></td>
                                                    <td><a href="mailto:<?php echo htmlspecialchars($row["cust_email"]); ?>" style="text-decoration:none;"><?php echo htmlspecialchars($row["cust_email"]); ?></a></td>
                                                    <td><?php echo htmlspecialchars($row["cust_mobile"]); ?></td>
                                                    <td><?php echo htmlspecialchars(ucwords($row["comments"]));   ?></td>
                                                    <td><?php echo htmlspecialchars($row["time"]);       ?></td>
                                                    <td><button type="button" class="btn" data-toggle="modal" data-target="#exampleModal-<?php echo $i; ?>" style="border:none;color:red;"><i class='fas fa-trash-alt'></i></button></td>
                                                </tr>
                                                <!-- Delete Modal-->
                                                <div class="modal fade" id="exampleModal-<?php echo $i; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                                    <div class="modal-dialog" role="document">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title" id="exampleModalLabel">Delete This Data?</h5>
                                                                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                                    <span aria-hidden="true">&times;</span>
                                                                </button>
                                                            </div>

                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                                                                <button type="button" class="btn btn-danger"><a href="delete.php?page=contacts&id=<?php echo $row["contact_id"]; ?>" style="text-decoration:none;color:white;">Yes</a></button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            <?php $i++;
                                            } $connect->close();?>
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