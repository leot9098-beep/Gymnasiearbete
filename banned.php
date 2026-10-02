<?php
session_start();
require_once 'functions.php';
require_once 'sessioncheck.php';
echo "<h1>You are probably not bannad. We haven't added that feature yet.</h1>";
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign up</title>
    <link href="css/style.css" rel="stylesheet" type="text/css">
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