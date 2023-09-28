<?php
    setcookie("token", "", time() - 1, "/");
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login"); 
?>