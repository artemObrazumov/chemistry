<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Практические работы'; get_header() ?>

<div id="addWork" class="addButton">+ Добавить работу</div>

<div id="worksList" class="worksList">
    <div id="worksClass7" class="worksClass">
        <div class="classHeader">7 Класс</div>
    </div>
    <div id="worksClass8" class="worksClass">
        <div class="classHeader">8 Класс</div>
    </div>
    <div id="worksClass9" class="worksClass">
        <div class="classHeader">9 Класс</div>
    </div>
    <div id="worksClass10" class="worksClass">
        <div class="classHeader">10 Класс</div>
    </div>
    <div id="worksClass11" class="worksClass">
        <div class="classHeader">11 Класс</div>
    </div>
</div>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/assets/js/selectInput.js'?>"></script>
<script>
    $(document).ready(()=>{
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getWorks.php',
            type: "GET",
            success: (response)=>{
                data = response
                if (data.length > 0) {
                    for (var work in data) {
                        console.log(data[work])
                        if (!$(`#worksClass${data[work].class}`).hasClass('active')) {
                            $(`#worksClass${data[work].class}`).addClass('active')
                            $(`#worksClass${data[work].class}`).fadeIn(300)
                        }
                        $(`#worksClass${data[work].class}`).append(`
                            <div class="work_element" work-id="${data[work].ID}">
                                <div class="work_element_textContent"> <a href="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/works/viewWork.php?ID=${data[work].ID}"> ${data[work].name} </a> </div>
                                <div class="work_controls">
                                    <div class="work_control_button work_edit"><a href="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/works/editWork.php?ID=${data[work].ID}">Редактировать</a></div>
                                    <div work-id="${data[work].ID}" work-name="${data[work].name}" class="work_control_button work_delete">Удалить</div>
                                </div>
                            </div>
                        `)
                    }
                    $('.work_delete').on('click', function(){
                        $('#modal').append(`<div class="modal_window modal_input">
                            <div class="modal_corner modal_top">Удаление работы</div>
                            <div class="modal_center">
                                <div>Вы действительно хотите удалить работу ${$(this).attr('work-name')}?</div>
                                <input id="modal_id" type="hidden" value="${$(this).attr('work-id')}">
                            </div>
                            <div class="modal_corner modal_bottom modal_bottom_controls">
                                <div class="modal_message"></div>
                                <div class="modal_button modal_cancel">ОТМЕНА</div>
                                <div class="modal_button modal_accept" accept_action="removeWork">ОК</div>
                            </div>
                        </div>`)
                        openModal()
                    })
                } else {
                    $('#worksList').addClass('empty')
                    $('#worksList').html('Еще нет практических работ')
                }
                
            }
        })
    })

    function removeWork() {
        event.preventDefault()
        $('.modal_message').html('Загрузка...')
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/removeWork.php?ID='+$('#modal_id').val(),
            type: "POST",
            dataType: 'text',
            success: ()=>{
                $('.modal_message').html('Получилось!')
                $(`.work_element[work-id=${$('#modal_id').val()}]`).fadeOut()
                closeModal()        
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        })
    }

    $('#addWork').on('click', function(){
        $('#modal').append(`<div class="modal_window modal_input">
            <div class="modal_corner modal_top">Добавление работы</div>
            <div class="modal_center">
                <div class="input_wrapper">
                    Название работы: <input id="modal_name" placeholder="Название"> <br>
                </div>
                <div class="input_wrapper">
                    Класс: <div class="custom-select">${classesListObject}</div>
                </div>
            </div>
            <div class="modal_corner modal_bottom modal_bottom_controls">
                <div class="modal_message"></div>
                <div class="modal_button modal_cancel">ОТМЕНА</div>
                <div class="modal_button modal_accept" accept_action="addNewWork">ОК</div>
            </div>
        </div>`)
        openModal()
        fixSelection()
    })

    function addNewWork() {
        event.preventDefault()
        $('.modal_message').html('Загрузка...')
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/addWork.php?name='+$('#modal_name').val()+'&class='+$( "#modal_class option:selected" ).val()+'&students=0&desks=0&classes=0',
            type: "POST",
            success: (response)=>{
                data = response
                window.location.href = '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/works/editWork.php?ID='+data.ID;
            }
        })
    }
</script>

<?php get_footer(); ?>