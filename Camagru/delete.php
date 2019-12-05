<?php

include_once "./config/database.php";

session_start();

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$newemail = $_SESSION['mail'];
echo $newemail;

$imgId = $_GET['id'];
try {

$query = $conn->prepare("DELETE FROM gallery WHERE id=:id AND imagename=:imagename");
$query->execute(array(':id' => $imgId, 'imagename' => $_SESSION['mail']));
}
catch (PDOException $e) {
    echo $e->getMessage();
}
header('location:gallery.php');