<?php
require_once 'functions.php';
session_start();
//$error=false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $ip = $_SERVER['REMOTE_ADDR'];

    if ($username != "" && $password != "") {
        if (addUser($username, $hashed_password, $ip)) {
            $_SESSION['username'] = $username;

            header('Location: index.php');
            exit;
        }
    } else {
        echo "You must enter a username, and password.";
    }

    $error = 'Could not create the user.';
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
</head>



<body>
    <style>
        <?php
        $Images = array('30.png', '28.png', '32.png', '34.webp', '22.png');
        $BOTD =  "http://192.168.49.187/~adminator/PHP/Images/" . $Images[array_rand($Images)];
        echo 'body{background-image: url("' . "$BOTD" . '");}';
        ?>
    </style>
    <div class="nav">
        <span>Har redan ett konto?</span><a href="login.php">[Log In]</a>
    </div>
    <h1 class="herotxt">Silver forum sign up</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="Sign up">
    </form>
</body>

</html>