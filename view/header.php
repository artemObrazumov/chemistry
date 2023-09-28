<?php 
if ( $_COOKIE["token"] == "teacher" ) {} else if ( $_COOKIE["token"] == "student" ) {} else {
    header("Location: http://" . $_SERVER['SERVER_NAME'] . "/login"); 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/css/style.css?v=4">
    <!--<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.2.0/css/all.min.css">-->
    <title><?php echo $_GET['pageName'] ?></title>
</head>
<body>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <script>
        let classesListObject = `<select id="modal_class">
            <option value="7">7</option>
            <option value="8">8</option>
            <option value="9">9</option>
            <option value="10">10</option>
            <option value="11">11</option>
        </select>`
    </script>

    <div class="top">
        <img src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/burger.svg" id="burger_open">
    </div>
    <div class="navigation" id="navigation">
        <div class="navigation_wrapper">
            <?php 
            if ( $_COOKIE["token"] == "teacher" ) {
            ?>

            <a class="<?php if (strcmp('/reagents/', $_SERVER['REQUEST_URI']) === 0) {echo 'active';} ?>" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/reagents'?>">Реактивы</a>
            <a class="<?php if (strcmp('/calculators/', $_SERVER['REQUEST_URI']) === 0) {echo 'active';} ?>" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/calculators'?>">Калькуляторы</a>
            <a class="<?php if (strcmp('/equipment/', $_SERVER['REQUEST_URI']) === 0) {echo 'active';} ?>" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/equipment'?>">Оборудование</a>
            <a class="<?php if (substr( $_SERVER['REQUEST_URI'], 0, 7 ) === "/works/") {echo 'active';} ?>" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/works'?>">Практические работы</a>

            <?php
            } else if ( $_COOKIE["token"] == "student" ) {
            ?>
            
            <a class="<?php if (substr( $_SERVER['REQUEST_URI'], 0, 10 ) === "/practice/") {echo 'active';} ?>" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/practice'?>">Практические работы</a>
            
            <?php
            }
            ?>
            <a class="logout" href="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/logout'?>">Выход</a> 
        </div>
    </div>
    <div class="pageBlock">
    