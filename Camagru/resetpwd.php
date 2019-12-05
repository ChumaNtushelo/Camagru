<?php

include ('config/database.php');

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$errors = array();
// form validation
if(isset($_POST['submit'])) {


    $username = isset($_POST['username']) ? $_POST['username'] : null;
    $email = isset($_POST['email']) ? $_POST['email'] : null;
   // $extraInfo = isset($_POST['extra_info']) ? $_POST['extra_info'] : null;

    echo "An email has been sent to your address";

    // check empty fields
    if(strlen(trim($username)) === 0) {
        $errors[] = "Enter username";
    }

    // a valid email address
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Not a valid email address";
    }

    // if there are no errors continue.
    // if(empty($errors)) {
        
    // }

    // // connect to database
    // $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    // $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully(index.php)";

    $pdo = $conn;
    
    // get name searched for CHANGE NAME
    // $username = isset($_POST['username']) ? trim($_POST['username']) : '';
    $email = isset($_POST['email']) ? trim($_POST['email']) : '';
    //  $extraInfo = isset($_POST['extra_info']) ? trim($_POST['extra_info']) : '';
    
    $sql = "SELECT * FROM Users WHERE email = '$email' ";
    //("SELECT * FROM users WHERE email = ? and password = ? ");
    $stmnt = $pdo->prepare($sql);
    
    // $pdo->bindParam(':email', $email);
    // $stmnt->bindPAram(":email", $email, PDO::PARAM_STR);
    $stmnt->execute();
    
    // fetch results as associative array
    $userInfo = $stmnt->fetch(PDO::FETCH_ASSOC);
    
    

    // if user empty : email not found in Users table
    // echo "Connected chuma(index.php)";
    if(!empty($userInfo)) {
        
        
        // user email and id
        $userEmail = $userInfo['email'];
        $userId = $userInfo['id'];
       
        echo $userId;
        //creating token
        $token = password_hash($username, PASSWORD_DEFAULT);
        
        // insert into table_change 
        $insertsql = "INSERT INTO password_reset_request (user_id, token) VALUES ('$userId', '$token')";
        
        // prepare and execute
      
        $stmnt = $pdo->prepare($insertsql);
        $stmnt->execute();
        
        // get the ID of the row just inserted
        // $passwordRequestedId = $pdo->lastInsertId();
        
        //  // link to URL forgot password reset
        // $verifyScript = "http://localhost:8080/Camagru/newpwd.php?$token";
            
            // // link to send to user via email
            // $linkToSend = $verifyScript . 'uid=' . $userId . '&id=' . $passwordRequestedId . '&t=' . $token;
            
            // print email
            // echo $linkToSend;
            
            
            //Attempt to execute the prepared statement
            // if($stmnt->execute()){
                $to = $_POST["email"];
                $subject = "RESET PASSWORD";
                $mail = "Please click on the link below to reset your password <a href='http://localhost:8080/Camagru/newpwd.php?token=$token'>Reset Password</a>";
                
                $headers = "FROM CamgaruTeam";
                
                
                mail($to, $subject, $mail, $headers);
                echo "The email does not exits or wrong email";
                // Redirect to login page
                //0header("location: index.php?success");
                //$message = "Account created successfully";
                // $_SESSION['message'] = "You are now looged in";
                // $_SESSION['alert-class'] = "alert-success";
                // } else{
                    //     echo "Something went wrong. Please try again later.";
                    // }
                }
}
?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Reset password </title>
    </head>
        <body>
            <form action="resetpwd.php" method="POST">
                <div>
                    <div>
                        <h3>Reset your password.</h3>
                        <p> An email will be sent you with instructions. </p>
                    </div>
                    <div>
                        <input type="text" name="name" placeholder="Enter your username"/>
                    </div>
                    <div>
                        <input type="text" name="email" placeholder="Enter your email address"/>
                    </div>
                    <div>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="Reset password"/>
                    </div>
                    <div>
                       Remembered password: Back to <a href="index.php">  Login </a>
                    </div>
                </div>
            </form>
        </body>
</html>