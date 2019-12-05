<?php

include ('config/database.php');

session_start();

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$newemail = $_SESSION['mail'];
echo $newemail;

if(isset($_POST['submit'])) {
    $file = $_FILES['file'];

    $fileName = $_FILES['file']['name'];
    $fileTmpName = $_FILES['file']['tmp_name'];
    $fileSize = $_FILES['file']['size'];
    $fileError = $_FILES['file']['error'];
    $fileType = $_FILES['file']['type'];

    $fileExt = explode('.', $fileName);
    $fileActualExt = strtolower(end($fileExt));

    $allowed = array('jpg', 'jpeg', 'png', 'gif');

    if(in_array($fileActualExt, $allowed)) {
        if($fileError === 0) {
            if($fileSize < 1000000) {
                $fileNameNew = uniqid('', true).".".$fileActualExt;
                $fileDestination = 'uploads/'.$fileNameNew;
                echo "xaba";
                echo $fileNameNew;
                move_uploaded_file($fileTmpName, $fileDestination);
                // insert statement
                $sql  = "INSERT INTO gallery (imagename) VALUES ('$fileNameNew')";
                $stmt = $conn->prepare($sql);
                $stmt->execute();
                //header("Location: editor.php?success");
            } else {
                echo "File too big";
            }
        } else {
            echo "Error uploading";
        }
    } else {
        echo "Invalid file type";
    }
}

// if (move_uploaded_file($fileTmpName, $fileDestination)) {
//     // insert statement
//     $sql  = "INSERT INTO gallery (id, imagename, user_id, date_uploaded) VALUES (:id, :imagename, :user_id, :date_uploaded)";
//     $stmt = $conn->prepare($sql);
//     $stmt->execute($sql);
// }


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
                <a href="profile.php"> Profile </a> |
                <a href="logout.php" class="logout"> logout</a>
            </nav>
        </header>
            <hr>
            <div>
                        <div>
                            <a href="updateusername.php">Change Username</a> | 
                            <a href="newpwd.php">Update Password</a>
                        </div>
                        <hr>
                <div>
                
                    <form action="" method="POST" enctype="multipart/form-data">
                        Select a file to upload.
                        <br>
                        <input type="file" name="file" />
                        <input type="submit" name="submit" value="Upload" />

                            <hr>
                        <div> 
                            <a href="webcam.php">Take a new picture</a>
                        </div>
                    
                    </form>
                </div>


            </div>
            <footer>
            </footer>
    </body>
</html>