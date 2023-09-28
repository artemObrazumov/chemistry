<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Реактивы'; get_header() ?>
<div class="main_input">
    <div class="input_wrapper">
        Название реактива: <input type="text" id="name" placeholder="Название">
    </div>
    <div class="input_wrapper">
        Тип реактива:
        <div class="custom-select">
            <div id="inputSelectionInvisible"></div>
        </div>
    </div>
    <div class="input_wrapper">
        Примечание: <input type="text" id="note" placeholder="Примечание">
    </div>
    <div class="input_wrapper">
        Изображение: <input type="file" id="image">
    </div>
    <p id="res"></p>
    <input id="newReagentSubmit" type="submit" value="Добавить в базу">
</div>

<div id="reagents_list" class="list"></div>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/assets/js/selectInput.js'?>"></script>
<script>
    let typeSelectBase = `
    <?php include('../api/dbData.php');

        $db = new mysqli($DBHOST, $DBUSERNAME, $DBUSERPASS, $DBNAME);
        $types = $db->query("SELECT * FROM reagenttypes;");
        while($r = mysqli_fetch_assoc($types)) {
            echo '<option value="'.$r["typeID"].'">'.$r["typeString"].'</option>';
        }
        $db->close(); ?>
    </select>`
    let typeSelect = `<select id="modal_type">${typeSelectBase}`
    let typeSelectType = `<select id="type">${typeSelectBase}`

    $('#inputSelectionInvisible').replaceWith(typeSelectType)
    fixSelection()

    function onReagentsLoaded() {
        $('.reagent_edit').off("click")
        $('.reagent_delete').off("click")
        $('.reagent_edit').on('click', function(){
            $('#modal').append(`<div class="modal_window modal_input">
                <div class="modal_corner modal_top">Редактирование реактива</div>
                <div class="modal_center">
                    <div class="input_wrapper">
                        Название реактива: <input id="modal_name" placeholder="Название" value="${$(this).attr('reagent-name')}"> <br>
                    </div>
                    <div class="input_wrapper">
                        Тип реактива: <div class="custom-select noselect">${typeSelect}</div>
                    </div>
                    <div class="input_wrapper">
                        Примечание: <textarea id="modal_note" rows="5" placeholder="Примечание">${$(this).attr('reagent-note')}</textarea>
                    </div>
                    <input id="modal_id" type="hidden" value="${$(this).attr('reagent-id')}">
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <div class="modal_button modal_cancel">ОТМЕНА</div>
                    <div class="modal_button modal_accept" accept_action="submitChanges">ОК</div>
                </div>
            </div>`)
            $(`#modal_type option[value=${$(this).attr('reagent-type')}]`).attr('selected', '')
            openModal()
            fixSelection()
        })
        $('.reagent_delete').on('click', function(){
            $('#modal').append(`<div class="modal_window modal_input">
                <div class="modal_corner modal_top">Удаление реактива</div>
                <div class="modal_center">
                    Вы действительно хотите удалить реактив ${$(this).attr('reagent-name')}?
                    <input id="modal_id" type="hidden" value="${$(this).attr('reagent-id')}">
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <div class="modal_button modal_cancel">ОТМЕНА</div>
                    <div class="modal_button modal_accept" accept_action="removeReagent">ОК</div>
                </div>
            </div>`)
            openModal()
            fixSelection()
        })
        $('.reagent_item').animate({'opacity': 1}, 300)
    }

    $('#newReagentSubmit').click(()=>{
        event.preventDefault()
        
        $('#res').html('Загрузка...')

        var file = document.querySelector('#image').files[0]
        if (file == undefined) {
            uploadNewReagent()
            return
        }
        var formData = new FormData()
        formData.append('image', file)
        var xhr = new XMLHttpRequest()
        xhr.open('POST', '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/image.php')
        xhr.onload = function() {
            uploadNewReagent(xhr.response)
            return
        }
        xhr.send(formData);
    })

    function uploadNewReagent(image = "") {
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/addReagent.php?name='+$('#name').val()+'&type='+$( "#type option:selected" ).val()+'&note='+$('#note').val()+'&image='+image,
            type: "POST",
            dataType: 'text',
            success: (response)=>{
                data = JSON.parse(response)
                $('#res').html('Получилось!')
                if ($('#reagents_list').hasClass('empty')) {
                    $('#reagents_list').removeClass('empty')
                    $('#reagents_list').html('')
                }
                $('#reagents_list').prepend(`<div style="opacity: 0" class="reagent_item" reagent-id="${data.ID}">
                            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/uploads/${data.image}" style="${ imgStyle(data.image) }">
                            <div class="reagent_textContent">${data.name} <br> Тип: ${data.typeString}</div>
                            <div class="reagent_controls">
                                <div reagent-id="${data.ID}" reagent-name="${data.name}" reagent-note="${data.note}" class="reagent_control_button reagent_edit">Редактировать</div>
                                <div reagent-id="${data.ID}" reagent-name="${data.name}" class="reagent_control_button reagent_delete">Удалить</div>
                            </div>
                        </div>`)
                if (data.note != null && data.note != "") {
                    $('#reagents_list > div').first().find('.reagent_textContent').append(`<br>Примечание: ${data.note}`)
                }
                $('#reagents_list .reagent_item').first().animate({'opacity': 1}, 300)
                onReagentsLoaded()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        })
    }

    $(document).ready(()=>{
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getReagentsList.php?reversed=1',
            type: "GET",
            success: (response)=>{
                data = response
                if (data.length > 0) {
                    for (var reagent in data) {
                        $('#reagents_list').append(`<div style="opacity: 0" class="reagent_item" reagent-id="${data[reagent].ID}">
                            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/uploads/${data[reagent].image}" style="${ imgStyle(data[reagent].image) }">
                            <div class="reagent_textContent">${data[reagent].name} <br> Тип: ${data[reagent].typeString}</div>
                            <div class="reagent_controls">
                                <div reagent-id="${data[reagent].ID}" reagent-name="${data[reagent].name}" reagent-type="${data[reagent].type}" reagent-note="${data[reagent].note}" class="reagent_control_button reagent_edit">Редактировать</div>
                                <div reagent-id="${data[reagent].ID}" reagent-name="${data[reagent].name}" class="reagent_control_button reagent_delete">Удалить</div>
                            </div>
                        </div>`)
                        if (data[reagent].note != null && data[reagent].note != "") {
                            $('#reagents_list > div').last().find('.reagent_textContent').append(`<br>Примечание: ${data[reagent].note}`)
                        }
                    }
                    onReagentsLoaded()
                } else {
                    $('#reagents_list').addClass('empty')
                    $('#reagents_list').html('Еще нет реактивов')
                }
                
            }
        })
    })

    function imgStyle(img) {
        if(img == "") return "display: none"
        else ""
    }

    function submitChanges() {
        event.preventDefault()
        $('.modal_message').html('Загрузка...')
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/editReagent.php?ID='+$('#modal_id').val()+'&name='+$('#modal_name').val()+'&type='+$('#modal_type option:selected').val()+'&note='+$('#modal_note').val(),
            type: "POST",
            dataType: 'text',
            success: (response)=>{
                data = JSON.parse(response)
                $('.modal_message').html('Получилось!')
                $(`.reagent_item[reagent-id="${data.ID}"] .reagent_textContent`).html(`${data.name} <br> Тип: ${data.typeString}`)
                if (data.note != null && data.note != '') {
                    $(`.reagent_item[reagent-id="${data.ID}"] .reagent_textContent`).append(`<br>Примечание: ${data.note}`)
                }
                $(`.reagent_item[reagent-id="${data.ID}"] .reagent_edit`).attr('reagent-name', data.name)
                $(`.reagent_item[reagent-id="${data.ID}"] .reagent_edit`).attr('reagent-type', data.type)
                $(`.reagent_item[reagent-id="${data.ID}"] .reagent_edit`).attr('reagent-note', data.note)
                $(`.reagent_item[reagent-id="${data.ID}"] .reagent_delete`).attr('reagent-name', data.name)
                closeModal()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        })
    }

    function removeReagent() {
        event.preventDefault()
        $('.modal_message').html('Загрузка...')
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/removeReagent.php?ID='+$('#modal_id').val(),
            type: "POST",
            dataType: 'text',
            success: ()=>{
                $('.modal_message').html('Получилось!')
                $(`.reagent_item[reagent-id="${$('#modal_id').val()}"]`).fadeOut()
                closeModal()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        })
    }
</script>

<?php get_footer(); ?>