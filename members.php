<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Members</title>
    <link href="style.css" rel="stylesheet" type="text/css">
</head>

<body>
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
    <table id="dbres">

        <tr>
            <th>Namn</th>

            <th>Datum</th>
        </tr>
        <?php do { ?>
            <tr>
                <td><a href="Search.php?search=<?php echo $row_Recordset1['username']; ?>"><?php echo $row_Recordset1['username']; ?></td>

                <td><?php echo $row_Recordset1['time']; ?></td>

            </tr>
        <?php } while ($row_Recordset1 = $records->fetch(PDO::FETCH_ASSOC)); ?>
    </table>
</body>

</html>