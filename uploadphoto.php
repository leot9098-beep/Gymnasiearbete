 <?php
    $upload = $_FILES['image'] ?? null;
    $uploadDir = __DIR__ . '/uploads/';

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


    if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
        http_response_code(500);
        exit('Could not create upload directory.');
    }

    if (!is_writable($uploadDir)) {
        http_response_code(500);
        exit('Upload directory is not writable.');
    }

    $destination = $uploadDir . $filename;

    if (!move_uploaded_file($upload['tmp_name'], $destination)) {
        http_response_code(500);
        exit('Could not save the image.');
    }

    echo 'Upload successful.';
    ?>
 <!DOCTYPE html>
 <html lang="en">

 <head>
     <meta charset="UTF-8">
     <meta name="viewport" content="width=device-width, initial-scale=1.0">
     <title>Document</title>
 </head>

 <body>

 </body>

 </html>