<?php
session_start();
require_once 'functions.php';
require_once 'sessioncheck.php';
require_once 'bancheck.php';
$uid = getUserID();
$error = false;
if (isset($_POST['submit'])) {
    if (
        isset($_POST['username'])
        && isset($_POST['password'])
    ) {
        $username = filter_input(
            INPUT_POST,
            "username",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $password = filter_input(
            INPUT_POST,
            "password",
            FILTER_SANITIZE_FULL_SPECIAL_CHARS
        );
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);


        $validUser = array('uid' => $uid, 'username' => $username);
        $localuser = $_SERVER['REMOTE_ADDR'];

        if ($username != "" && $password != "") {
            // print_r($validUser);
            if (updateUser($username, $hashed_password, $localuser, $uid)) {
                $_SESSION['username'] = $username;
                header("Location: profile.php");
            } else {
                $error = true;
            }
        } else {
            echo "You must enter a username, and password.";
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
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="assets/icon.png">
</head>

<body>
    <!--NAVBAR OCH TITEL-->
    <div class="sidenavbar">
        <div class="quicknav">
            <a class="flexnav" href="upload.php"> <img src="assets/Upload.png"></img>
                <span>Upload</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="forum.php"> <img src="assets/Forum.png"></img>
                <span>Forum</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="index.php"> <img src="assets/Book of whos - Title.png" width="200px"></img></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="gallery.php"> <img src="assets/Gallery.png"></img>
                <span>Gallery</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="rules.php"> <img src="assets/Questionmark.png"></img>
                <span>Rules</span></a>
        </div>
    </div>
    <?php
    $uid = getUserID();
    echo '<h1>' . $_SESSION['username'] . '</h1>';
    echo "<h1>user id is $uid</h1>";
    if ($error) {
        echo "<p>error " . "$error" . "</p>";
    }
    ?>
    <form method="post" action="">
        <p>Modify profile: </p>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" autocomplete="off" required value="<?php echo $_SESSION['username']; ?>">
        <br>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" required value="">
        <br>
        <input type="submit" name="submit" value="Change">
    </form>

    <div class="nav"><a href="logout.php">[Log Out]</a>
        <div class="nav"><a href="logout.php">[Delete Account]</a>



</body>

</html>