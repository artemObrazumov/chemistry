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
        $reagentInfo = $db->query("SELECT r.ID, r.name, r.type, r.note, rt.typeString FROM reagents r INNER JOIN reagenttypes rt ON r.type=rt.typeID WHERE r.ID = ".$data["ID"].";");
        $formatted_result = array();
        while($r = mysqli_fetch_assoc($reagentInfo)) {
            $formatted_result[] = $r;
        }
        $db->close();

        print json_encode($formatted_result);
    }
?>