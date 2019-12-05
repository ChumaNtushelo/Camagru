<?php
$error = NULL;
// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

//require "config/database.php";

session_start();

if (isset($_POST['confirmed'])) {
    echo "hello";
}

echo "hello world";

?>

<html>
<p> ggg </p>
<?php echo $error; ?>
</html>