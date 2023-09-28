<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Редактирование работы'; get_header() ?>

<div id="workHeader" class="header marginBot"></div>
<div id="workContent" style="display:none">
    <div class="main_input">
        <div class="input_wrapper marginBot">
            Название работы: <input id="name" placeholder="Название">
        </div>
        <div class="input_wrapper">
            Описание работы: <textarea id="workContentInput" rows="8" placeholder="Описание"></textarea>
        </div>
        <div class="list">
            <div class="work_element work_element_editing">
                <div class="editableField custom-select_field">
                    <div class="reagent_textContent">Класс:</div>
                    <div class="custom-select">
                        <div id="inputSelectionInvisible"></div>
                    </div>
                </div>
                <div class="editableField">
                    <div class="reagent_textContent">Учеников:</div>
                    <input id="students" placeholder="Учеников">
                </div>
                <div class="editableField">
                    <div class="reagent_textContent">Парт:</div>
                    <input id="desks" placeholder="Парт">
                </div>
                <div class="editableField">
                    <div class="reagent_textContent">Кол-во классов:</div>
                    <input id="classes" placeholder="Кол-во классов">
                </div>
            </div>
        </div>
    </div>

    <div class="header">Реактивы</div>
    <div id="reagents" class="list"> <div id="reagents_message"></div> </div>
    <div class="custom-select">
        <div id="reagentsSelect"></div>
    </div>
    <div id="reagentsAddButton" class="addButton marginBot">+ Добавить реактив</div>
    <div id="reagents_action_message"></div>

    <div class="header">Оборудование</div>
    <div id="equipment" class="list"> <div id="equipment_message"></div> </div>
    <div class="custom-select">
        <div id="equipmentSelect"></div>
    </div>
    <div id="equipmentAddButton" class="addButton marginBot">+ Добавить оборудование</div>
    <div id="equipment_action_message"></div>

    <div class="rightButton">
        <div class="modal_message"></div>
        <input id="saveWork" type="submit" class="rightButton" value="Сохранить">
    </div>
</div>

<script src="<?php echo "http://" . $_SERVER['SERVER_NAME'] . '/assets/js/selectInput.js'?>"></script>
<script>
    let listCounter = 0
    let reagents = []
    let equipmentS = []
    function loadLists() {
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getReagentsList.php?reversed=1',
            type: "GET",
            success: (response)=>{
                data = response
                if (data.length > 0) {
                    let reagentsList = '<select id="reagentsSelect">'
                    for (var reagent in data) {
                        reagentsList += `<option value="${data[reagent].ID}">${data[reagent].name}</option>`
                    }
                    reagentsList += '</select>'
                    $('#reagentsSelect').replaceWith(reagentsList)
                } else {
                    // TODO
                }
            },
            complete: ()=>{
                onListLoaded()
            }
        })

        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getEquipment.php?reversed=1',
            type: "GET",
            success: (response)=>{
                data = response
                if (data.length > 0) {
                    let equipmentList = '<select id="equipmentSelect">'
                    for (var equipment in data) {
                        equipmentList += `<option value="${data[equipment].ID}">${data[equipment].name}</option>`
                    }
                    equipmentList += '</select>'
                    $('#equipmentSelect').replaceWith(equipmentList)
                } else {
                    // TODO
                }
            },
            complete: ()=>{
                onListLoaded()
            }
        })
    }

    function onListLoaded() {
        listCounter++
        if (listCounter >= 2) {
            loadWorkData()
        }
    }

    $(document).ready(()=>{
        loadLists()
    })

    function loadWorkData() {
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getWorkInfo.php?ID=<?php echo $_GET['ID'] ?>',
            type: "GET",
            success: (response)=>{
                let data = response
                let workData = data[0]
                $('#workHeader').html(workData.name)
                $('#name').attr('value', workData.name)
                $('#workContentInput').html(workData.content)
                $('#inputSelectionInvisible').replaceWith(classesListObject)
                $(`#modal_class option[value=${workData.class}]`).attr('selected', '')
                $('#students').attr('value', workData.students)
                $('#desks').attr('value', workData.desks)
                $('#classes').attr('value', workData.classes)

                let reagentData = data['reagents']
                if (reagentData.length > 0) {
                    for(reagent in reagentData) {
                        $('#reagents').append(`
                        <div class="reagent_item reagent_item_editing" reagent-id="${reagentData[reagent].ID}">
                            <div class="reagent_textContent">Наименование:<br>${reagentData[reagent].name}</div>
                            <div class="reagent_textContent">Вид:<br>${reagentData[reagent].typeString}</div>
                            <div class="editableField">
                                <div class="reagent_textContent">Мл/г:</div>
                                <input id="reagent-${reagentData[reagent].ID}-mg" placeholder="Мл/г" value="${reagentData[reagent].reagentMG}">
                            </div>
                            <div class="reagent_textContent">Мл/г Общ:<br>Заполнится автоматически после сохранения работы</div>
                            <div class="editableField">
                                <div class="reagent_textContent">Шкаф:</div>
                                <input id="reagent-${reagentData[reagent].ID}-shelf" placeholder="Шкаф" value="${reagentData[reagent].reagentShelf}">
                            </div>
                            <div class="editableField">
                                <div class="reagent_textContent">Группа хранения:</div>
                                <input id="reagent-${reagentData[reagent].ID}-group" placeholder="Группа хранения" value="${reagentData[reagent].reagentGroup}">
                            </div>
                            <div class="reagent_textContent">Примечание:<br>${reagentData[reagent].note}</div>

                            <div class="remove_mark remove_reagent remove_reagent_unset" reagent-id="${reagentData[reagent].ID}" reagent-name="${reagentData[reagent].name}">x</div>
                        </div>
                        `)
                        reagents.push(reagentData[reagent].ID)
                    }
                } else {
                    $('#reagents_message').html('Нет информации о реактивах')
                }

                let equipmentData = data['equipment']
                if (equipmentData.length > 0) {
                    for(equipment in equipmentData) {
                        $('#equipment').append(`
                        <div class="equipment_item equipment_item_editing" equipment-id="${equipmentData[equipment].ID}">
                            <div class="equipment_textContent">Наименование:<br>${equipmentData[equipment].name}</div>
                            <div class="editableField">
                                <div class="equipment_textContent">Количество на парту:</div>
                                <input id="equipment-${equipmentData[equipment].ID}-quantity" placeholder="Количество" value="${equipmentData[equipment].equipmentQuantity}">
                            </div>
                            <div class="editableField">
                                <div class="equipment_textContent">Количество на класс:<br>Заполнится автоматически после сохранения работы</div>
                            </div>
                            <div class="equipment_textContent">Место хранения:<br>${equipmentData[equipment].storage}</div>

                            <div class="remove_mark remove_equipment remove_equipment_unset" equipment-id="${equipmentData[equipment].ID}" equipment-name="${equipmentData[equipment].name}">x</div>
                        </div>
                        `)
                        equipmentS.push(equipmentData[equipment].ID)
                    }
                } else {
                    $('#equipment_message').html('Нет информации об оборудовании')
                }

                setRemoveActions()

                $('#workContent').fadeIn(500)
                fixSelection()
            },
            error: (data, textStatus, xhr) => {
                $('#workContent').addClass('error')
                $('#workContent').html('Произошла ошибка при выполнении запроса')
            }
        })
    }

    $('#reagentsAddButton').on('click', ()=>{
        let reagentID = $('#reagentsSelect option:selected').val()

        if (reagents.includes(reagentID)) {
            $('#reagents_action_message').addClass('error')
            $('#reagents_action_message').html('Реактив уже находится в списке')
        } else {
            $.ajax({
                url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getReagentInfo.php?ID='+reagentID,
                type: "GET",
                success: (response)=>{
                    reagentData = response[0]
                    console.log(reagentData)
                    $('#reagents_message').html('')
                    $('#reagents').append(`
                    <div class="reagent_item reagent_item_editing" reagent-id="${reagentData.ID}">
                            <div class="reagent_textContent">Наименование:<br>${reagentData.name}</div>
                            <div class="reagent_textContent">Вид:<br>${reagentData.typeString}</div>
                            <div class="editableField">
                                <div class="reagent_textContent">Мл/г:</div>
                                <input id="reagent-${reagentData.ID}-mg" placeholder="Мл/г" value="0">
                            </div>
                            <div class="reagent_textContent">Мл/г Общ:<br>Заполнится автоматически после сохранения работы</div>
                            <div class="editableField">
                                <div class="reagent_textContent">Шкаф:</div>
                                <input id="reagent-${reagentData.ID}-shelf" placeholder="Шкаф" value="0">
                            </div>
                            <div class="editableField">
                                <div class="reagent_textContent">Группа хранения:</div>
                                <input id="reagent-${reagentData.ID}-group" placeholder="Группа хранения" value="0">
                            </div>
                            <div class="reagent_textContent">Примечание:<br>${reagentData.note}</div>

                            <div class="remove_mark remove_reagent remove_reagent_unset" reagent-id="${reagentData.ID}" reagent-name="${reagentData.name}">x</div>
                        </div>
                    `)
                    reagents.push(reagentID)

                    setRemoveActions()
                },
                error: (data, textStatus, xhr) => {
                    $('#reagents_action_message').addClass('error')
                    $('#reagents_action_message').html('Ошибка при получении данных реактива')
                }
            })
        }
    })

    $('#equipmentAddButton').on('click', ()=>{
        let equipmentID = $('#equipmentSelect option:selected').val()

        if (equipmentS.includes(equipmentID)) {
            $('#equipment_action_message').addClass('error')
            $('#equipment_action_message').html('Оборудование уже находится в списке')
        } else {
            $.ajax({
                url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getEquipmentItemInfo.php?ID='+equipmentID,
                type: "GET",
                success: (response)=>{
                    equipmentData = response[0]
                    $('#equipment_message').html('')
                    $('#equipment').append(`
                    <div class="equipment_item equipment_item_editing" equipment-id="${equipmentData.ID}">
                        <div class="equipment_textContent">Наименование:<br>${equipmentData.name}</div>
                        <div class="editableField">
                                <div class="equipment_textContent">Количество на парту:</div>
                                <input id="equipment-${equipmentData.ID}-quantity" placeholder="Количество" value="0">
                            </div>
                            <div class="editableField">
                                <div class="equipment_textContent">Количество на класс:<br>Заполнится автоматически после сохранения работы</div>
                            </div>
                        <div class="equipment_textContent">Место хранения:<br>${equipmentData.storage}</div>

                        <div class="remove_mark remove_equipment remove_equipment_unset" equipment-id="${equipmentData.ID}" equipment-name="${equipmentData.name}">x</div>
                    </div>
                    `)
                    setRemoveActions()
                    equipmentS.push(equipmentID)
                },
                error: (data, textStatus, xhr) => {
                    $('#equipment_action_message').addClass('error')
                    $('#equipment_action_message').html('Ошибка при получении данных оборудования')
                }
            })
        }
    })

    function setRemoveActions() {
        $('.remove_reagent_unset').on('click', function(){
            $('#modal').append(`<div class="modal_window modal_input">
                <div class="modal_corner modal_top">Удаление реактива</div>
                <div class="modal_center">
                    Вы действительно хотите удалить реактив ${$(this).attr('reagent-name')}?
                    <input id="modal_id" type="hidden" value="${$(this).attr('reagent-id')}">
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <div class="modal_button modal_cancel">ОТМЕНА</div>
                    <div class="modal_button modal_accept" accept_action="removeReagentLocally">ОК</div>
                </div>
            </div>`)
            openModal()
        })
        $('.remove_reagent_unset').removeClass('remove_reagent_unset')

        $('.remove_equipment_unset').on('click', function(){
            $('#modal').append(`<div class="modal_window modal_input">
                <div class="modal_corner modal_top">Удаление оборудования</div>
                <div class="modal_center">
                    Вы действительно хотите удалить оборудование ${$(this).attr('equipment-name')}?
                    <input id="modal_id" type="hidden" value="${$(this).attr('equipment-id')}">
                </div>
                <div class="modal_corner modal_bottom modal_bottom_controls">
                    <div class="modal_message"></div>
                    <div class="modal_button modal_cancel">ОТМЕНА</div>
                    <div class="modal_button modal_accept" accept_action="removeEquipmentLocally">ОК</div>
                </div>
            </div>`)
            openModal()
        })
        $('.remove_equipment_unset').removeClass('remove_equipment_unset')
    }

    function removeEl(arr, val) {
        while(arr.includes(val)) {
            const index = arr.indexOf(val)
            if (index > -1) {
                arr.splice(index, 1)
            }
        }
        return arr
    }

    function removeReagentLocally() {
        $(`.reagent_item_editing[reagent-id="${$('#modal_id').val()}"]`).remove()
        reagents = removeEl(reagents, $('#modal_id').val())
        closeModal()
    }

    function removeEquipmentLocally() {
        $(`.equipment_item_editing[equipment-id="${$('#modal_id').val()}"]`).remove()
        equipmentS = removeEl(equipmentS, $('#modal_id').val())
        closeModal()
    }

    $('#saveWork').on('click', ()=>{
        let workData = Object()
        let reagentData = Object()
        let equipmentData = Object()

        workData.ID = <?php echo $_GET['ID'] ?> 
        workData.name = $('#name').val()
        workData.class = $('#modal_class option:selected').val()
        workData.students = $('#students').val()
        workData.desks = $('#desks').val()
        workData.classes = $('#classes').val()
        workData.workContent = $('#workContentInput').val()

        let i = 0;
        $(".reagent_item_editing").each(function() {
            let reagentID = $(this).attr('reagent-id');
            let reagentDataSingle = Object()
            reagentDataSingle.reagentID = reagentID
            reagentDataSingle.reagentMG = $(`#reagent-${reagentID}-mg`).val()
            reagentDataSingle.reagentShelf = $(`#reagent-${reagentID}-shelf`).val()
            reagentDataSingle.reagentGroup = $(`#reagent-${reagentID}-group`).val()
            reagentData[i] = reagentDataSingle
            i++
        })

        i = 0
        $(".equipment_item_editing").each(function() {
            let equipmentID = $(this).attr('equipment-id');
            let equipmentDataSingle = Object()
            equipmentDataSingle.equipmentID = equipmentID
            equipmentDataSingle.equipmentQuantity = $(`#equipment-${equipmentID}-quantity`).val()
            equipmentData[i] = equipmentDataSingle
            i++
        })
        
        workData['reagentData'] = reagentData
        workData['equipmentData'] = equipmentData
        let jsonData = JSON.stringify(workData)
        console.log('<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/editWork.php?info='+jsonData)
        $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/editWork.php?info='+jsonData,
            type: "POST",
            dataType: 'text',
            success: (response)=>{
                window.location.href = '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/works/viewWork.php?ID=<?php echo $_GET['ID'] ?>';
            },
            error: (data, textStatus, xhr) => {
                $('#workContent').addClass('error')
                $('#workContent').html('Произошла ошибка при выполнении запроса')
            }
        })
    })

</script>

<?php get_footer(); ?>