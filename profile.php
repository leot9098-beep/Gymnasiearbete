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
    <title>Book of Whos - Profile</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="assets/icon.png">
</head>

<body>
    <!--NAVBAR OCH TITEL-->
    <div class="sidenavbar">
        <div class="quicknav">
            <a class="flexnav" href="forum.php"> <img src="assets/Forum.png">
                <span>Forum</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="upload.php"> <img src="assets/Upload.png">
                <span>Upload</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="gallery.php"> <img src="assets/Gallery.png">
                <span>Gallery</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="index.php"> <img src="assets/Book of whos - Title.png"></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="members.php"> <img src="assets/Members.png">
                <span>Members</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="rules.php"> <img src="assets/Questionmark.png">
                <span>Rules</span></a>
        </div>
        <div class="quicknav"><?php if (!isset($_SESSION['username'])) { ?>

                <a class="flexnav" href="login.php"> <img src="assets/Profile.png">
                    <span>Login</span></a>

            <?php } else { ?>
                <a class="flexnav" href="profile.php"> <img src="assets/Profile.png">
                    <span>Profile</span></a>
            <?php } ?>
        </div>
    </div>



    <div id="container">
        <div id="ProfileView">
            <?php
            $username = $_SESSION['username'];
            echo '<img class="small-profile" src="avatars/' . getAvatar(getUserID()) . '" alt="Profile" width="256" height="256">';
            $uid = getUserID();
            echo '<h1> Username: ' . $_SESSION['username'] . '</h1>';
            echo '<hr size="3px" style=" background-color:white; border:none;  dashed" >';
            echo '<p>Fellow Member since: ' . userCreatedTimeAgo($username) . '</p>';
            echo '<p>Uploads: </p>';
            echo "<p>User id: $uid</p>";
            echo '<p>Status: ' . rand(-1000, 1000) . ' Social Credit </p>';
            echo '<p>ZZZ Pulls (not permanent): ' . rand(-100, 100) . ' pulls </p>';
            if ($error) {
                echo "<p>error " . "$error" . "</p>";
            }
            ?>
        </div>


        <div id="ProfileEdit">
            <form method="post" action="">
                <label for="username">Change username:</label>
                <input type="text" id="username" class="superman" name="username" autocomplete="off" placeholder="Enter new username..." required>
                <!--   <input type="text" id="username" name="username" autocomplete="off" required value="<?php echo $_SESSION['username']; ?>">-->
                <br>
                <label for="password">Change password:</label>
                <input type="password" id="username" class="superman" name="password" placeholder="Enter new password..." required>
                <br>
                <label for="password">Change Profile picture:</label>
                <div class="Bigmenu">
                    <div class="quicknav" id="bigzone" style="max-width: 100%;">
                        <label for="image" style="border: rgb(100, 100, 100) 1px solid; width: 100%; padding: 180px 0px 180px 0px;"><input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp" hidden>
                            <img src="assets/Upload.png"> <br>
                            <span style="font-size: 20px; font-weight:bold">Upload profile picture here</span>
                            <br> <span>Supports jpg, png, gif and webp files up to 100MB</span>

                        </label>
                    </div>
                </div>
                <input type="submit" class="flexbutton" name="submit" value="Change">
            </form>
            <div id="ProfileEnd">
                <div class="nav"><a href="logout.php">[Log Out]</a></div>
                <div class="nav"><a href="logout.php" style="color: red;">[Delete Account]</a></div>
            </div>


        </div>



</body>

<style>
    #container {
        display: grid;
        grid-template-columns: 1fr 2fr;
        min-height: 800px;

    }

    #ProfileView {
        background: rgba(104, 104, 104, 0.8);
        padding: 40px;

    }

    #ProfileEdit {
        background: rgba(45, 45, 45, 0.8);
        padding: 40px;
    }

    /* #ProfileEdit form {
        display: flex;
        flex-direction: column;
        gap: 20px;
    }*/

    #ProfileEdit a {

        color: white;
        text-decoration: none;
        display: flex;
    }

    #ProfileEnd {
        margin-top: 60px;
    }


    .superman {
        display: flex;
        flex-wrap: wrap;
        border: 0;
        outline: 0;
        flex: 1;
        min-width: 140px;
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        font-size: small;
        background: rgba(75, 75, 75, 0.5);
        color: white;
        padding: 10px;
    }
</style>

</html>