<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
    $types = $db->query("SELECT typeString FROM reagenttypes;");
    $formatted_types = array();
    while($r = mysqli_fetch_assoc($types)) {
        $formatted_types[] = $r;
    }
    $result_row = $db->query("SELECT * FROM reagents;");
    $formatted_result = array();
    while($r = mysqli_fetch_assoc($result_row)) {
        $r['typeString'] = $formatted_types[$r['type']-1]['typeString'];
        $formatted_result[] = $r;
    }
    $db->close();
    if ($_GET['reversed'] == 1) {
        $formatted_result = array_reverse($formatted_result);
    }
    print json_encode($formatted_result);
?>