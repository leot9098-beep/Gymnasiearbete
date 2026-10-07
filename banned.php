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



<body>
    <style>
        <?php
        $Images = array('30.png', '28.png', '32.png', '34.webp', '22.png');
        $BOTD =  "http://192.168.49.187/~adminator/PHP/Images/" . $Images[array_rand($Images)];
        echo 'body{background-image: url("' . "$BOTD" . '"); background-size:cover;}';

        ?>
    </style>
</body>

</html>