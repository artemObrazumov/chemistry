<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['ID'] == null || $_GET['name'] == null || $_GET['storage'] == null) {
        print "{e: 'Not enough data to perform changes'}";
        http_response_code(400);
    } else {
        $data = ["ID"=>$_GET['ID'], "name"=>$_GET['name'], "storage"=>$_GET['storage']];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("UPDATE `equipment` SET name='". $data['name'] ."', storage='". $data['storage'] ."' WHERE ID=". $data['ID'] .";");
        $db->close();
        print(json_encode($data));
    }