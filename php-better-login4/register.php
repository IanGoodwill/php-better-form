<?php
require_once './classes.php';

// show potential errors / feedback (from registration object)
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



?><!DOCTYPE html>

<html>
    <head>
        <title> Login Page </title>
    </head>
    <body>

        <h1>Sign up for an account!</h1>

       
<form method="POST" action="index.php" name="registerform">


<label for="login_input_username">Username (only letters and numbers, 2 to 64 characters)</label>
<input id="login_input_username" class="login_input" type="text" pattern="[a-zA-Z0-9]{2,64}" name="user_name" required />

<label for="login_input_password_new">Password (min. 6 characters)</label>
<input id="login_input_password_new" class="login_input" type="password" name="user_password_new" pattern=".{6,}" required autocomplete="off" />

<input type="submit"  name="register" value="Register" />

</form>

    

    </body>

</html>