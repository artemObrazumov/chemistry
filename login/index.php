<?php
    if (isset($_GET["login"])) {
        if($_GET["login"] == "teacher") {
            setcookie("token", "teacher", time() + 7 * 24 * 60 * 60, "/");
            ?>
            <script>
                window.location.href = '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/reagents';
            </script>
            <?php
        } else if($_GET["login"] == "student") {
            setcookie("token", "student", time() + 7 * 24 * 60 * 60, "/");
            ?>
            <script>
                window.location.href = '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/practice';
            </script>
            <?php
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <link rel="stylesheet" href="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/css/style.css?v=4">
        <title>Авторизация</title>
    </head>
    <body>
        <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>

        <div id="modal" class="modal_wrapper active" style="opacity: 1; display: flex;">
            <div class="modal_window modal_input">
            <form action="">
                <div class="modal_corner modal_top">Добро пожаловать!</div>
                <div class="modal_center">
                    <a href="?login=teacher"><div class="textContent">Войти как учитель</div></a>
                    <a href="?login=student"><div class="textContent">Войти как ученик</div></a>
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <button class="modal_button modal_accept">Войти</button>
                </div>
            </form>
            </div>
        </div>
    </body>
</html