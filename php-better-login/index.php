<?php
session_start();
require './connection.php';

$username = $_POST['username'];
$_SESSION['login_user']= $username;
$password = $_POST['password'];
$hashed_password = password_hash($password, PASSWORD_DEFAULT);
$_SESSION['password']= $password;

if(isset($_SESSION['login_user'])){
    header("location: admin.php");
    }

$connection->select_db( 'w10e' );

if( $connection->error )
{
    echo 'Error encountered connecting to W10b! Please review: ' . $connection->error;
    die; 
} 

if(isset($_SESSION['login_user'])){
    header("location: admin.php");
    }

if ( $_POST && $_POST['submit'] )  {
    $_SESSION['logged_in'] = TRUE;
}

if ( $_POST && $_POST['logout'] ) {
    // destroy this session; the user will need to start a new one.
   session_destroy();
   unset( $_SESSION ); //Make sure the array is completely cleared.
}

$sql= 'SELECT login.password AS password WHERE login.password;';

?><!DOCTYPE html>

<html>
    <head>
        <title> Login Page </title>
    </head>
    <body>

        <h1>Login Page!</h1>

        <form action="#" method="POST">
            <label for="username"> 
                Username:
                <input type="text" placeholder= "Enter your username..."name="username" title="Enter your username!">
            </label>
            <label for="password"> 
                Password:
                <input type="password" placeholder= "Enter your password..." name="password" title="Enter your password here!">
            </label>
            <input type="submit" name ="submit" value="submit">
        </form>

    </body>

</html>

