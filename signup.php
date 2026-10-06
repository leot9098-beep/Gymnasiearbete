<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>



<body>
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
    <div class="Bigmenu">
        <h1 class="herotxt">Sign up</h1>
        <form method="post" action="" class="LoginInput">
            <label for="username">Username:</label>
            <input type="text" id="username" name="username" required>
            <br>
            <label for="password">Password:</label>
            <input type="password" id="password" name="password" required>
            <br>
            <input id="Loginbutton" type="submit" name="submit" value="Sign up">
            <div style="font-size: 12px;">
                <span>Already have an account? </span>
                <span><a style="color:lime;" href="login.php">Log in</a></span>
            </div>
        </form>


    </div>
</body>

</html>