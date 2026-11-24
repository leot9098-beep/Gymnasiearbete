<?php
session_start();
require_once 'functions.php';
require_once 'bancheck.php';
$upload = $_FILES['image'] ?? null;
$uploadDir = __DIR__ . '/uploads/';
$uploadDirThumb = __DIR__ . '/thumbnail/';

if (!$upload || !isset($upload['error'])) {
    http_response_code(400);
    exit('No image received. Check the form field name and PHP post_max_size.');
}

if ($upload['error'] !== UPLOAD_ERR_OK) {
    http_response_code(400);
    exit('Upload error code: ' . $upload['error']);
}

if (!is_uploaded_file($upload['tmp_name'])) {
    http_response_code(400);
    exit('Invalid upload.');
}

$maxBytes = 100 * 1024 * 1024;
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
if ($dimensions === false || $dimensions[0] > 16000 || $dimensions[1] > 16000) {
    http_response_code(400);
    exit('Invalid image or dimensions exceed the limit.');
}

$originalFilename = basename($upload['name']);

if (!is_dir($uploadDir) && !mkdir($uploadDir, 0755, true)) {
    http_response_code(500);
    exit('Could not create upload directory.');
}

if (!is_writable($uploadDir)) {
    http_response_code(500);
    exit('Upload directory is not writable.');
}

if (!is_writable($uploadDirThumb)) {
    http_response_code(500);
    exit('Thumbnail directory is not writable.');
}

$safeName = preg_replace('/[^A-Za-z0-9_-]/', '_', pathinfo($originalFilename, PATHINFO_FILENAME));
$nextPid = getGalleryHighestPID() + 1;
$baseName = 'BookOfWho_' . $safeName . '_' . $nextPid;

$filename = $baseName . '.' . $allowed[$mime];
$thumbnailFilename = $baseName . '.webp';
$filetype = $allowed[$mime];

$destination   = $uploadDir . $filename;
$thumbnailPath = $uploadDirThumb . $thumbnailFilename;

$committed = false;

// Runs even after fatal errors (memory exhausted, timeout, Imagick crash handled by PHP)
register_shutdown_function(function () use (&$committed, $destination, $thumbnailPath) {
    if (!$committed) {
        @unlink($destination);
        @unlink($thumbnailPath);
    }
});

if (!move_uploaded_file($upload['tmp_name'], $destination)) {
    failUpload(500, 'Could not save the image.');
}

try {
    set_time_limit(60);

    // Make Imagick fail with an exception instead of taking down the process
    Imagick::setResourceLimit(Imagick::RESOURCETYPE_MEMORY, 1024 * 1024 * 1024);
    Imagick::setResourceLimit(Imagick::RESOURCETYPE_MAP,    512 * 1024 * 1024);
    Imagick::setResourceLimit(Imagick::RESOURCETYPE_TIME,   30);

    if (!in_array('WEBP', Imagick::queryFormats('WEBP'), true)) {
        throw new RuntimeException('This ImageMagick installation does not support WebP.');
    }

    // Cheap probe: reads headers only, doesn't decode pixels
    $probe = new Imagick();
    $probe->pingImage($destination);
    $frameCount = $probe->getNumberImages();
    $probe->clear();

    // Pixel budget for animated thumbnails (width * height * frames)
    $animate = $frameCount > 1
        && $frameCount <= 450
        && ($dimensions[0] * $dimensions[1] * $frameCount) <= 160000000;

    if ($animate) {
        $image  = new Imagick($destination);
        $frames = $image->coalesceImages();
        $image->clear();

        foreach ($frames as $frame) {
            $frame->thumbnailImage(295, 295, true, false);   // keep ratio, no padding
            $frame->setImagePage(0, 0, 0, 0);
        }


        $frames->setImageFormat('webp');
        $frames->setOption('webp:alpha-quality', '100');
        $frames->setOption('webp:exact', 'true');           // keep RGB under transparent pixels
        $frames->setImageCompressionQuality(80);
        $saved = $frames->writeImages('webp:' . $thumbnailPath, true);
        $frames->clear();
    } else {
        $image = new Imagick();
        $image->setBackgroundColor(new ImagickPixel('transparent'));
        $image->readImage($destination . '[0]');

        $image->thumbnailImage(360, 360, true, false);       // keep ratio, no padding
        $image->setImagePage(0, 0, 0, 0);
        $image->setImageFormat('webp');
        $image->setOption('webp:alpha-quality', '100');
        $image->setOption('webp:exact', 'true');
        $image->setImageCompressionQuality(80);
        $saved = $image->writeImage('webp:' . $thumbnailPath);
        $image->clear();
    }
    if (!$saved) {
        throw new RuntimeException('ImageMagick could not write the thumbnail.');
    }
} catch (Throwable $e) {
    error_log('Thumbnail error: ' . $e->getMessage());
    failUpload(500, 'Could not create the WebP thumbnail. Check the server error log for details.', [$destination, $thumbnailPath]);
}

$uid = getUserID();
echo '<p>Uploaded image: ' . htmlspecialchars($filename) . '</p>';
echo '<p>File type: ' . htmlspecialchars($filetype) . '</p>';
$ip = $_SERVER['REMOTE_ADDR'];
if (($_POST['title'] ?? '') === '') {
    $title = $originalFilename;
} else {
    $title = $_POST['title'];
}
if (($_POST['description'] ?? '') === '') {
    $description = 'No description provided.';
} else {
    $description = $_POST['description'];
}
$tags = $_POST['tags-input'] ?? '';
if (json_decode($tags) === null) {
    $tags = json_encode(['[tagme]']);
}
try {
    $result = uploadToGallery($filename, $filetype, $thumbnailFilename, $originalFilename, $ip, $uid, $title, $description, $tags);
} catch (Throwable $e) {
    error_log('Gallery insert error: ' . $e->getMessage());
    $result = false;
}

if (!$result) {
    failUpload(500, 'Gallery insert failed.', [$destination, $thumbnailPath]);
}

$committed = true;   // only now are the files kept
header('Location: gallery.php');
exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" type="text/css" />
    <title>Uploaded Image</title>
    <link rel="icon" type="image/png" href="assets/icon.png">
</head>

<body>

</body>

</html>