<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['info'] == null) {
        print "{e: 'Not enough data to perform changes'}";
        http_response_code(400);
    } else {
        $data = ["info"=>$_GET['info']];
        $wData = json_decode($data['info'], true);
        $rData = $wData['reagentData'];
        $eData = $wData['equipmentData'];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("UPDATE `works` SET name='". $wData['name'] ."', content='". $wData['workContent'] ."', class=". $wData['class'] .", students=". $wData['students'] .", desks=". $wData['desks'] .", classes=". $wData['classes'] ." WHERE ID=". $wData['ID'] .";");
        $db->query("DELETE from `reagentsset` WHERE workID=".$wData['ID'].";");
        $db->query("DELETE from `equipmentset` WHERE workID=".$wData['ID'].";");

        if (sizeof($rData) > 0) {
            $reagentQuery = "INSERT INTO `reagentsset` (workID, reagentID, reagentMG, reagentShelf, reagentGroup) VALUES ";
            foreach($rData as $reagent) {
                $reagentQuery .= "(".$wData['ID'].", ".$reagent['reagentID'].", ".$reagent['reagentMG'].", ".$reagent['reagentShelf'].", ".$reagent['reagentGroup']."), ";
            }
            $reagentQuery = substr($reagentQuery, 0, -2);
            $reagentQuery .= ";";
            $db->query($reagentQuery);
            echo $reagentQuery;
        }

        if (sizeof($eData) > 0) {
            $equipmentQuery = "INSERT INTO `equipmentset` (workID, equipmentID, equipmentQuantity) VALUES ";
            foreach($eData as $equipment) {
                $equipmentQuery .= "(".$wData['ID'].", ".$equipment['equipmentID'].", ".$equipment['equipmentQuantity']."), ";
            }
            $equipmentQuery = substr($equipmentQuery, 0, -2);
            $equipmentQuery .= ";";
            $db->query($equipmentQuery);
            echo $equipmentQuery;
        }

        $db->close();
        print('success');
    }