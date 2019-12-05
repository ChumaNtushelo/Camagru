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
    $newname = $_POST['newname'];
    //$email = $_POST['email'];

    $sql = "UPDATE Users SET username='".$newname."' WHERE email='".$newemail."'";
    $stmnt = $conn->prepare($sql);
    $stmnt->execute();
    header("Location: editor.php");
    echo "Your name has been changed";

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
            <title> Update username </title>
    </head>
        <body>
            <form action="" method="POST">
                <div>
                <div>
                    <input type="password" name="newname" placeholder="Enter new username"/>
                    </div>
                    <div>
                        <input type="submit" name="submit" value="UPDATE USERNAME"/>
                    </div>
                </div>
            </form>
        </body>
</html>

