<?php
session_start();
require './classes.php';
$connection->select_db( 'w10e' );



if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
    echo "Username or Password is invalid";
    }
}

if (isset($_POST['submit'])) {
    if (empty($_POST['username']) || empty($_POST['password'])) {
    echo "Username or Password is invalid";
    }
}

$sql = 'SELECT password FROM login WHERE username = ' . $_SESSION['login_user'];
    if( $result = $connection->query( $sql ) )
    {
        var_dump( $result );// ???
    }


?><!DOCTYPE html>

<html>
    <head>
        <title> A better way to login! </title>
    </head>
    <body>
        <h1>
            <?php
                if ( isset($_SESSION['login_user'])) {

                echo "Welcome " .  $_SESSION['login_user'] . "! ";
                }
            ?>
        </h1>

       


        <form action= "./index.php" method="POST">

            <input type="submit" name="logout" value="Logout!">

        </form>

    </body>

</html>