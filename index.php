<?php 
if ( $_COOKIE["token"] == "teacher" ) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . "/reagents"); 
} else if ( $_COOKIE["token"] == "student" ) {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . "/practice"); 
} else {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . $_SERVER['REQUEST_URI'] . "/login"); 
}
?>