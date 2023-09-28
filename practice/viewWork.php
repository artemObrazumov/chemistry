<?php header('Content-Type: text/html; charset=utf8', true); ?>
<?php include('../view/viewManager.php'); $_GET['pageName'] = 'Просмотр работы'; get_header() ?>

<div id="workHeader" class="header"></div>
<div id="workElementsContent">

    <div class="header">Описание работы</div>
        <div id="description" class="textContent">
    </div>

    <div class="header">Реактивы</div>
    <div id="reagents" class="viewList"> 
        <div id="reagents_message"></div> 
    </div>

    <div class="header">Оборудование</div>
    <div id="equipment" class="viewList marginBot"> 
        <div id="equipment_message"></div> 
    </div>
    <a href="<?php echo "http://" . $_SERVER['SERVER_NAME']?>/practice/work.php?ID=<?php echo $_GET['ID'] ?>"><input id="doWork" type="submit" class="centerButton" value="Пройти урок"></a>
</div>

<script>
    $.ajax({
            url: '<?php echo "http://" . $_SERVER['SERVER_NAME'] ?>/api/getWorkInfo.php?ID=<?php echo $_GET['ID'] ?>',
            type: "GET",
            success: (response)=>{
                let data = response
                let workData = data[0]
                $('#workHeader').html(workData.name)
                $('#workMainContent .listContent').html(`
                    <div class="textContent"> ${workData.class} класс </div>
                    <div class="textContent"> ${workData.students} </div>
                    <div class="textContent"> ${workData.desks} </div>
                    <div class="textContent"> ${workData.classes} </div>
                `)

                let reagentData = data['reagents']
                if (reagentData.length > 0) {
                    $('#reagents').append(`
                        <div class="reagent_item reagent_item_editing listHeader">
                            <div class="reagent_textContent">Наименование:</div>
                            <div class="reagent_textContent">Вид:</div>
                            <div class="reagent_textContent">Мл/г:</div>
                            <div class="reagent_textContent">Мл/г Общ:</div>
                            <div class="reagent_textContent">Шкаф:</div>
                            <div class="reagent_textContent">Группа хранения:</div>
                            <div class="reagent_textContent">Примечание:</div>
                        </div>
                        `)
                    for(reagent in reagentData) {
                        $('#reagents').append(`
                        <div class="reagent_item reagent_item_editing" reagent-id="${reagentData[reagent].ID}">
                            <div class="reagent_textContent">${reagentData[reagent].name}</div>
                            <div class="reagent_textContent">${reagentData[reagent].typeString}</div>
                            <div class="reagent_textContent">${reagentData[reagent].reagentMG}</div>
                            <div class="reagent_textContent">${reagentData[reagent].reagentMG * workData.desks}</div>
                            <div class="reagent_textContent">${reagentData[reagent].reagentShelf}</div>
                            <div class="reagent_textContent">${reagentData[reagent].reagentGroup}</div>
                            <div class="reagent_textContent">${reagentData[reagent].note}</div>
                        </div>
                        `)
                    }
                } else {
                    $('#reagents_message').parent().removeClass('viewList')
                    $('#reagents_message').html('Нет информации о реактивах')
                }

                let equipmentData = data['equipment']
                if (equipmentData.length > 0) {
                    $('#equipment').append(`
                        <div class="equipment_item equipment_item_editing listHeader">
                            <div class="equipment_textContent">Наименование:</div>
                            <div class="equipment_textContent">Количество на парту:</div>
                            <div class="equipment_textContent">Количество на класс:</div>
                            <div class="equipment_textContent">Место хранения:</div>
                        </div>
                        `)
                    for(equipment in equipmentData) {
                        $('#equipment').append(`
                        <div class="equipment_item equipment_item_editing" equipment-id="${equipmentData[equipment].ID}">
                            <div class="equipment_textContent">${equipmentData[equipment].name}</div>
                            <div class="equipment_textContent">${equipmentData[equipment].equipmentQuantity}</div>
                            <div class="equipment_textContent">${equipmentData[equipment].equipmentQuantity * workData.desks}</div>
                            <div class="equipment_textContent">${equipmentData[equipment].storage}</div>
                        </div>
                        `)
                    }
                } else {
                    $('#equipment_message').parent().removeClass('viewList')
                    $('#equipment_message').html('Нет информации об оборудовании')
                }

                console.log(data)
                if ( workData.content == "" ) {
                    $("#description").html( "Отсутствует" )
                } else {
                    $("#description").html( workData.content )
                }
                
                
                $('#workElementsContent').fadeIn(500)
                
                // ---------------------------------------------------
            },
            error: (data, textStatus, xhr) => {
                $('#workElementsContent').addClass('error')
                $('#workElementsContent').html('Произошла ошибка при выполнении запроса <br>Содержание ошибки: '+data.responseText)
            }
        })
</script>

<?php get_footer(); ?>