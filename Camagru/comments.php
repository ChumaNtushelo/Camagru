<?php

include_once "./config/database.php";

session_start();

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$newemail = $_SESSION['mail'];
echo $newemail;






















?>

$sql  = "INSERT INTO Users (email, username, password, confirm_password, token) VALUES (:email, :username, :password, :confirm_password, :token)";