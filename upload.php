<?php
if (isset($_POST['submit'])){
$max_file_size = 104857600;
@file_types = array('gif', 'jpg', 'png', 'WebP');
$upload_dir = realpath(dirname(__FILE__)). '/uploads/';
$errors =array();
$file_tmp = $_FILES['photo']['tmp_name'];
$file_name = $_FILES['photo']['name'];
$file_size = $_FILES['photo']['size'];
$file_uniq = uniqid();
$file_ext = pathinfo ($file_name, PATHINFO_EXTENSION);
$file = $upload_dir . $file_uniq . '.' . $file_ext;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
</head>
<body>
    
</body>
</html>