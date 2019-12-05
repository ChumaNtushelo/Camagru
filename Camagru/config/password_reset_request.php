<?php
include_once "database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    // error exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // CREATING TABLE for password reset request
    $sql = "CREATE TABLE IF NOT EXISTS password_reset_request (
            id INT(10) PRIMARY KEY AUTO_INCREMENT,
            user_id INT(10) NOT NULL,
            date_requested TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL,
            token varchar(255) NOT NULL)";

    $conn->exec($sql);
    echo "Table Users created successfully";

    }
catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }

    ?>