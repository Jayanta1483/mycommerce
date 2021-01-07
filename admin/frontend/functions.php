<?php
session_start();

function csrf_token(){
    $token = bin2hex(random_bytes(32));
    //$csrf = hash_hmac("sha256", "this is some string", $_SESSION['key']);
    $_SESSION['key'] = $token;
    return $token;
}


?>