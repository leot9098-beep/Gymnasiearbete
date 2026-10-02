<?php
require_once 'assets/functions.php';
session_start();
//$error=false;
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = filter_input(INPUT_POST, "username", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $password = filter_input(INPUT_POST, "password", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    $localuser = $_SERVER['REMOTE_ADDR'];

    if ($username != "" && $name != "" && $password != "") {
        if (addUser($username, $name, $hashed_password, $localuser)) {
            $_SESSION['username'] = $username;
            $_SESSION['name'] = $name;

            header('Location: index.php');
            exit;
        }
    } else {
        echo "noo stop elite haxorr saar you vill not input nothing saar";
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
    <link href="css/silver.css" rel="stylesheet" type="text/css">
</head>

<style>
    <?php
    $Images = array('30.png', '28.png', '32.png', '34.webp', '22.png');
    $BOTD =  "http://192.168.49.187/~adminator/PHP/Images/" . $Images[array_rand($Images)];
    echo 'body{background-image: url("' . "$BOTD" . '");}';
    ?>
</style>

<body>
    <div class="nav">
        <span>Har redan ett konto?</span><a href="login.php">[Log In]</a>
    </div>
    <h1 class="herotxt">Silver forum sign up</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="Sign up">
    </form>
</body>

</html>