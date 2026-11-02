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
    <h1>Leo fixa baren och members.</h1>
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
            <a class="flexnav" href="members.php"> <img src="assets/Members.png"></img>
                <span>Members</span></a>
        </div>
        <div class="quicknav">
            <a class="flexnav" href="rules.php"> <img src="assets/Questionmark.png"></img>
                <span>Rules</span></a>
        </div>
    </div>
    <div>
        <?php
        require_once 'functions.php';
        $records = getMembers();

        while ($row = $records->fetch(PDO::FETCH_ASSOC)) { ?>
            <div>
                <a href="user.php?username=<?= $row['username'] ?>">
                    <?= $row['username'] ?>
                </a>
                <?= htmlspecialchars($row['created_at']) ?>
            </div>
        <?php } ?>


    </div>
</body>

</html>