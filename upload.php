<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Upload An Image</title>
</head>

<body>

    <form action="uploadphoto.php" method="post" enctype="multipart/form-data">
        <div class="Bigmenu">
            <label for="image">upload an image here</label>
            <input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp">
            <input type="submit" name="submit" value="Send">
        </div>
    </form>
</body>

</html>