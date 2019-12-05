<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$db_dsn = "mysql:dbname=camagru;host=localhost";
$servername = "localhost";
$db_name = "camagru";
$username = "root";
$password = "626manBM";

try {
    $conn = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected(database.php)";
}
catch (PDOException $e) {
    echo $e->getMessage();
}

?>