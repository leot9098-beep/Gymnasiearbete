<!DOCTYPE html>
<html lang="sv">

<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="style.css" rel="stylesheet" type="text/css">
</head>



<body>
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
    <div class="Bigmenu">
        <h1 class="herotxt">Log in</h1>
        <form method="post" action="" class="LoginInput">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input id="Loginbutton" type="submit" name="submit" value="Log in">
            <div style="font-size: 12px;">
                <span>Don't have an account? </span>
                <span><a style="color:lime;" href="signup.php">Sign up</a></span>
            </div>
        </form>
    </div>
</body>

</html>