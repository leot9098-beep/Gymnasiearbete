<?php
session_start();
require_once 'assets/functions.php';
$userid = getUserID();
$user = getuserinfo($userid);
$error = false;
if (isset($_POST['submit'])) {
    if (
        isset($_POST['username'])
        && isset($_POST['name'])
        && isset($_POST['password'])
    ) {
        $username = filter_input(
            INPUT_POST,
            "username",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $name = filter_input(
            INPUT_POST,
            "name",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $password = filter_input(
            INPUT_POST,
            "password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $_SESSION['username'] = $username;
        $_SESSION['name'] = $name;
        $validUser = array('uid' => $userid, 'username' => $username, 'name' => $name);
        $localuser = $_SERVER['REMOTE_ADDR'];

        if ($username != "" && $name != "" && $password != "") {
            // print_r($validUser);
            if (updateUser($username, $name, $hashed_password, $localuser, $userid)) {
                header("Location: profile.php");
            } else {
                $error = true;
            }
        } else {
            echo "Du måste mata in username, name och password";
        }
    } else {
        $error = true;
    }
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
    <div class="nav"><a href="logout.php">[Log Out]</a><a href="index.php">[Return]</a></div>
    <?php
    $mango = $_SESSION['username'];
    $uid = getUserID();
    echo "<h1>$mango</h1>";
    echo "<h1>user id is $uid</h1>";
    if ($error) {
        echo "<p>error</p>";
    }
    ?>
    <form method="post" action="">
        <p>Ändra profil: </p>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" required value="<?php echo $user['username']; ?>">
        <br>
        <label for="name">Name:</label>
        <input type="name" id="name" name="name" required value="<?php echo $user['name']; ?>">
        <br>
        <label for="password">Password:</label>
        <input type="text" id="password" name="password" required value="">
        <br>
        <input type="submit" name="submit" value="Ändra">
    </form>
</body>

</html>