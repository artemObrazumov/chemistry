<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Просмотр работы'; get_header() ?>

<div id="workProgress" class="workProgress">
    <svg id="prevButton" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg>
    
    <div class="progressContainer">
        <div id="progressState" class="progressState textContent">Этап работы: 1 / 10</div>
        <div id="progressBar" class="progressBar"><div id="progressBarInner" class="progressBarInner"></div></div>
    </div>
    
    <svg id="nextButton" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"><path d="M7.33 24l-2.83-2.829 9.339-9.175-9.339-9.167 2.83-2.829 12.17 11.996z"/></svg>
</div>

<div id="workContainer" class="workContainer">
    <div id="workItem1" class="workItem">
        <div class="workItemTitle header_text">Практическая работа №1 <br> «Приемы обращения с лабораторным оборудованием и нагревательными приборами»</div>
        <div class="textContent"> Техника безопасности: <br> <br>
        При зажигании спиртовки непосредственно после снятия колпачка, спиртовая плёнка на горлышке загорается в месте прилегания колпачка. Пламя проникает под диск с трубкой и вызывает воспламенение паров спирта внутри резервуара, что может привести к взрыву и выбросу диска вместе с фитилём. Чтобы избежать этого, необходимо на несколько секунд приподнять диск с фитилём для удаления паров. В случае возникновения воспламенения паров, следует быстро удалить предметы (например, тетрадь для практических работ) и вызвать учителя. <br> <br>
        Нельзя перемещать горящую спиртовку и не следует использовать ее в качестве источника зажигания для другой спиртовки. Рекомендуется использовать спички для зажигания спиртовки. <br> <br>
        Гасить спиртовку можно только одним способом – накрыть пламя фитиля колпачком. Колпачок должен находиться всегда под рукой.
        </div>
        <div class="modal_button">Дальше</div>
    </div>
    <div id="workItem2" class="workItem">
        <div class="workItemTitle header_text">Устройство штатива</div>
        <div class="textContent">Рассмотрите штатив, представленный на рисунке. Нарисуйте его и обозначьте основные части: <br>
        Чугунная подставка <br> 
        Стержень <br> 
        Муфта <br> 
        Лапка <br> 
        Кольцо <br> 
        Подсказка: Наводите мышь на элементы штатива для просмотра информации о них</div>
        <div id="standInteractive">
            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/stativ.jpg">
            <div id="standStand" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Подставка</div>
                </div>
            </div>
            <div id="standKernel" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Стержень</div>
                </div>
            </div>
            <div id="standCoupling" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Муфта</div>
                </div>
            </div>
            <div id="standPaw" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Лапка</div>
                </div>
            </div>
            <div id="standCircle" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Кольцо</div>
                </div>
            </div>
        </div>
        <div class="modal_button">Дальше</div>
    </div>
    <div id="workItem3" class="workItem">
        <div class="workItemTitle header_text">Устройство спиртовки</div>
        <div class="textContent">Рассмотрите спиртовку, представленную на рисунке. Нарисуйте его и обозначьте основные части: <br>
        Держатель фитиля <br> 
        Резервуар для спирта <br> 
        Фитиль <br> 
        Колпачок <br> 
        Подсказка: Наводите мышь на элементы спиртовки для просмотра информации о них</div>
        <div id="spirtInteractive">
            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/spirt.png">
            <div id="spirtHolder" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Держатель фитиля</div>
                </div>
            </div>
            <div id="spirtStorage" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Резервуар для спирта</div>
                </div>
            </div>
            <div id="spirtWick" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Фитиль</div>
                </div>
            </div>
            <div id="spirtCap" class="hoverInteractiveElement">
                <div class="hoverTip">
                    <div class="header_text">Колпачок</div>
                </div>
            </div>
        </div>
        <div class="modal_button">Дальше</div>
    </div>
    <div id="workItem4" class="workItem">
        <div class="workItemTitle header_text">Устройство спиртовки</div>
        <div class="textContent">
        1. Снять колпачок <br>
        2. Проверить плотно ли прилегает диск к отверстию сосуда <br>
        3. Зажечь спиртовку горящей спичкой (НЕЛЬЗЯ ЗАЖИГАТЬ СПИРТОВКУ ОТ ДРУГОЙ ГОРЯЩЕЙ СПИРТОВКИ!)<br>
        4. Погасить спиртовку накрыв пламя колпачком.<br>
        </div>
        <div id="spirtInteractiveGameTip" class="textContent">Нажмите на колпачок чтобы снять его</div>
        <div id="spirtInteractiveGame">
            <img id="spirtCapGame" src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/spirtCap.png">
            <img id="spirtSingle" src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/spirtSingle.png">
            <img id="spirtMatch" src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/match.png">

            <img id="spirtFireGame1" src="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/assets/img/fire.png">

            <div id="spirtWickGame"></div>
        </div>
        <div class="modal_button">Дальше</div>
    </div>
</div>

<script>

    let workItem = 1
    let workItems = 4

    let spirtInteractiveGameProgress = 0

    $("#spirtCapGame").click(()=>{
        if (spirtInteractiveGameProgress == 0) {
            spirtInteractiveGameProgress = 1
            $("#spirtCapGame").addClass("off")
            $("#spirtInteractiveGameTip").html("Нажмите на спичку чтобы зажечь ее")
            return
        }
        if (spirtInteractiveGameProgress == 4) {
            spirtInteractiveGameProgress = 5
            $("#spirtCapGame").removeClass("off")
            $("#spirtInteractiveGameTip").html("Опыт выполнен. Законспектируйте результаты в тетрадь")
            return
        }
    })

    $("#spirtMatch").click(()=>{
        if (spirtInteractiveGameProgress == 1) {
            spirtInteractiveGameProgress = 2
            $("#spirtFireGame1").fadeIn(300)
            $("#spirtInteractiveGameTip").html("Нажмите на фитиль чтобы зажечь его")
            return
        }
        if (spirtInteractiveGameProgress == 3) {
            spirtInteractiveGameProgress = 4
            $("#spirtMatch").addClass("delete")
            $("#spirtMatch").fadeOut(400)
            $("#spirtInteractiveGameTip").html("Нажмите на колпачок, чтобы накрыть им спиртовку и погасить спиртовку")
            return
        }
    })

    $("#spirtWickGame").click(()=>{
        if (spirtInteractiveGameProgress == 2) {
            spirtInteractiveGameProgress = 3
            $("#spirtMatch").addClass("on")
            $("#spirtFireGame1").addClass("on")
            $("#spirtInteractiveGameTip").html("Нажмите на спичку, чтобы убрать ее")
            return
        }
    })

    $(".modal_button").click(()=>{
        nextWorkItem()
    })

    $("#prevButton").click(()=>{
        prevWorkItem()
    })

    $("#nextButton").click(()=>{
        nextWorkItem()
    })

    function nextWorkItem() {
        if (workItem < workItems) {
            workItem += 1
            showCurrentItem()
        } else {
            window.location.href = '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/practice';
        }
    }

    function prevWorkItem() {
        if (workItem > 1) {
            workItem -= 1
            showCurrentItem()
        }
    }

    function showCurrentItem() {
        $(".workItem").css("display", "none")
        $(`#workItem${workItem}`).fadeIn(500)

        $("#progressBarInner").css("width", `${ workItem/workItems * 100 }%`)
        $("#progressState").text(`Этап работы: ${workItem} / ${workItems}`)
    }
    
    showCurrentItem()

</script>

<?php get_footer(); ?>