<?php
// Start php session
session_start();
 
// Check if the user is already logged in, if yes then redirect him to welcome page
if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
    header("location: index.php");
    exit;
}
//The config file is where the DB connection to SimpleNewsWebSite is generated 
//we are using require_once instead of require because we want to insert the code only once
require_once "dbConfig.php";
 
// variables for username and password, all defined in one row
$username = $password = "";
//variable that will confirm password
$confirm_password = "";
//variables for username and password error, all defined in one row
$username_err = $password_err = "";
//variable to confirm there is no password error
$confirm_password_err = "";
 

//making sure the request has been done only via $_POST
if($_SERVER["REQUEST_METHOD"] == "POST"){
 
    // check that username is not empty and trim() removes whitespae and other chars from sides of a string
    if(empty(trim($_POST["username"]))){
        $username_err = "You did not enter a username.";
    } elseif(!preg_match('/^[a-zA-Z0-9_]+$/', trim($_POST["username"]))){
        //regex expression that checks for lowercase, uppercase, numbers and underscores 
        $username_err = "Username can only contain letters, numbers, and underscores.";
    } else{ 
        // Prepare the select query to grab user ID that equals the username registering
        $sql = "SELECT id FROM users WHERE username = ?";
        
        //only run if the prepared statement returns true and there is no SQL syntax errors
        if($stmt = $db->prepare($sql)){
            // Bind string "s" to the prepared statement as parameters
            $stmt->bind_param("s", $param_username);
            
            // Set parameters
            $param_username = trim($_POST["username"]);
            
            // Execute the prepared query in bin_param, fail if return false and echo something is wrong
            if($stmt->execute()){
                // we transfer the result set from the last query (store our result)
                $stmt->store_result();
                //The select query must return number of rows zero. 
                //Otherwise, the username already exists in the "users" table
                if($stmt->num_rows == 1){
                    $username_err = "Sorry, the username selected is already taken.";
                } else{
                    $username = trim($_POST["username"]); //save username
                }
            } else{
                //we do not display any SQL errors for the user, only a message
                echo "There was a hiccup processing your data. Try again please.";
            }

            // Closing query that selected the data
            $stmt->close();
        }
    }
    
    // Password validation
    //same as above, checks for empty field and removes whitespae and other chars from sides of a string
    if(empty(trim($_POST["password"]))){
        $password_err = "You did not enter a password.";     
    } elseif(strlen(trim($_POST["password"])) < 8){
        //for robustness, we set the password to have at least 8 characters
        $password_err = "Password must have atleast 8 characters.";
    } else{
        $password = trim($_POST["password"]); //save password
    }
    
    // Making sure the both password and password validation matches
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_err = "You did not confirm your password.";     
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        //Make sure there are no password errors recorded from above
        // AND that password and confirm password values are the same
        if(empty($password_err) && ($password != $confirm_password)){
            $confirm_password_err = "Password did not match.";
        }
    }
    
    // Making sure both errors for username, password and password confirm are empty
    //if not empty, the statement will not execute and we will echo an error
    if(empty($username_err) && empty($password_err) && empty($confirm_password_err)){
        
        // Prepare an insert statement that stores the username and password into the users table
        $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
         
        if($stmt = $db->prepare($sql)){
            // Bind username and password variables to the prepared statement as parameters
            $stmt->bind_param("ss", $param_username, $param_password);
            
            // Save password and username into the parameters variables
            $param_username = $username;
            //per course security practices, we use password_hash to create a password hash
            //the original password string will not be saved to the database
            //the password_hash() also generates and applies random salt automatically
            $param_password = password_hash($password, PASSWORD_DEFAULT);
            
            // Execute the prepared query in bind_param, only if it returns true
            if($stmt->execute()){
                // Redirect to login page
                header("location: login.php");
            } else{
                //we do not display any SQL errors for the user, only a message
                echo "Oops! Something went wrong. Please try again later.";
            }

            // Close query that wrote data into BD
            $stmt->close();
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
    <title>Sign Up</title>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <style>
        body{ font: 14px sans-serif; }
        .wrapper{ width: 360px; padding: 20px; }
    </style>
</head>
<body>
    <div class="wrapper">
        <h2>Sign Up</h2>
        <p>Please fill this form to create an account.</p>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" class="form-control <?php echo (!empty($username_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $username; ?>">
                <span class="invalid-feedback"><?php echo $username_err; ?></span>
            </div>    
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" class="form-control <?php echo (!empty($password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $password; ?>">
                <span class="invalid-feedback"><?php echo $password_err; ?></span>
            </div>
            <div class="form-group">
                <label>Confirm Password</label>
                <input type="password" name="confirm_password" class="form-control <?php echo (!empty($confirm_password_err)) ? 'is-invalid' : ''; ?>" value="<?php echo $confirm_password; ?>">
                <span class="invalid-feedback"><?php echo $confirm_password_err; ?></span>
            </div>
            <div class="form-group">
                <input type="submit" class="btn btn-primary" value="Submit">
                <input type="reset" class="btn btn-secondary ml-2" value="Reset">
            </div>
            <p>Already have an account? <a href="login.php">Login here</a>.</p>
        </form>
    </div>    
</body>
</html>