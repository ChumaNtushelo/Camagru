<?php
$error = NULL;

require "config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


if (isset($_POST['confirmed'])){
    // Process Verification
    $token =$_GET['token']; /*$_POST['token']*/;
    
    echo $token;
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $resultSet = $conn->prepare("SELECT * FROM users WHERE verified = 0 AND token = '$token' LIMIT 1");
    $resultSet->execute();
    $num_rows = Count($resultSet->fetchAll());
    if ($num_rows == 1){
        // Validate The email
        $update = $conn->prepare("UPDATE users SET verified = 1 WHERE token = '$token' and verified = 0 LIMIT 1");
        $update->execute();
        if ($update){
            echo "Your account has been verified.You may login.";
            header("location: index.php");
        } else{
            echo "Error something went wrong";
        }
    } else{
        echo "This account is invalid or already verified";
    }
}

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title> Confirm Account </title>
    </head>
        <body>

        <form method="POST" style="margin: 0cm;" >
        <div>
                <h2> Account Confirmation </h2>
                <p>Click on the button below to verify your account. </p>
                <input type="submit" name="confirmed" value="Confirm"/>
        </div>
            </form>
            <?php echo $error; ?>
        </body>
</html>