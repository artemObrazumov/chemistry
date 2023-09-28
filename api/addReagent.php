<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['name'] == null || $_GET['type'] == null) {
        print "{e: 'Not enough data to perform adding'}";
        http_response_code(400);
    } else {
        $data = ["name"=>$_GET['name'], "type"=>$_GET['type'], "note"=>$_GET['note'], "image"=>$_GET['image']];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("INSERT INTO `reagents` (name, type, note, image) VALUES ('". $data['name'] ."', ". $data['type'] .", '". $data['note'] ."', '". $data['image'] ."');");
        $data["ID"]=$db->insert_id;
        $typeStr = $db->query("SELECT * FROM reagenttypes WHERE typeID = ".$data['type']);
        $typeString = '';
        while($r = mysqli_fetch_assoc($typeStr)) {
            $typeString = $r['typeString'];
        }
        $data["typeString"] = $typeString;
        $db->close();
        print(json_encode($data));
    }

    function random_string($length) {
        $key = '';
        $keys = array_merge(range(0, 9), range('a', 'z'));
    
        for ($i = 0; $i < $length; $i++) {
            $key .= $keys[array_rand($keys)];
        }
    
        return $key;
    }
?>