<?php
// Start php session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
 
//The config file is where the DB connection is generated 
//we are using require_once instead of require because we want to inser the code only once
require_once "dbConfig.php";
 
// variables for username and password, all defined in one row
$username = $password = "";
//variables for username and password error, all defined in one row
$username_err = $password_err = "";
//variable to confirm there is no login error
$login_err = "";

 
//making sure the request has been done only via $_POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // check that username is not empty and trim() removes whitespae and other chars from sides of a string
    if(empty(trim($_POST["username"]))){
        $username_err = "Missing username.";
    } else{
        $username = trim($_POST["username"]); //save username
    }
    
    //same as above, checks for empty field on password and removes whitespae and other chars from sides of a string
    if(empty(trim($_POST["password"]))){
        $password_err = "Missing password.";
    } else{
        $password = trim($_POST["password"]); //save password
    }
    
    // Making sure both errors for username, password and password confirm are empty
    //if not empty, the statement will not execute and we will echo an error
    if(empty($username_err) && empty($password_err)){
        // Prepare the select query to grab user ID, username and password columns
        // that equals the username attempting to login
        $sql = "SELECT id, username, password FROM users WHERE username = ?";
        
        //only run if the prepared statement returns true and there is no SQL syntax errors
        if($stmt = $db->prepare($sql)){
            // Bind variable string "s" to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = $username;
            
            // Execute the prepared query in bin_param, fail if return false and echo something is wrong
            if($stmt->execute()){
                // we transfer the result set from the last query (store our result)
                $stmt->store_result();
                
                // Check if username exists, if it does then verify password
                //The select query must return number of rows equal to 1. 
                //Otherwise, the username DOES NOT exist in the "users" table
                if($stmt->num_rows == 1){                    
                    // Bind result because we are interested in the output from and not the query
                    $stmt->bind_result($id, $username, $hashed_password);

                    if($stmt->fetch()){
                        //as instructed, WE USE password_verify() to check a password securely
                        //password_verify() verifies that the password matches a hash
                        if(password_verify($password, $hashed_password)){
                            // Password is correct, so start a new session
                            session_start();
                            
                            // Store data in session variables
                            $_SESSION["loggedin"] = true;
                            $_SESSION["id"] = $id;
                            $_SESSION["username"] = $username;                            
                            
                            // Redirect user to welcome page
                            header("location: index.php");
                        } else{
                            // Password is not valid, display a generic error message
                            $login_err = "Invalid username or password.";
                        }
                    }
                } else{
                    // Username doesn't exist, display a generic error message
                    $login_err = "Invalid username or password.";
                }
            } else{
                //we do not display any SQL errors for the user, only a message
                echo "There was a hiccup processing your data. Try again please.";
            }

            // Close query that fetched data from DB
            $stmt->close();
        } else {
            echo "Could not prepare the QUERY. There could be syntax errors.";
        }

    } else {
        //we do not display any SQL errors for the user, only a message
        echo "Sorry, your data was not created. Try again please.";
    }
    
    // Close query that connected database
    $db->close();
}
?>
 
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Login</h2>
        <p>Please fill in your credentials to login.</p>

        <?php 
        if(!empty($login_err)){
            echo '<div class="alert alert-danger">' . $login_err . '</div>';
        }        
        ?>

        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Login">
            </div>
            <p>Don't have an account? <a href="register.php">Sign up now</a>.</p>
            <p>Want to checkout our calendar? <a href="notLoggedIn.php">view our calendar now</a>.</p>
        </form>
    </div>
</body>
</html>