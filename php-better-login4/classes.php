<?php

class Login
{
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct()
        {
            // create/read session, absolutely necessary
            session_start();
    
            // check the possible login actions:
            // if user tried to log out (happen when user clicks logout button)
            if (isset($_GET["logout"])) {
                $this->doLogout();
            }
            // login via post data (if user just submitted a login form)
            elseif (isset($_POST["login"])) {
                $this->dologinWithPostData();
            }
        }

    private function dologinWithPostData()
    {
        // Check login form contents.
        if (empty($_POST['user_name'])) {
            $this->errors[] = "Username field was empty.";
        } elseif (empty($_POST['user_password'])) {
            $this->errors[] = "Password field was empty.";
        } elseif (!empty($_POST['user_name']) && !empty($_POST['user_password'])) {

            // create a database connection, using the constants from config/db.php (which we loaded in index.php)
            $this->db_connection = new mysqli(
                'localhost',
                'root',
                '',
                'w10e'
            );

            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escape the POST stuff
                $user_name = $this->db_connection->real_escape_string($_POST['user_name']);

                // database query, getting all the info of the selected user (allows login via email address in the
                // username field)
                $sql = "SELECT user_name, user_password_hash
                        FROM login
                        WHERE user_name = '" . $user_name . "';";
                $result_of_login_check = $this->db_connection->query($sql);

                // if this user exists
                if ($result_of_login_check->num_rows == 1) {

                    // get result row (as an object)
                    $result_row = $result_of_login_check->fetch_object();

                    // using password_verify() function to check if the provided password fits
                    // the hash of that user's password
                    if (password_verify($_POST['user_password'], $result_row->user_password_hash)) {

                        // write user data into PHP SESSION (a file on your server)
                        $_SESSION['user_name'] = $result_row->user_name;
                        $_SESSION['user_login_status'] = 1;

                    } else {
                        $this->errors[] = "Wrong password. Try again.";
                    }
                } else {
                    $this->errors[] = "This user does not exist.";
                }
            } else {
                $this->errors[] = "Database connection problem.";
            }
        }
    }

    public function doLogout()
    {
        // delete the session of the user
        $_SESSION = array();
        session_destroy();
        // return a little feeedback message
        $this->messages[] = "You have been logged out.";

    }

    public function isUserLoggedIn()
    {
        if (isset($_SESSION['user_login_status']) AND $_SESSION['user_login_status'] == 1) {
            return true;
        }
        // default return
        return false;
    }
}

/************** NEW CLASS ************************/

class Registration
{
    private $db_connection = null;

    public $errors = array();

    public $messages = array();

    public function __construct()
    {
        if (isset($_POST["register"]))  {
            $this->registerNewUser();
        }
    }

    public function rememberNewUserName()
    {
        if (isset($_POST['user_name'], $result_row->user_name)) {
            $_SESSION['user_name'] = $result_row->user_name;
        }
    }    

    private function registerNewUsers()
    {
        if(empty($_POST['user_name']))  {
            $this->errors[] = "Empty Username";
        } elseif (empty($_POST['user_password_new']) ) {
            $this->errors[] = "Empty Password";
        }  elseif (strlen($_POST['user_password_new']) < 6) {
            $this->errors[] = "Password has a minimum length of 6 characters";
        } elseif (strlen($_POST['user_name']) > 64 || strlen($_POST['user_name']) < 2) {
            $this->errors[] = "Username cannot be shorter than 2 or longer than 64 characters";
        } elseif (!preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])) {
            $this->errors[] = "Username does not fit the name scheme: only a-Z and numbers are allowed, 2 to 64 characters";
        } elseif (!empty($_POST['username'])
            && strlen($_POST['user_name']) <= 64
            && strlen($_POST['user_name']) >= 2
            && preg_match('/^[a-z\d]{2,64}$/i', $_POST['user_name'])
            && !empty($_POST['user_password_new'])
        )  {
            $this->db_connection = new mysqli(
                'localhost',
                'root',
                '',
                'w10e'
            );
            // change character set to utf8 and check it
            if (!$this->db_connection->set_charset("utf8")) {
                $this->errors[] = $this->db_connection->error;
            }

            // if no connection errors (= working database connection)
            if (!$this->db_connection->connect_errno) {

                // escaping, additionally removing everything that could be (html/javascript-) code
                $user_name = $this->db_connection->real_escape_string(strip_tags($_POST['user_name'], ENT_QUOTES));

                $user_password = $_POST['user_password_new'];

                // crypt the users password with password_hash function.
                $user_password_hash = password_hash($user_password, PASSWORD_DEFAULT);

                // checks to see if user already exists
                $sql = "SELECT * FROM users WHERE user_name =  " . $user_name;  
                $query_check_user_name = $this->db_connection->query($sql);

                if ($query_check_user_name->num_rows == 1) {
                    $this->errors[] = "Sorry, that username / email address is already taken.";
                } else {
                    // write new user's data into database
                    $sql = "INSERT INTO login (user_name, user_password_hash,)
                            VALUES('" . $user_name . "', '" . $user_password_hash . "');";  // correct syntax?
                    $query_new_user_insert = $this->db_connection->query($sql);

                    // if user has been added successfully                                                         USER IS NOT BEING ADDED.
                    if ($query_new_user_insert) {
                        $this->messages[] = "Your account has been created successfully. You can now log in.";
                    } else {
                        $this->errors[] = "Sorry, your registration failed. Please go back and try again.";
                    }
                }
            } else {
                $this->errors[] = "Sorry, no database connection.";
            }
        } else {
            $this->errors[] = "An unknown error occurred.";
        }
    }
}
