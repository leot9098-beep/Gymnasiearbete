<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Gallery</title>
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
    <div class="sortbyandsearcharea">
        <br>
        <select>
            <option>Newest</option>
            <option>Oldest</option>
            <option>Most upvotes</option>
            <option>Most downvotes</option>
        </select>
        <select>
            <option>All</option>
            <option>Image</option>
            <option>Gif</option>
        </select>


        <form class="Searcharea">
            <input type="text" id="search" name="search" />
            <input id="search_button" type="submit" value="" />

        </form>
    </div>


    <div>
        <?php
        require_once 'functions.php';
        echo '<div class="gallery-container">';
        foreach (getGalleryImages() as $image) {
            echo '<div class="gallery-item">';
            echo '<a href="view.php?pid=' . $image['pid'] . '"><div class="gallery-image" style="background-image: url(\'uploads/' . $image['filename'] . '\');"></div></a>';
            echo '<button id="options-button-' . $image['pid'] . '" class="gallery-options-button" onclick="viewImageOptions(' . $image['pid'] . ')">···</button>';
            echo '<div class="gallery-options" id="options-' . $image['pid'] . '">';
            echo '<button id="upvote-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/up.png"></img></button>';
            echo '<button id="downvote-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/down.png"></img></button>';
            echo '<button id="favorite-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/star.png"></img></button>';
            echo '<button id="report-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/Megaphone.png"></img></button>';
            echo '<button id="edit-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/edit.png"></img></button>';
            echo '<button id="delete-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/trash.png"></img></button>';
            echo '<button id="moderate-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="viewImageOptions(' . $image['pid'] . ')"><img src="assets/hammer.png"></img></button>';
            echo '</div>';
            echo '<div class="gallery-info">';
            echo '<div class="gallery-info-top">';
            echo '<p class="gallery-title">' . $image['title'] . '</p>';
            echo '</div>';
            echo '<div class="gallery-info-bottom">';
            echo '<a class="gallery-username" href="user.php?username=' . $image['username'] . '"><div class="smaller-profile" style="background-image: url(\'avatars/' . getAvatar(getUserID()) . '\');"></div> <span>' . $image['username'] . '</span></a>';
            echo '<p class="gallery-time">' . timeAgo($image['time']) . '</p>';
            echo '</div>';
            echo '</div>';
            echo '</div>';
        }
        echo '</div>';
        ?>
    </div>
    <script>
        function viewImageOptions(pid) {
            var options = document.getElementById('options-' + pid);
            options.style.display = options.style.display === 'block' ? 'none' : 'block';
        }
    </script>
</body>

</html>