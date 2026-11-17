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
    <div>
        <?php
        require_once 'functions.php';
        echo '<div class="gallery-container">';
        foreach (getGalleryImages() as $image) {
            echo '<div class="gallery-item">';
            echo '<a href="view.php?pid=' . $image['pid'] . '"><div class="gallery-image" style="background-image: url(\'uploads/' . $image['filename'] . '\');"></div></a>';
            echo '<button id="options-button-' . $image['pid'] . '" class="gallery-options-button" onclick="viewImageOptions(' . $image['pid'] . ')">···</button>';
            echo '<div class="gallery-options" id="options-' . $image['pid'] . '">';
            echo '<button id="upvote-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="upvoteImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/up.png\');"></div></button>';
            echo '<button id="downvote-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="downvoteImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/down.png\');"></div></button>';
            echo '<button id="favorite-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="favoriteImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/star.png\');"></div></button>';
            echo '<button id="react-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="reactToImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/react.png\');"></div></button>';
            echo '<button id="report-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="reportImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/flag.png\');"></div></button>';
            echo '<button id="edit-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="editImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/edit.png\');"></div></button>';
            echo '<button id="delete-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="deleteImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/trash.png\');"></div></button>';
            echo '<button id="moderate-button-' . $image['pid'] . '" class="gallery-suboptions-button" onclick="moderateImage(' . $image['pid'] . ')"><div class="gallery-suboptions-icon" style="background-image: url(\'assets/hammer.png\');"></div></button>';
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
            const options = document.getElementById(`options-${pid}`);
            if (!options) return;

            const shouldOpen = getComputedStyle(options).display === 'none';

            // Close any other open menus
            document.querySelectorAll('.gallery-options').forEach(menu => {
                menu.style.display = 'none';
            });

            if (shouldOpen) {
                options.style.display = 'flex';
            }
        }

        // Close menus when clicking outside their gallery item
        document.addEventListener('click', event => {
            if (!event.target.closest('.gallery-item')) {
                document.querySelectorAll('.gallery-options').forEach(menu => {
                    menu.style.display = 'none';
                });
            }
        });

        function upvoteImage(pid) {
            console.log(`Upvoted image with pid: ${pid}`);
            const image = document.querySelector(`#upvote-button-${pid}`);
            image.style.border = '1px solid rgb(0, 155, 255)'; // Example visual feedback for upvote
            image.style.backgroundColor = 'rgba(0, 155, 255, 0.5)'; // Example visual feedback for upvote
        }

        function downvoteImage(pid) {
            console.log(`Downvoted image with pid: ${pid}`);
            const image = document.querySelector(`#downvote-button-${pid}`);
            image.style.border = '1px solid rgb(255, 0, 0)'; // Example visual feedback for downvote
            image.style.backgroundColor = 'rgba(255, 0, 0, 0.5)'; // Example visual feedback for downvote
        }

        function favoriteImage(pid) {
            console.log(`Favorited image with pid: ${pid}`);
            const image = document.querySelector(`#favorite-button-${pid}`);
            image.style.border = '1px solid rgb(255, 255, 0)'; // Example visual feedback for favorite
            image.style.backgroundColor = 'rgba(255, 255, 0, 0.5)'; // Example visual feedback for favorite
        }

        function reactToImage(pid) {
            console.log(`Reacted to image with pid: ${pid}`);
            // Implement the react logic here
        }

        function reportImage(pid) {
            console.log(`Reported image with pid: ${pid}`);
            // Implement the report logic here
        }

        function editImage(pid) {
            console.log(`Editing image with pid: ${pid}`);
            // Implement the edit logic here
        }

        function deleteImage(pid) {
            console.log(`Deleting image with pid: ${pid}`);
            // Implement the delete logic here
        }

        function moderateImage(pid) {
            console.log(`Moderating image with pid: ${pid}`);
            const opener = event.target.closest('.gallery-suboptions-button');
            if (!opener) return;

            const dialog = document.createElement('dialog');
            const topBar = document.createElement('div');
            topBar.classList.add('dialog-top-bar');
            const closeButton = document.createElement('button');
            const content = document.createElement('p');

            closeButton.type = 'button';
            closeButton.textContent = '×';
            closeButton.setAttribute('aria-label', 'Close');

            content.textContent = "Report a hero.";

            dialog.append(topBar, closeButton, content);
            document.body.append(dialog);

            closeButton.addEventListener('click', () => dialog.close());

            // Close when the backdrop is clicked
            dialog.addEventListener('click', event => {
                if (event.target === dialog) dialog.close();
            });

            // Remove the dialog from the page after it closes
            dialog.addEventListener('close', () => dialog.remove(), {
                once: true
            });

            dialog.showModal();
        }
    </script>
</body>

</html>