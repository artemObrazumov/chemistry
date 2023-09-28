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
        $workInfo = $db->query("SELECT * FROM works WHERE works.ID = ".$data["ID"].";");
        $formatted_result = array();
        while($r = mysqli_fetch_assoc($workInfo)) {
            $formatted_result[] = $r;
        }

        $formatted_result['equipment'] = [];
        $equipmentInfo = $db->query("SELECT st.equipmentQuantity, eq.ID, eq.name, eq.storage FROM equipmentset st INNER JOIN equipment eq on st.equipmentID = eq.ID WHERE workID = ".$data['ID'].";");
        while($r = mysqli_fetch_assoc($equipmentInfo)) {
            $formatted_result['equipment'][] = $r;
        }

        $formatted_result['reagents'] = [];
        $reagentsInfo = $db->query("SELECT rt.reagentMG, rt.reagentShelf, rt.reagentGroup, rg.ID, rg.name, rg.type, rgt.typeString, rg.note FROM reagentsset rt INNER JOIN reagents rg on rt.reagentID = rg.ID INNER JOIN reagenttypes rgt on rgt.typeID = rg.type WHERE workID = ".$data['ID'].";");
        while($r = mysqli_fetch_assoc($reagentsInfo)) {
            $formatted_result['reagents'][] = $r;
        }
        $db->close();

        print json_encode($formatted_result);
    }
?>