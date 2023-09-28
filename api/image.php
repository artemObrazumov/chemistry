<?php
if ( isset($_FILES['image']) ) {
    $image_path = $_FILES['image']['tmp_name'];
    if (exif_imagetype($image_path)) {
        $path = $_FILES['image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $file_name = random_string(14) . '.' . $ext;
        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . $file_name;
        move_uploaded_file($image_path, $path);
        print($file_name);
    }
}

function random_string($length) {
    $key = '';
    $keys = array_merge(range(0, 9), range('a', 'z'));

    for ($i = 0; $i < $length; $i++) {
        $key .= $keys[array_rand($keys)];
    }

    return $key;
}

?>