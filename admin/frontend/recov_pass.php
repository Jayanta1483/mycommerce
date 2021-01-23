<?php
require "connection.php";
if(isset($_POST['emsub'])){
    $email = mysqli_real_escape_string($connect, $_POST['email']);
    $select = "select user_id from customers where cust_email = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->bind_result($uid);
    $stmt->store_result();
    if($stmt->num_rows() > 0){
        $stmt->fetch();
        $pass = bin2hex(random_bytes(4));
        $password = password_hash($pass, PASSWORD_BCRYPT);
        $update = "UPDATE `customers` SET `password` = ? WHERE cust_email = ?";
        $stmt_update = $connect->prepare($update);
        $stmt_update->bind_param("ss", $password, $email);
        $stmt_update->execute();
        $message = "Dear,Customer your user id is :".$uid." and "."new password is :".$pass.".
        Now you can login to your account.You can change the password afterwards.";
        mail($email, "Password Recovery",$message, "nemojoy2001@gmail.com");
        echo "<script> alert('Please check your email') </script>";   
    }else{
        echo "<h2 style='color:red;text-align:center;'>Email id is not Valid!!</h2>";
    }

}


?>
<!DOCTYPE html>
<html lang="en-IN">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">

</head>
<body>
    <div class="container m-5">
    <p>Please enter the email which you have registered with us.</p>
     <div class="card shadow p-3 mb-5 bg-white rounded" style="width:18rem;">
     <div class="card-body">
     <form action="<?php  echo htmlspecialchars($_SERVER['PHP_SELF']); ?>" method="POST">
     <input type="text" name="email" id="em" placeholder="Email"></br>
     <button type="submit" name="emsub" class="btn btn-primary mt-2">SEND</button>
     </form>
     </div>
     </div>
    </div>
</body>
</html>