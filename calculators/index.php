<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Калькуляторы'; get_header() ?>

<div class="calculators_wrapper">
    <div>
        <div class="header_text calculator_top"> Калькулятор приготовления раствора </div>
        <div class="input_wrapper">
            <div class="input_pre">Объём раствора:</div> <input id="a1" placeholder="Объём раствора" min="0" type="number" value="1"> мл <br>
        </div>
        <div class="input_wrapper">
            <div class="input_pre">Концентрация раствора:</div> <input id="a2" placeholder="Концентрация раствора" min="0" type="number" value="1"> %
        </div>
        <input id="calcA" type="submit" value="Рассчитать">
        <div id="resA" class="calc_result">
            Введите значения и нажмите на кнопку "рассчитать"
        </div>
    </div>

    <div>
        <div class="header_text calculator_top"> Калькулятор разбавления растворов </div>
        <div class="input_wrapper">
            Объём раствора после разбавления: <input id="b1" placeholder="Объём раствора" min="0" type="number" value="1"> мл <br>
        </div>
        <div class="input_wrapper">
            Концентрация до разбавления: <input id="b2" placeholder="Концентрация раствора до разбавления" min="0" type="number" value="1"> %
        </div>
        <div class="input_wrapper">
            Концентрация после разбавления: <input id="b3" placeholder="Концентрация раствора после разбавления" min="0" type="number" value="1"> %
        </div>
        <input id="calcB" type="submit" value="Рассчитать">
        <div id="resB" class="calc_result">
            Введите значения и нажмите на кнопку "рассчитать"
        </div>
    </div>
</div>

<script>
    $('#calcA').click(()=>{
        if ($('#a1').val() <= 0 || $('#a2').val() <= 0 || $('#a2').val() > 100) {
            $('#resA').css('opacity', 0)
            $('#resA').animate(
                {'opacity': 1}, 400
            )
            $('#resA').addClass('error')
            $('#resA').html('Ошибка: введены некорректные данные')
        } else {
            let ans1 = ($('#a1').val() * $('#a2').val()/100).toFixed(2)
            let ans2 = $('#a1').val() - ans1
            $('#resA').html(`
                Масса вещества: ${ans1} г. <br>
                Объём воды: ${ans2} мл.
            `)
            $('#resA').removeClass('error')
            $('#resA').css('opacity', 0)
            $('#resA').animate(
                {'opacity': 1}, 400
            )
        }
    })

    $('#calcB').click(()=>{
        if ($('#b1').val() <= 0 || $('#b2').val() <= 0 || $('#b2').val() > 100 || $('#b3').val() <= 0 || $('#b3').val() > 100) {
            $('#resB').css('opacity', 0)
            $('#resB').animate(
                {'opacity': 1}, 400
            )
            $('#resB').addClass('error')
            $('#resB').html('Ошибка: введены некорректные данные')
        } else {
            let ans1 = ( ($('#b1').val()*$('#b3').val()/100) / ($('#b2').val()/100) ).toFixed(2)
            let ans2 = $('#b1').val() - ans1
            $('#resB').html(`
                Объём перед разбавлением: ${ans1} г. <br>
                Объём воды: ${ans2} мл.
            `)
            $('#resB').removeClass('error')
            $('#resB').css('opacity', 0)
            $('#resB').animate(
                {'opacity': 1}, 400
            )
        }
    })
</script>
<?php get_footer(); ?>