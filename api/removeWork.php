<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['ID'] == null) {
        print "{e: 'Not enough data to remove'}";
        http_response_code(400);
    } else {
        $data = ["ID"=>$_GET['ID']];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("DELETE FROM `works` WHERE ID=". $data['ID'] .";");
        $db->close();
    }