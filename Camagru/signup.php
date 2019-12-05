<?php
require "config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Declare variables and initials with empty values
$email = $username = $password = $confirm_password = "";
$email_error = $username_error = $password_error = $confirm_password_error = "";
$token = "";

// Prosessing the sign up page data when the required data is entered
if($_SERVER["REQUEST_METHOD"] == "POST"){

    // VALIDATE USERNAME
    if(empty(trim($_POST["username"]))){
        $username_error = "Please enter a username.";
    } else{
        // SELECT STATEMENT
        $sql = "SELECT id FROM users WHERE username = :username";
  
        if($stmt = $conn->prepare($sql)){
            // Bind variables to be prepared statements as parameters
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);

            // set parameters
            $param_username = trim($_POST["username"]);

            // attempt to execute the prepared statement
            if($stmt->execute()){
                $result= $stmt->fetchAll();
                //$res = Count($result);
                if(Count($result) > 0 ){
                    $username_error = "The username already exists.";
                    echo $username_error;
                } else{
                    $username = trim($_POST["username"]);
                }
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // close statement
        unset($stmt);
    }

    // Validate email
   /* if(empty(trim($_POST["email"]))){
        $email_error = "Please enter your email address.";
    } elseif()*/

    // VALIDATE PASSWORD
    if(empty(trim($_POST["password"]))){
        $password_error = "Please enter a password.";
    } elseif(strlen(trim($_POST["password"])) < 6){
        $password_error = "Password must have atleast 6 characters.";
    } else{
        $password = trim($_POST["password"]);
    }

    // Validate confirm password
    if(empty(trim($_POST["confirm_password"]))){
        $confirm_password_error = "Please confirm password.";
    } else{
        $confirm_password = trim($_POST["confirm_password"]);
        if(empty($password_error) && ($password != $confirm_password)){
            $confirm_password_error = "Password did not match.";
        }
    }
    
    // check data input is incorrect before inserting it into the database
    if (empty($email_error) && empty($username_error) && empty($password_error) && empty($confirm_password_error)){
        
        // insert statement
        $sql  = "INSERT INTO Users (email, username, password, confirm_password, token) VALUES (:email, :username, :password, :confirm_password, :token)";

        if($stmt = $conn->prepare($sql)){
            // set parameters
            $param_email = $_POST['email'];
            $param_username = $username;
            $param_password = password_hash($password, PASSWORD_DEFAULT); //creates a password hash
            $param_confirm_password = password_hash($confirm_password, PASSWORD_DEFAULT);
            $param_token = password_hash($token, PASSWORD_DEFAULT);
            
            

            // Bind variables to be prepared statement as parameters
            $stmt->bindPAram(":email", $_POST["email"], PDO::PARAM_STR);
            $stmt->bindParam(":username", $param_username, PDO::PARAM_STR);
            $stmt->bindPAram(":password", $param_password, PDO::PARAM_STR);
            $stmt->bindParam(":confirm_password", $param_confirm_password, PDO::PARAM_STR);
            $stmt->bindPAram(":token", $token, PDO::PARAM_STR);
        
            
            //Attempt to execute the prepared statement
            if($stmt->execute()){
                $to = $_POST["email"];
                $subject = "VERIFY EMAIL";
                $mail = "Please click on the link below to verify your account <a href='http://localhost:8080/Camagru/confirmAcc.php?token=$token'>Verify Account</a>";
    
                $headers = "FROM CamgaruTeam";

    
                mail($to, $subject, $mail, $headers);
                // Redirect to login page
                header("location: index.php?success");
                //$message = "Account created successfully";
               // $_SESSION['message'] = "You are now looged in";
               // $_SESSION['alert-class'] = "alert-success";
            } else{
                echo "Something went wrong. Please try again later.";
            }
        }

        // close statement
        unset($stmt);
    } die($password_error);

    //close connection
    unset($conn);
}
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title> signup </title>
    </head>
        <body>
            <div class="header">
                <a href="index.php"> Camagru </a>
            </div>
                <br/>
                <hr>
            <div style="margin: 30px; padding: 20px; border: 1px solid black;">
                <form method="POST" style="margin: 0cm;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
                        <h2 style="margin: 10px;"> Sign Up </h2>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Email address <br/> <input type="email" name="email"  placeholder="Email" class="form-control" value="<?php echo $email; ?>"/>
                        </div>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Username <br/> <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>" />
                    </div>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Password <br/> <input type="password" name="password" placeholder="Password" value="" />
                    </div>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Confirm password <br/> <input type="password" name="confirm_password" placeholder="Re-enter password"/>
                    </div>
                        <br/>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Create Account" class="btn btn-primary"/>
                    </div>
                    <div>
                        Already have an account? <a href="index.php"> Login here. </a>
                    </div>
                </form>
            </div>

        </body>
</html>
