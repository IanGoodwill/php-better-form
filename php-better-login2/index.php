<?php
session_start();
require_once './classes.php';
require_once './register.php';
$connection->select_db( 'w10e' );


// Sends user to admin.php if already logged in.
if(isset($_SESSION['login_user'])){
    header("location: admin.php");
    }

// Checks to see if the database is connected.
if( $connection->error )
{
    echo 'Error encountered connecting to W10b! Please review: ' . $connection->error;
    die; 
} 

if (isset($registration)) {
    if ($registration->errors) {
        foreach ($registration->errors as $error) {
            echo $error;
        }
    }
    if ($registration->messages) {
        foreach ($registration->messages as $message) {
            echo $message;
        }
    }
}

// create a login object. when this object is created, it will do all login/logout stuff automatically
// so this single line handles the entire login process. in consequence, you can simply ...
$login = new Login();

if ($login->isUserLoggedIn() == true) {
    // the user is logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are logged in" view.
    include("./admin.php");

} else {
    // the user is not logged in. you can do whatever you want here.
    // for demonstration purposes, we simply show the "you are not logged in" view.
    include("views/not_logged_in.php");
}

?>
