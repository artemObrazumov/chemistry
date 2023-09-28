<?php 
    header("Access-Control-Allow-Methods: GET");
    header("Content-Type: application/json");

    if ($_GET['form'] == null) {
        print "{e: 'Not enough data to perform changes'}";
        http_response_code(400);
    } else {
        $data = ["form"=>$_GET['form']];
        $wData = json_decode($data['form'], true);
        if($wData['login'] == "teacher") {
            setcookie("token", "teacher");
            http_response_code(200);
        } else if($wData['login'] == "student") {
            setcookie("token", "student");
            http_response_code(200);
        } else {
            http_response_code(500);
        }
    }