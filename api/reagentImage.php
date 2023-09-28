<?php
if ( isset($_FILES['image']) && isset($_POST['reagentId']) ) {
    $image_path = $_FILES['image']['tmp_name'];
    if (exif_imagetype($image_path)) {
        $path = $_FILES['image']['name'];
        $ext = pathinfo($path, PATHINFO_EXTENSION);
        $path = $_SERVER['DOCUMENT_ROOT'] . '/uploads/' . random_string(14) . '.' . $ext;
        move_uploaded_file($image_path, $path);

        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("UPDATE `reagents` SET image='" . $path . "' WHERE ID=". $_POST['reagentId'] .";");
        $db->close();
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