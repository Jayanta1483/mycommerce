<?php
session_start();
require "connection.php";

if(isset($_GET["page"]) && $_GET["page"]!== ""){
    $page = mysqli_real_escape_string($connect, $_GET["page"]);
    $id = mysqli_real_escape_string($connect, $_GET["id"]);
   }

//#########################################################################################################################################################################################################
//                                            CATAGORIES
//#########################################################################################################################################################################################################
  if($page === "catagories"){
    $delete = "DELETE FROM catagories WHERE cat_id = ?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt, $delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        mysqli_stmt_bind_param($stmt,"i", $id);
        mysqli_stmt_execute($stmt);
        header("location:tables.php?page=catagories");
    }
  }

  //#########################################################################################################################################################################################################
  //                                          PRODUCTS
  //#########################################################################################################################################################################################################

  if($page === "products"){
    $delete = "DELETE FROM products WHERE product_id = ?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt, $delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        mysqli_stmt_bind_param($stmt,"i", $id);
        mysqli_stmt_execute($stmt);
        header("location:tables.php?page=products");
    }
  }

//#########################################################################################################################################################################################################
//                                          CUSTOMERS
//#########################################################################################################################################################################################################

  if($page === "customers"){
    $delete = "DELETE FROM customers WHERE cust_id = ?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt, $delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        mysqli_stmt_bind_param($stmt,"i", $id);
        mysqli_stmt_execute($stmt);
        header("location:tables.php?page=customers");
    }
  }

//#########################################################################################################################################################################################################
  //                                          PRODUCTS
  //#########################################################################################################################################################################################################

  if($page === "products"){
    $delete = "DELETE FROM products WHERE product_id = ?";
    $stmt = mysqli_stmt_init($connect);
    if(!mysqli_stmt_prepare($stmt, $delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        mysqli_stmt_bind_param($stmt,"i", $id);
        mysqli_stmt_execute($stmt);
        header("location:tables.php?page=products");
    }
  }









?>