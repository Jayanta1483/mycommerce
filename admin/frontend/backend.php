<?php
require "connection.php";

if(isset($_POST['op']) && $_POST['op'] == 'insert'){
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $mobile = $_POST['mobile'];
    $user_id = $_POST['logid'];
    $pwd = password_hash($_POST['pwd'], PASSWORD_BCRYPT);
    $address = $_POST['adr'];

if(isset($_FILES['file']) && $_FILES['file'] !== ""){
    $photo = $_FILES['file'];
    $file_name = $photo['name'];
}else{
    $file_name = "customer_avatar.jpg";
}

  $insert = "INSERT INTO `customers`( `cust_fname`, `cust_lname`, `cust_address`, `cust_email`, `cust_mobile`, `user_id`, `password`, `photo`) VALUES (?,?,?,?,?,?,?,?)";  
  $stmt = $connect->prepare($insert);
  $stmt->bind_param("ssssisss",$fname, $lname, $address, $email, $mobile, $user_id, $pwd, $file_name);
  ($stmt->execute()) ? $execute = true : $execute = false;

  if($execute){
      $last_id = $connect->insert_id;
      $select = "select cust_fname from customers where cust_id = ?";
      $sel_stmt = $connect->prepare($select);
      $sel_stmt->bind_param("i",$last_id);
      $sel_stmt->execute();
      $sel_stmt->bind_result($fn);
      while($sel_stmt->fetch()){
          echo json_encode($fn);
      }
  }

}else{
    echo "error";
}
?>