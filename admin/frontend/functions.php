<?php
session_start();
session_regenerate_id(true);

function csrf_token(){
    $token = bin2hex(random_bytes(32));
    //$csrf = hash_hmac("sha256", "this is some string", $_SESSION['key']);
    $_SESSION['key'] = $token;
    return $token;
}

function auto_session(){
    if(isset($_SESSION['LAST_ACTIVITY'])){
        if((time() - $_SESSION['LAST_ACTIVITY']) > 1200){
            session_destroy();
            echo "logout";
        }
    }
}
 auto_session();

?>