<?php
// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
// $servername = "localhost";
// $username = "root";
// $password = "626manBM";
include ('config/database.php');
try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully(index.php)";
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

   /* if(!empty($_POST['email']) && !empty($_POST['confirm_password'])):

        $records = $conn->prepare('SELECT id,email,confirm_password FROM users WHERE email = :email');
        
        $records->bindParam(':email', $_POST['email']);
(        $records->execute();
        $results = $records->fecth(PDO::FETCH_ASSOC);

        if(count($results) > 0 && password_verify($_POST['confirm_password'], $results['confirm_password'])){

            //die('you have successfully logged in');
            $_SESSION['users_id'] = $results['id'];
            header("Location: home.php");)
        } else{
            die('error! wrong password or email');
        }

    endif;*/


    if(isset($_POST['submit'])){
        $email = $_POST['email'];
        $_SESSION['mail'] = $_POST['email'];
        $password = $_POST['password'];
        if($email == "" || $password == ""){
            echo "Please populate all fields";
        } else {
            $sql = $conn->prepare("SELECT * FROM users WHERE email ='$email'");
            //$_SESSION['id'] = $id;
            $_SESSION['email'] = $email;
            $_SESSION['password'] = $password;


            // set flash message
            $_SESSION['message'] = "You are now looged in";
            $_SESSION['alert-class'] = "alert-success";
            header("location: home.php?successfull");

            /*try{
                /*$query = $conn->prepare("SELECT * FROM users WHERE email = ? and password = ? ");
                $query->bindParam(1, $email);
                $query->bindParam(2, $password);
                $query->execute();
                
                if(!$query->rowCount()){
                    echo "Incorrect email or password";
                } else {
                  //$idArray = $query->fecth(PDO::FECTH_NUM);
                    $id = $idArray[0];
                    $idArray = $query->fetchall();

                    $_SESSION["id"] = $id;

                 echo $id;
                 //print_r($idArray);
                 //echo $idArray["0"]["id"];
                 //header("Location: home.php");
                 
                
                }
            } catch(Exception $e){
                die($e->getMessage());
            }*/
        }
    }
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title> User Login </title>
    </head>
        <body>

            <div class="header">
            <a href="index.php"> Camagru </a>
            </div>

            <?php if(!empty($message)): ?>
                <p><?php $message ?></p>
            <?php endif; ?>

            <br/>
            <hr>


            <div style="margin: 30px; padding: 20px; border: 1px solid black;">
            <form action="" method="POST" style="margin: 0cm;">
                <h2 style="margin: 10px;"> User Login </h2>
                    Email <input type="email" name="email"  placeholder="Enter your email address" />
                <br/>
                <br/>
                    Password <input type="password" name="password" placeholder="Enter your password" />
                <br/>
                <br>
                <input type="submit" name="submit" value="Login"/>
                <br/>
                <a href="resetpwd.php">forgot password</a>
                <br/>
                <br/>
                Not registered? <a href="signup.php">Create an account</a>
            </form>
            </div>
        </body>
</html>