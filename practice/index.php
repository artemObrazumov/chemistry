<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Практические работы'; get_header() ?>

<div id="practiceList" class="practiceList">
    <div id="practiceClass7" class="practiceClass">
        <div class="classHeader">7 Класс</div>
    </div>
    <div id="practiceClass8" class="practiceClass">
        <div class="classHeader">8 Класс</div>
    </div>
    <div id="practiceClass9" class="practiceClass">
        <div class="classHeader">9 Класс</div>
    </div>
    <div id="practiceClass10" class="practiceClass">
        <div class="classHeader">10 Класс</div>
    </div>
    <div id="practiceClass11" class="practiceClass">
        <div class="classHeader">11 Класс</div>
    </div>
</div>

<script>
    $(document).ready(()=>{
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getWorks.php',
            type: "GET",
            success: (response)=>{
                data = response
                if (data.length > 0) {
                    for (var work in data) {
                        if (data[work].class != 8) continue
                        console.log(data[work])
                        if (!$(`#practiceClass${data[work].class}`).hasClass('active')) {
                            $(`#practiceClass${data[work].class}`).addClass('active')
                            $(`#practiceClass${data[work].class}`).fadeIn(300)
                        }
                        $(`#practiceClass${data[work].class}`).append(`
                            <div class="work_element" work-id="${data[work].ID}">
                                <div class="work_element_textContent"> <a href="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/practice/viewWork.php?ID=${data[work].ID}"> ${data[work].name} </a> </div>
                                
                            </div>
                        `)
                    }
                } else {
                    $('#practiceList').addClass('empty')
                    $('#practiceList').html('Еще нет практических работ')
                }
                
            }
        })
    })
</script>

<?php get_footer();