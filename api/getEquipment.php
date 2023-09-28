<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
    $result_row = $db->query("SELECT * FROM equipment;");
    $db->close();
    $formatted_result = array();
    while($r = mysqli_fetch_assoc($result_row)) {
        $formatted_result[] = $r;
    }
    if ($_GET['reversed'] == 1) {
        $formatted_result = array_reverse($formatted_result);
    }
    print json_encode($formatted_result);
?>