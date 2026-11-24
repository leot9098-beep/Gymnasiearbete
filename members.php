<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book of Whos - Members</title>
    <link href="style.css" rel="stylesheet" type="text/css">
    <link rel="icon" type="image/png" href="assets/icon.png">
</head>

<body>
    <div class="sidenavbar">
        <div class="quicknav">
            <a class="flexnav" href="upload.php"> <img src="assets/Upload.png">
                <span>Upload</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="forum.php"> <img src="assets/Forum.png">
                <span>Forum</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="index.php"> <img src="assets/Book of whos - Title.png"></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="gallery.php"> <img src="assets/Gallery.png">
                <span>Gallery</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="rules.php"> <img src="assets/Questionmark.png">
                <span>Rules</span></a>
        </div>
    </div>
    <h1>Members of the Whos</h1>
    <div class="sortbyandsearcharea">
        <br>
        <select>
            <option>Newest member</option>
            <option>Oldest member</option>
        </select>
        <br>
        <form class="Searcharea">
            <input type="text" id="search" name="search" />
            <input id="search_button" type="submit" value="" />

        </form>
    </div>

    <div class="Member">
        <?php
        $counter = 0;
        require_once 'functions.php';
        $records = getMembers();
        while ($row = $records->fetch(PDO::FETCH_ASSOC)) { ?>
            <?php $username = $row['username']; ?>
            <?php $time = $row['created_at']; ?>
            <?php $counter += 1; ?>
            <a class="member-container member-container-<?= $counter % 2 ?>" href="user.php?username=<?= $username ?>">
                <div class="user-info-member">
                    <img class="small-profile-member" src="avatars/<?= getAvatar(getUserIDAlt($username)) ?>" alt="Profile" width="32" height="32">
                    <p><?= $username ?></p>
                </div>
                <p class="created-at-member">Created <?= timeAgo($time); ?>.</p>
            </a>
        <?php } ?>
    </div>
    </div>
</body>

</html>