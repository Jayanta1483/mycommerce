<?php
require_once "connection.php";
require_once "config.php";
session_start();

// if (!empty($_SESSION['log'])) {
//     header('location:edit.php');
//     die();
// }

if (isset($_GET['code'])) {
    $token = $g_client->fetchAccessTokenWithAuthCode($_GET['code']);

    if (!isset($token['error'])) {
        $g_client->setAccessToken($token['access_token']);
        $_SESSION['access_token'] = $token['access_token'];

        $o_Auth = new Google_Service_Oauth2($g_client);
        $user_data = $o_Auth->userinfo_v2_me->get();

        $email = $user_data['email'];

        $select = "select cust_id, cust_fname from customers where cust_email = ?";
        $stmt = $connect->prepare($select);
        $stmt->bind_param('s', $email);
        $stmt->execute();
        $stmt->bind_result($id, $fn);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            while ($stmt->fetch()) {
                $_SESSION['log'] = array(
                    'fn' => $fn,
                    'id' => $id
                );
                $_SESSION['LAST_ACTIVITY'] = time();
                // echo $_SESSION['log']['fn'];
                header('location:edit.php');
                die();
            }
        } else {
            echo "<h2 style='color:red;text-align:center;'>Wrong Email Account...Please login with the email account which you have registered with this site.</h2>";
        }
    }else{
        echo "<h2 style='color:red;text-align:center;'>Token Authentication Error Occured!!</h2>";
    }
}
