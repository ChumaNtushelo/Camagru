<?php
include_once "database.php";

/*$servername = "localhost";
$username = "root";
$password = "626manBM";
$dbname = "camagru";*/

/* CREATING DATABASE */

try {
    $conn = new PDO("mysql:host=$servername", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $conn->exec("DROP DATABASE IF EXISTS camagru;");
    $conn->exec("CREATE DATABASE IF NOT EXISTS camagru;");
}
catch (PDOException $e) {
    echo $e->getMessage();
}

/* CREATING TABLES */

try {
    $conn = new PDO("mysql:host=$servername;dbname=camagru", $username, $password);
    // error exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // $sql = use camagru;
    // CREATING TABLE for Users
    $sql = "CREATE TABLE IF NOT EXISTS Users (
            id INT(6) AUTO_INCREMENT PRIMARY KEY NOT NULL,
            email VARCHAR(255) NOT NULL,
            username VARCHAR(255) NOT NULL,
            password VARCHAR(255) NOT NULL,
            confirm_password varchar(255) NOT NULL,
            token varchar(255) NOT NULL,
            verified int(10) Default 0,
            reg_date TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP)";

    $conn->exec($sql);
    echo "Table Users created successfully";

    }
catch(PDOException $e)
    {
        echo $sql . "<br>" . $e->getMessage();
    }
$conn = null;
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <a href="../index.php">Login</a>
</body>
</html>