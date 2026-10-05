<?php
require_once 'functions.php';
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // if ($_POST['username'] != $username || $_POST['password'] != $password) {
    //      $errors[] = 'skriv rätt';
    //}

    if (login($username, $password)) {
        $_SESSION['username'] = $username;
        $userid = getUserID();
        $_SESSION['password'] = getPass($userid);

        header('Location: index.php');
        exit();
    } else {
        echo "Invalid username or password";
    }
}
?>
<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
    <div class="nav"><span>Inget konto?</span><a href="signup.php">[Sign Up]</a> | <a href="http://192.168.49.187/~adminator">[Return to Adminator]</a></div>
    <h1 class="herotxt">Silver forum log in</h1>
    <form method="post" action="">
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required>
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required>
        <br>
        <input type="submit" name="submit" value="Login">
    </form>
</body>

</html>