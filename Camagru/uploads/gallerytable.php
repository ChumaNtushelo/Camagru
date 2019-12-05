<?php
include_once "../config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    // error exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // CREATING TABLE for gallery
    $sql = "CREATE TABLE IF NOT EXISTS gallery (
            id INT(10) PRIMARY KEY AUTO_INCREMENT,
            imagename VARCHAR(255),
            date_uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $conn->exec($sql);
    echo "Table for images created successfully";

    }
catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    ?>