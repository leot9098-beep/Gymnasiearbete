<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Document</title>
</head>

<body>
    <?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $upload = $_FILES['image'] ?? null;


        $upload = $_FILES['image'] ?? null;

        if (!$upload || $upload['error'] !== UPLOAD_ERR_OK) {
            http_response_code(400);
            exit('Upload failed.');
        }

        if (!is_uploaded_file($upload['tmp_name'])) {
            http_response_code(400);
            exit('Invalid upload.');
        }

        $maxBytes = 5 * 1024 * 1024;
        if ($upload['size'] > $maxBytes) {
            http_response_code(413);
            exit('Image is too large.');
        }

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png'  => 'png',
            'image/gif'  => 'gif',
            'image/webp' => 'webp',
        ];

        $finfo = new finfo(FILEINFO_MIME_TYPE);
        $mime = $finfo->file($upload['tmp_name']);

        if (!isset($allowed[$mime])) {
            http_response_code(415);
            exit('Unsupported image format.');
        }

        // Optional: enforce pixel dimensions too.
        $dimensions = @getimagesize($upload['tmp_name']);
        if ($dimensions === false || $dimensions[0] > 6000 || $dimensions[1] > 6000) {
            http_response_code(400);
            exit('Invalid image or dimensions exceed the limit.');
        }

        $filename = bin2hex(random_bytes(16)) . '.' . $allowed[$mime];
        $destination = __DIR__ . '/uploads/' . $filename;

        if (!move_uploaded_file($upload['tmp_name'], $destination)) {
            http_response_code(500);
            exit('Could not save the image.');
        }

        echo 'Upload successful.';
    }
    ?>
    <form action="uploadphoto.php" method="post"
        enctype="multipart/form-data">
        <fieldset>
            <legend>Vote for a map</legend>
            <ol>
                <li><label for="image">choose a hero</label>
                    <input type="file" id="image" name="image" accept="image/jpeg , image/png, image/gif, image/webp">
                </li>
            </ol>
        </fieldset>
        <input type="submit" name="submit" value="Change role">
    </form>
</body>

</html>