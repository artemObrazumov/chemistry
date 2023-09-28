<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['ID'] == null || $_GET['name'] == null || $_GET['type'] == null) {
        print "{e: 'Not enough data to perform changes'}";
        http_response_code(400);
    } else {
        $data = ["ID"=>$_GET['ID'], "name"=>$_GET['name'], "type"=>$_GET['type'], "note"=>$_GET['note']];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("UPDATE `reagents` SET name='". $data['name'] ."', type=". $data['type'] .", note='". $data['note'] ."' WHERE ID=". $data['ID'] .";");
        $typeStr = $db->query("SELECT * FROM reagenttypes WHERE typeID = ".$data['type']);
        $typeString = '';
        while($r = mysqli_fetch_assoc($typeStr)) {
            $typeString = $r['typeString'];
        }
        $data["typeString"] = $typeString;
        $db->close();
        print(json_encode($data));
    }