<?php

require "config/database.php";

// cheking for errors
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = array();

// Declare variables and initials with empty values
$email = $username = $password = $confirm_password = "";
$email_error = $username_error = $password_error = $confirm_password_error = "";

// Create account button
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = ['confirm_password'];

    // validation
    if (empty($username)) {
        $errors['username'] = "username required";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Email address is invalid";
    }
    if (empty($email)) {
        $errors['email'] = "email required";
    }
    if (empty($password)) {
        $errors['password'] = "password required";
    }
    if (empty($confirm_password)) {
        $errors['password'] = "confirm password required";
    }

    if ($password !== $confirm_password) {
        $errors['password'] = "Passwords do not match";
    }

    $emailQuery = "SELECT * FROM users WHERE email=? LIMIT 1";
    $stmt = $conn->prepare($emailQuery);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();
    $userCount = $result->num_rows;
    $stmt->close();

    if ($userCount > 0) {
        $errors['email'] = "Email already exists";
    }
    if (count($errors) === 0) {
        $password = password_hash($password, PASSWORD_DEFAULT);
        $token = bin2hex(random_bytes(50));
        $verified = false;

        $sql = "INSERT INTO users (username, email, verified, token, passsword) VALUES (?, ?, ?, ?, ?)";
        $stmt = $conn->prepare($emailQuery);
        $stmt->bind_param('s', $email);
        $stmt->execute();
    }


}

?>

<!doctype html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" type="text/css" href="style.css">
        <title> signup </title>
    </head>
        <body>
            <div class="header">
                <a href="index.php"> Camagru </a>
            </div>
                <br/>
                <hr>
            <div style="margin: 30px; padding: 20px; border: 1px solid black;">
                <form method="POST" style="margin: 0cm;" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?> ">
                        <h2 style="margin: 10px;"> Sign Up </h2>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Email address <br/> <input type="email" name="email"  placeholder="Email" class="form-control" value="<?php echo $email; ?>"/>
                        </div>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Username <br/> <input type="text" name="username" placeholder="Username" class="form-control" value="<?php echo $username; ?>" />
                    </div>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Password <br/> <input type="password" name="password" placeholder="Password" value="" />
                    </div>
                        <br/>
                    <div class="form-group <?php echo (!empty($username_error)) ? 'has-error' : ''; ?>">
                        Confirm password <br/> <input type="password" name="confirm_password" placeholder="Re-enter password"/>
                    </div>
                        <br/>
                    <div class="form-group">
                        <input type="submit" name="submit" value="Create Account" class="btn btn-primary"/>
                    </div>
                    <div>
                        Already have an account? <a href="index.php"> Login here. </a>
                    </div>
                </form>
            </div>

        </body>
</html>
