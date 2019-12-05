<?php
include_once "./config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    // error exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // CREATING TABLE for gallery
    // $sql = "CREATE TABLE IF NOT EXISTS comments (
    //         id INT(10) PRIMARY KEY AUTO_INCREMENT,
    //         userId INT(10),
    //         comment VARCHAR(255),
    //         date_uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $sql = "CREATE TABLE IF NOT EXISTS comments (
        parent_comment_id INT(10) PRIMARY KEY AUTO_INCREMENT,
        comment VARCHAR(255),
        comment_sender_name VARCHAR(255),
        date_uploaded TIMESTAMP DEFAULT CURRENT_TIMESTAMP)";

    $conn->exec($sql);
    echo "Table for comments created successfully";

    }
catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    $query = "INSERT INTO commentstable (parent_comment_id, comment, comment_sender_name) VALUES (:parent_comment_id, :comment, :comment_sender_name)";
    ?>