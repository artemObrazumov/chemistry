<?php 
    include('dbData.php');
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    if ($_GET['ID'] == null) {
        print "{e: 'Not enough data to get info'}";
        http_response_code(400);
    } else {
        $data = array('ID' => $_GET['ID']);
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $equipmentInfo = $db->query("SELECT * FROM equipment WHERE ID = ".$data["ID"].";");
        $formatted_result = array();
        while($r = mysqli_fetch_assoc($equipmentInfo)) {
            $formatted_result[] = $r;
        }
        $db->close();

        print json_encode($formatted_result);
    }
?>