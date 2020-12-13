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
    
    if(!$stmt = $connect->prepare($delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("location:tables.php?page=catagories");
    }
  }

  //#########################################################################################################################################################################################################
  //                                          PRODUCTS
  //#########################################################################################################################################################################################################

  if($page === "products"){
    $delete = "DELETE FROM products WHERE product_id = ?";
    
    if(!$stmt = $connect->prepare($delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("location:tables.php?page=products");
    }
  }

//#########################################################################################################################################################################################################
//                                          CUSTOMERS
//#########################################################################################################################################################################################################

  if($page === "customers"){
    $delete = "DELETE FROM customers WHERE cust_id = ?";
    
    if(!$stmt = $connect->prepare($delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("location:tables.php?page=customers");
    }
  }

//#########################################################################################################################################################################################################
  //                                          ORDERS
  //#########################################################################################################################################################################################################

  if($page === "orders"){
    $delete = "DELETE FROM orders WHERE order_id = ?";
    
    if(!$stmt = $connect->prepare($delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("location:tables.php?page=orders");
    }
  }


//#########################################################################################################################################################################################################
//                                          CONTACTS
//#########################################################################################################################################################################################################

  if($page === "contacts"){
    $delete = "DELETE FROM contacts WHERE contact_id = ?";
    
    if(!$stmt = $connect->prepare($delete)){
        echo "<div style='color:red'>SQL Error Occured!!</div>";
    }else{
        $stmt->bind_param("i", $id);
        $stmt->execute();
        header("location:tables.php?page=contacts");
    }
  }
