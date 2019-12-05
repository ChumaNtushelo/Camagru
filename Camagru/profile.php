<?php

include ('config/database.php');

session_start();

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$newemail = $_SESSION['mail'];
echo $newemail;


?>

<!DOCTYPE html>
<html>
    <head>
        <title></title>
        <link rel="stylesheet" type="text/css" href="style.css">
    </head>
    <body>
    <header>
            <nav>
                <div class="main-wrapper">
                    <ul>
                        <h1> Camagru </h1>
                    </ul>

                </div>
                <a href="home.php"> Home </a> |
                <a href="gallery.php"> Gallery </a> |

                <a href="editor.php"> Edit profile </a>   |
                <a href="logout.php" class="logout"> logout</a>
            </nav>
        </header>
        <hr>
        <div>
            <div>
                <form action="profile.php" method="POST" enctype="multipart/form-data">
                    <h3> My Timeline </h3>
                <br>
                    <input type="submit" name="next" value="Previous" />
                    IMAGES
                    <input type="submit" name="previous" value="Next" />

                <hr>
                    
                </form>
            </div>

            <div>

            </div>
    </body>
</html>