<?php
session_start();
require './classes.php';




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


?><!DOCTYPE html>

<html>
    <head>
        <title> A better way to login! </title>
    </head>
    <body>
        <h1>
            <?php
                if ( isset($_SESSION['user_name'])) {

                echo "Welcome " .  $_SESSION['user_name'] . "! ";
                }
            ?>
        </h1>

       


        <form action= "./not_logged_in.php" method="POST">

            <input type="submit" name="logout" value="Logout!">

        </form>

    </body>

</html>