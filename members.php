<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
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
    <h1>Members of the Whos</h1>


    <div class="Member">

        <?php
        require_once 'functions.php';
        $records = getMembers();

        while ($row = $records->fetch(PDO::FETCH_ASSOC)) { ?>

            <div class="FellowMember">
                <a href="user.php?username=<?= $row['username'] ?>">
                    <?= $row['username'] ?>
                </a>
                <?= htmlspecialchars($row['created_at']) ?>
            </div>

        <?php } ?>


    </div>
</body>
<style>
    .Member {
        background: rgba(43, 43, 43, 0.8);
    }

    .Member a {
        color: white;
        text-decoration: none;
        font-weight: bold;
    }

    .Member :hover {
        background: rgba(75, 75, 75, 0.8);
    }

    .FellowMember {
        border: 1px solid rgba(100, 100, 100, 0.5);
        padding: 20px;
        display: flex;
        justify-content: space-between;
    }
</style>

</html>