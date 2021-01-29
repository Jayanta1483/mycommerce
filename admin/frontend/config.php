<?php


//Include Google Client Library for PHP autoload file
require_once "vendor/autoload.php";

//Make Object for Google Client
$g_client = new Google_Client();

$g_client->setClientId("805515508898-isht0s85asjg4neqs9egkhh8144qv7k9.apps.googleusercontent.com");
$g_client->setClientSecret("zy5kFlruPeDNpBj-oMb85rK9");
$g_client->setApplicationName("mycommerce");
$g_client->setRedirectUri("http://localhost/Jayanta/mycommerce/admin/frontend/g-callback.php");
$g_client->addScope('email');
$g_client->addScope('profile');





?>