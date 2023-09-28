</div>

<div id="modal" class="modal_wrapper" style="opacity:0;"></div>
<script>
    document.querySelector('#modal').addEventListener('click', function(e) {
        if (e.target.id == 'modal') {
            closeModal()
        }
    })
    
    function openModal() {
        $('#modal').css('display', 'flex')
        $('#modal').animate(
            {'opacity': '1'}, 300, ()=>{$('#modal').addClass('active')}
        )
        $('.modal_cancel').click(() => {
            closeModal()
        })
        $('.modal_accept').click(function() {
            if ($(this).attr('accept_action') == "submitChanges") {
                submitChanges()
            }
            if ($(this).attr('accept_action') == "removeReagent") {
                removeReagent()
            }
            if ($(this).attr('accept_action') == "removeEquipment") {
                removeEquipment()
            }
            if ($(this).attr('accept_action') == "addNewWork") {
                addNewWork()
            }
            if ($(this).attr('accept_action') == "removeWork") {
                removeWork()
            }

            if ($(this).attr('accept_action') == "removeReagentLocally") {
                removeReagentLocally()
            }
            if ($(this).attr('accept_action') == "removeEquipmentLocally") {
                removeEquipmentLocally()
            }
        })
    }
    
    function closeModal() {
        $('#modal').animate(
            {'opacity': 0}, 300, ()=>{$('#modal').css('display', 'none'); $('#modal').removeClass('active'); $('#modal').html('')}
        )
    }

    $('#burger_open').click(()=>{
        $('#navigation').toggleClass('active')
    })
</script>

</body>
</html>