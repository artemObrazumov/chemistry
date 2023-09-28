<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
    $types = $db->query("SELECT typeString FROM reagenttypes;");
    $formatted_result = array();
    while($r = mysqli_fetch_assoc($types)) {
        $formatted_result[] = $r;
    }
    $db->close();

    print json_encode($formatted_result);
?>