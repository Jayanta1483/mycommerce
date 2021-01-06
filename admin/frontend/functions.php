<?php
function login_validate($connect, $id, $password){
    $select = "select password from customers where user_id = ?";
    $stmt = $connect->prepare($select);
    $stmt->bind_param('s', $id);
    $stmt->execute();
    $stmt->bind_result($pass);
    $stmt->store_result();
    if($stmt->num_rows > 0){
        if(!password_verify($password, $pass)){
            echo "Invalid Password....Please try again";
        }else{
            echo "valid";
        }
    }else{
        echo "Invalid UserID...Please try again";
    }
}


?>