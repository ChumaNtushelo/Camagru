<?php


include ('config/database.php');

session_start();

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$newemail = $_SESSION['mail'];
echo $newemail;

$name = "cam".time();

$image0 = str_replace("data:image/png;base64,","",$_POST['savedata']);
//echo $image0;
$image1 = str_replace(" ","+",$image0);
$img2 = base64_decode($image1);
file_put_contents("uploads/$name.png","$img2");
?>

<img src="<?php echo("uploads/$name.png")?>">
<?php

?>