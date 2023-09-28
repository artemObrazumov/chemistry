<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Оборудование'; get_header() ?>
<div>
    <div class="input_wrapper">
        Название оборудования: <input type="text" id="name" placeholder="Название">
    </div>
    <div class="input_wrapper">
        Место хранения оборудования: <input type="text" id="storage" placeholder="Место хранения">
    </div>
    <div class="input_wrapper">
        Изображение: <input type="file" id="image">
    </div>
    <p id="res"></p>
    <input id="newEquipmentSubmit" type="submit" value="Добавить в базу">
</div>

<div id="equipments_list" class="list"></div>

<script>
    function onEquipmentsLoaded() {
        $('.equipment_edit').off('click')
        $('.equipment_delete').off('click')
        $('.equipment_edit').on('click', function(){
            $('#modal').append(`<div class="modal_window modal_input">
                <div class="modal_corner modal_top">Редактирование оборудования</div>
                <div class="modal_center">
                    <div class="input_wrapper">
                        Название оборудования: <input id="modal_name" placeholder="Название" value="${$(this).attr('equipment-name')}"> <br>
                    </div>
                    <div class="input_wrapper">
                        Место хранения: <input id="modal_storage" placeholder="Место хранения" value="${$(this).attr('equipment-storage')}">
                    </div>
                    <input id="modal_id" type="hidden" value="${$(this).attr('equipment-id')}">
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <div class="modal_button modal_cancel">ОТМЕНА</div>
                    <div class="modal_button modal_accept" accept_action="submitChanges">ОК</div>
                </div>
            </div>`)
            openModal()
        })
        $('.equipment_delete').on('click', function(){
            $('#modal').append(`<div class="modal_window modal_input">
                <div class="modal_corner modal_top">Удаление оборудования</div>
                <div class="modal_center">
                    Вы действительно хотите удалить оборудование ${$(this).attr('equipment-name')}?
                    <input id="modal_id" type="hidden" value="${$(this).attr('equipment-id')}">
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <div class="modal_button modal_cancel">ОТМЕНА</div>
                    <div class="modal_button modal_accept" accept_action="removeEquipment">ОК</div>
                </div>
            </div>`)
            openModal()
        })
        $('.equipment_item').animate({'opacity': 1}, 300)
    }

    $('#newEquipmentSubmit').click(()=>{
        event.preventDefault()
        $('#res').html('Загрузка...')
        
        var file = document.querySelector('#image').files[0]
        if (file == undefined) {
            uploadEquipment()
            return
        }
        var formData = new FormData()
        formData.append('image', file)
        var xhr = new XMLHttpRequest()
        xhr.open('POST', '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/image.php')
        xhr.onload = function() {
            uploadEquipment(xhr.response)
            return
        }
        xhr.send(formData);
    })

    function uploadEquipment(image = "") {
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/addEquipment.php?name='+$('#name').val()+'&storage='+$('#storage').val()+'&image='+image,
            type: "POST",
            dataType: 'text',
            success: (response)=>{
                data = JSON.parse(response)
                $('#res').html('Получилось!')
                if ($('#equipments_list').hasClass('empty')) {
                    $('#equipments_list').removeClass('empty')
                    $('#equipments_list').html('')
                }
                $('#equipments_list').prepend(`<div style="opacity: 0" class="equipment_item" equipment-id="${data.ID}">
                            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/uploads/${data.image}" style="${ imgStyle(data.image) }">
                            <div class="equipment_textContent">${data.name} <br>Место хранения: ${data.storage}</div>
                            <div class="equipment_controls">
                                <div equipment-id="${data.ID}" equipment-name="${data.name}" equipment-storage="${data.storage}" class="equipment_control_button equipment_edit">Редактировать</div>
                                <div equipment-id="${data.ID}" equipment-name="${data.name}" class="equipment_control_button equipment_delete">Удалить</div>
                            </div>
                        </div>`)
                $('#equipments_list .equipment_item').first().animate({'opacity': 1}, 300)
                onEquipmentsLoaded()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus)
            }
        })
    }

    $(document).ready(()=>{
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getEquipment.php?reversed=1',
            type: "GET",
            success: (response)=>{
                data = response
                if (data.length > 0) {
                    for (var equipment in data) {
                        $('#equipments_list').append(`<div style="opacity: 0" class="equipment_item" equipment-id="${data[equipment].ID}">
                            <img src="<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/uploads/${data[equipment].image}" style="${ imgStyle(data[equipment].image) }">
                            <div class="equipment_textContent">${data[equipment].name} <br>Место хранения: ${data[equipment].storage}</div>
                            <div class="equipment_controls">
                                <div equipment-id="${data[equipment].ID}" equipment-name="${data[equipment].name}" equipment-storage="${data[equipment].storage}" class="equipment_control_button equipment_edit">Редактировать</div>
                                <div equipment-id="${data[equipment].ID}" equipment-name="${data[equipment].name}" class="equipment_control_button equipment_delete">Удалить</div>
                            </div>
                        </div>`)
                    }
                    onEquipmentsLoaded()
                } else {
                    $('#equipments_list').addClass('empty')
                    $('#equipments_list').html('Еще нет оборудования')
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
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/editEquipment.php?ID='+$('#modal_id').val()+'&name='+$('#modal_name').val()+'&storage='+$('#modal_storage').val(),
            type: "POST",
            dataType: 'text',
            success: (response)=>{
                data = JSON.parse(response)
                $('.modal_message').html('Получилось!')
                $(`.equipment_item[equipment-id="${data.ID}"] .equipment_textContent`).html(`${data.name} <br>Место хранения: ${data.storage}`)
                $(`.equipment_item[equipment-id="${data.ID}"] .equipment_edit`).attr('equipment-name', data.name)
                $(`.equipment_item[equipment-id="${data.ID}"] .equipment_edit`).attr('equipment-storage', data.storage)
                $(`.equipment_item[equipment-id="${data.ID}"] .equipment_delete`).attr('equipment-name', data.name)
                closeModal()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        })
    }

    function removeEquipment() {
        event.preventDefault()
        $('.modal_message').html('Загрузка...')
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/removeEquipment.php?ID='+$('#modal_id').val(),
            type: "POST",
            dataType: 'text',
            success: ()=>{
                $('.modal_message').html('Получилось!')
                $(`.equipment_item[equipment-id="${$('#modal_id').val()}"]`).fadeOut()
                closeModal()
            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(textStatus);
            }
        })
    }
</script>

<?php get_footer(); ?>