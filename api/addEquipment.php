<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['name'] == null || $_GET['storage'] == null) {
        print "{e: 'Not enough data to perform adding'}";
        http_response_code(400);
    } else {
        $data = ["name"=>$_GET['name'], "storage"=>$_GET['storage'], "image"=>$_GET['image']];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("INSERT INTO `equipment` (name, storage, image) VALUES ('". $data['name'] ."', '". $data['storage'] ."', image='". $data['image'] ."');");
        $data["ID"]=$db->insert_id;
        $db->close();
        print(json_encode($data));
    }
?>