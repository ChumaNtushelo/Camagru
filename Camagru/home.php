<?php
#!/usr/bin/php

session_start();

$newemail = $_SESSION['mail'];
echo $newemail;
?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title> home page </title>
    </head>
        <body>
        <header>
            <nav>
                <div class="main-wrapper">
                    <ul>
                        <h1> Camagru </h1>
                    </ul>

                </div>
                <a href="gallery.php"> Gallery </a> |
                <a href="profile.php"> Profile </a> |
                <a href="editor.php"> Edit profile </a>   |
                <a href="logout.php" class="logout"> logout</a>
            </nav>
        </header>
        <hr>
            <h3> Welcome you have successfully logged in </h3>
            <?php if( isset($_SESSION['users_id']) ){ ?>
            <br/>
            <?php } else {} ?>

            <div class="container">
                <div class="row">
                    <div class="col-md-4 offset-md form-div login">
                        <div class="alert alertsuccess">
                    
                        </div>

                       
                    </div>
                </div>
            </div>

        </body>
</html>