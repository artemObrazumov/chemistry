<?php
    include('dbData.php');
    header("Access-Control-Allow-Methods: POST");
    header("Content-Type: application/json");

    if ($_GET['name'] == null || $_GET['class'] == null || $_GET['students'] == null || $_GET['desks'] == null || $_GET['classes'] == null) {
        print "{e: 'Not enough data to perform adding'}";
        http_response_code(400);
    } else {
        $data = ["name"=>$_GET['name'], "class"=>$_GET['class'], "students"=>$_GET['students'], "desks"=>$_GET['desks'], "classes"=>$_GET['classes']];
        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $db->query("INSERT INTO `works` (name, class, students, desks, classes) VALUES ('". $data['name'] ."', ". $data['class'] .", ". $data['students'] .", ". $data['desks'] .", ". $data['classes'] .");");
        $data["ID"]=$db->insert_id;
        $db->close();
        print(json_encode($data));
    }
?>