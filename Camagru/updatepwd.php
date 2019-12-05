<?php
require "config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();

$newemail = $_SESSION['mail'];
echo $newemail;

if(isset($_POST['submit'])) {
    $newpwd = $_POST['newpwd'];
    //$email = $_POST['email'];

    $newpwd = password_hash($newpwd, PASSWORD_DEFAULT);
    $sql = "UPDATE Users SET password='$newpwd' WHERE email='$newemail'";
    //$sql = "UPDATE Users SET password='".$newpwd."' WHERE email='".$newemail."'";
    $stmnt = $conn->prepare($sql);
    $stmnt->execute();
    echo "Your password has been changed";
    //header("Location: index.php");

    } else {
        echo "error";
}

?>

<!doctype html>
<html>
    <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" type="text/css" href="style.css">
            <title> Update password </title>
    </head>
        <body>
            <form action="" method="POST">
                <div>
                <div>
                    <input type="password" name="cnewpwd" placeholder="Enter new password"/>
                    </div>
                    <div>
                    <input type="password" name="newpwd" placeholder="Confirm new password"/>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="RESET PASSWORD"/>
                    </div>
                </div>
            </form>
        </body>
</html>
