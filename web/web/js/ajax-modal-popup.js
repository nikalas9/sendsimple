/**
 * Created by nikalas9 on 13.01.2016.
 */
$(function(){

    $(document).on('click', '.showModalButton', function(e){

        e.preventDefault();

        if($(this).attr('data-modal')){
            var modalId = $(this).attr('data-modal');
        }
        else{
            var modalId = 'modalMd';
        }
        modalClear(modalId);

        document.getElementById(modalId+'HeaderTitle').innerHTML = '<h4>' + $(this).attr('data-title') + '</h4>';
        $('#'+modalId).modal({
            show: true,
            keyboard: false,
            backdrop: 'static'
        });

        $.ajax({
            url: $(this).attr('data-link'),
            context: document.body,
            success: function(result){
                $('#'+modalId)
                    .find('#'+modalId+'Content')
                    .html(result);
            },
            error: function(request, error){
                $('#'+modalId)
                    .find('#'+modalId+'Content')
                    .html(request.responseText);
            }
        });



        //dynamiclly set the header for the modal


        /*if ($('#modal').data('bs.modal').isShown) {
            $('#modal').find('#modalContent')
                .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        } else {
            //if modal isn't open; open it and load content
            $('#modal').modal('show')
                .find('#modalContent')
                .load($(this).attr('value'));
            //dynamiclly set the header for the modal
            document.getElementById('modalHeaderTitle').innerHTML = '<h4>' + $(this).attr('title') + '</h4>';
        }*/
    });

    function modalClear(modalId){
        /*$('.modal').modal('hide');*/
        $('#'+modalId).find('#'+modalId+'Content').html('<div class="text-center"><img src="/web/images/loading.gif"></div>')
    }

    $(document).on('show.bs.modal', '.modal', function (event) {
        var zIndex = 1050 + (10 * $('.modal:visible').length);
        $(this).css('z-index', zIndex);
    });

});