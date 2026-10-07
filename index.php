<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Main</title>
</head>

<body>
    <div class="Bigmenu">
        <div class="menu"><a href="login.php">Log in</a><a href="signup.php">Sign up</a></div>

        <a href="index.php"><img src="assets/Book of whos - Title.png" alt="" width="500"></a>

        <div class="flexrow">
            <div class="quicknav">
                <a class="flexnav" href="gallery.php">
                    <img src="assets/search.png"></img>
                    <span>Gallery</span>
                </a>
            </div>
            <div class="quicknav">
                <a class="flexnav" href="upload.php"> <img src="assets/search.png"></img>
                    <span>Upload</span></a>
            </div>
            <div class="quicknav">
                <a class="flexnav" href="forum.php"> <img src="assets/search.png"></img>
                    <span>Forum</span></a>
            </div>
            <div class="quicknav">
                <a class="flexnav" href="members.php"> <img src="assets/Members.png"></img>
                    <span>Members</span></a>
            </div>
        </div>

        <form class="Searcharea">
            <input type="text" id="search" name="search" />
            <input id="search_button" type="submit" value="" />

        </form>
    </div>
    <p> </p>
</body>

</html>