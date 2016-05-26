
blockUpdateRow = null;
tempEditId = [];

colorModal = null;
updateModal = null;

//prevList = [];
//nextList = [];
//nowBack = null;

message = [];

function generateRandomId()
{
    var bl_id = 'bl_' + Math.floor( ( Math.random() * 1000000000 ) + 1 );
    tempEditId.push(bl_id);
    return bl_id;
}

function blockAdd(el)
{
    $(el).parents('.row-block').after('<div class="row-block"><div class="content-block"></div></div>');
    blockUpdateRow = $(el).parents('.row-block').next();
    blockUpdateSet('1','');
};

function blockRemove(el)
{
    var row = $(el).parents('.row-block');

    if (confirm(builderMessage.removeBlock)) {
        $(row).remove();
    }
};

function blockUpdateOpen(el)
{
    blockUpdateRow = $(el).parents('.row-block');

    var type = $(blockUpdateRow).children('.content-block').children().attr('data-type');
    if(type){
        $('#update-dialog-modal ul.changeBlock li').removeClass('active');
        $('#update-dialog-modal ul.changeBlock li.type'+type).addClass('active');
    }
    updateModal.dialog('open');
}

function blockUpdateSet(type,defaultText)
{
    var content = '';
    tempEditId = [];

    var tableColumn = 0;

    switch(type){
        // текст
        case '1':
            tableColumn = 3;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left">'+builderMessage.blockText+'</div></div></td>';
            break;
        // Картинка
        case '2':
            tableColumn = 3;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-center"><img width="624" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image" ></div></div></td>';
            break;
        // Разделитель
        case '3':
            tableColumn = 3;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-separator default-block align-left"><div class="divHr"><hr style="visibility: hidden; margin: 0;"></div></div></div></td>';
            break;
        // Заголовок 1
        case '4':
            tableColumn = 3;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-title text-editor default-title align-left">'+builderMessage.blockHeader1+'</div></div></td>';
            break;
        // Заголовок 2
        case '5':
            tableColumn = 3;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-title2 text-editor default-title2 align-left">'+builderMessage.blockHeader2+'</div></div></td>';
            break;
        // Заголовок 3
        case '6':
            tableColumn = 3;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-title3 text-editor default-title3 align-left">'+builderMessage.blockHeader3+'</div></div></td>';
            break;
        // Баннер
        case '7':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="644" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></div>';
            break;
        // Текст Текст
        case '8':
            tableColumn = 5;
            content = '<td width="307" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="307" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td>';
            break;
        // Текст Картинка
        case '9':
            tableColumn = 5;
            content = '<td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="1%" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-left "><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td>';
            break;
        // Картинка Текст
        case '10':
            tableColumn = 5;
            content = '<td width="1%" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-left "><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td>';
            break;
        // Картинка Картинка
        case '11':
            tableColumn = 5;
            content = '<td width="307" valign="top" align="center" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-center "><img width="307" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="307" valign="top" align="center" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-center "><img width="307" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td>';
            break;
        // Текст Текст Текст
        case '12':
            tableColumn = 10;
            content = '<td width="201" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="201" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="201" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-text text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td>';
            break;
        // Картинка Картинка Картинка
        case '13':
            tableColumn = 10;
            content = '<td width="201" valign="top" align="center" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-center "><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="201" valign="top" align="center" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-center "><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td width="201" valign="top" align="center" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-picture default-block align-center "><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td>';
            break;
        // Блок
        case '14':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></div>';
            break;
        // Блок - Блок
        case '15':
            content = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="default"><tbody><tr><td width="322" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="322" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="10" class="td" border="0"><div style="line-height:0; width:10px; height:1px;"><img width="10" height="1" src="'+blankLink+'" class="img"></div></td></tr></tbody></table>';
            break;
        // Блок - Блок - Блок
        case '16':
            content = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="default"><tbody><tr><td width="215" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="215" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td><td width="215" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-left ">'+builderMessage.blockText+'</div></div></td></tr></tbody></table>';
            break;

        case 'web':
            content = '<div class="info-region"><table border="0" cellspacing="0" cellpadding="0" class="default"><tbody><tr><td width="494" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor info-region-block "></div></div></td><td width="150" valign="top" align="left" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor info-region-block align-right ">'+builderMessage.blockWeb+'</div></div></td></tr></tbody></table></div>';
            break;

        case 'header1':
            content = '<table cellspacing="0" cellpadding="0" border="0" width="100%" class="es-header first"><tbody><tr><td height="10" class="td" border="0" colspan="5"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr><tr><td width="10" class="td" border="0"><div style="line-height:0; width:10px; height:1px;"><img width="10" height="1" src="'+blankLink+'" class="img"></div></td><td align="left" width="1%" valign="middle" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-logo align-left header-block"><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td align="left" valign="middle" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-name text-editor align-left header-name">'+builderMessage.blockHeader+'</div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td></tr><tr><td height="10" class="td" border="0" colspan="5"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr></tbody></table>';
            break;

        case 'contact1':
            content = '<table cellspacing="0" cellpadding="0" border="0" width="100%" class="es-footer"><tbody><tr><td height="10" class="td" border="0" colspan="5"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr><tr><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td align="left" valign="top" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-sender text-editor align-left footer-text">'+builderMessage.blockContact+'</div></div></td><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td align="left" width="1%" valign="middle" class="td" border="0"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-logo align-left footer-block"><img width="201" title="'+builderMessage.image+'" src="/builder/images/blank.gif" class="image"></div></div></td><td width="10" class="td" border="0"><div style="line-height:0; width:10px; height:1px;"><img width="10" height="1" src="'+blankLink+'" class="img"></div></td></tr><tr><td height="10" class="td" border="0" colspan="5"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr></tbody></table>';
            break;

        case 'footer':
            content = '<div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-text-inner"><div class="block-content block-block text-editor info-region-block align-center block-text-clicked-processed">'+builderMessage.blockFooter+'</div></div></div>';
            break;

        case 'news':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-block text-editor default-text align-center">'+builderMessage.blockNews+'</div></div></div>';
            break;


        case 'shadow1':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow.png" class="image"></div></div></div>';
            break;
        case 'shadow2':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow2.png" class="image"></div></div></div>';
            break;
        case 'shadow3':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow3.png" class="image"></div></div></div>';
            break;
        case 'shadow4':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow4.png" class="image"></div></div></div>';
            break;
        case 'shadow5':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow5.png" class="image"></div></div></div>';
            break;
        case 'shadow6':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow6.png" class="image"></div></div></div>';
            break;
        case 'shadow7':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow7.png" class="image"></div></div></div>';
            break;
        case 'shadow8':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow8.png" class="image"></div></div></div>';
            break;
        case 'shadow9':
            content = '<div class="default"><div id="'+generateRandomId()+'" class="edittable" contenteditable="true"><div class="block-content block-image default-block align-center"><img width="600" alt="" src="'+baseUrl+'/builder/images/block/shadow9.png" class="image"></div></div></div>';
            break;

    }

    if(tableColumn){
        content = '<table width="100%" border="0" cellspacing="0" cellpadding="0" class="default"><tbody><tr><td height="10" class="td" border="0" colspan="'+tableColumn+'"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr><tr><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td>'+content+'<td width="10" class="td" border="0"><div style="line-height:0; width:10px; height:1px;"><img width="10" height="1" src="'+blankLink+'" class="img"></div></td></tr><tr><td height="10" class="td" border="0" colspan="'+tableColumn+'"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr></tbody></table>';
    }

    var textList = [];
    if(defaultText){
        textList.push(defaultText);
    }
    $.each( $(blockUpdateRow).find('.text-editor'), function( i, val ) {
        textList.push($(val).html());
    });
    var pictureList = [];
    $.each( $(blockUpdateRow).find('.block-picture'), function( i, val ) {
        pictureList.push($(val).html());
    });

    $(blockUpdateRow).children('.content-block').html(content);
    $(blockUpdateRow).children('.content-block').children().attr('data-type',type);

    $.each( $(blockUpdateRow).find('.block-content'), function( i, val ) {
        if( $(val).hasClass('text-editor') ){
            var contentBl = textList.shift();
            if(contentBl && type != 'news'){
                $(val).html(contentBl);
            }
        }
        if( $(val).hasClass('block-picture') ){
            var contentBl = pictureList.shift();
            if(contentBl){
                $(val).html(contentBl);
                if(type == 11){
                    $(val).find('img').css('width','307px');
                }
                if(type == 9 || type == 10 || type == 13){
                    $(val).find('img').css('width','201px');
                }
                if(type == 2){
                    $(val).find('img').css('width','624px');
                }
                if(type == 7){
                    $(val).find('img').css('width','644px');
                }
            }
        }
    });

    $.each( tempEditId, function( i, val ) {
        CKEDITOR.inline( document.getElementById(val) );
    });

    if(updateModal){
        updateModal.dialog('close');
    }
}

function changeBackgroundColor(el)
{
    blockUpdateRow = $(el).parents('.row-block');

    var background = $(blockUpdateRow).children('.content-block').children().css('background-color');

    $('.cp-onclick').colorpicker('setColor',background);
    colorModal.dialog('open');
}

function changeBackgroundImage(el)
{
    blockUpdateRow = $(el).parents('.row-block');

    window.open('/index.php?r=temp/elfinderBrowse&pk='+tempId+'&background=row','_blank','width='+$(top.window).width()*0.8+',height='+($(top.window).height()*0.8));
}
function changeBackgroundImageRowCallback(url)
{
    if(blockUpdateRow){
        $(blockUpdateRow).children('.content-block').children().css({
            'background-image': 'url('+url+')',
            'background-repeat':'repeat',
            'background-position': 'center center'
        });
    }
}
function changeBackgroundImageBodyCallback(url)
{
    $('body').css({
        'background-image': 'url('+url+')',
        'background-repeat':'repeat',
        'background-position': 'center center'
    });
}

$(function() {

    $( "#sortable" ).sortable({
        handle: ".nav_sortable",
        placeholder: "mystate-highlight"
    });

    colorModal = $('#cp-dialog-modal').dialog({
        autoOpen:	false,
        minWidth:	500,
        modal:		true,
        buttons:	{
            'Применить': function() {
                var color = $('#cp-dialog-modal .ui-colorpicker-hex-input').val();
                $(blockUpdateRow).children('.content-block').children().css({
                    'background-image': '',
                    'background-repeat':'',
                    'background-position': '',
                    'background-color': '#'+color
                });
                $(this).dialog('close');
            }
        }
    });
    $('.cp-onclick').colorpicker({
        inlineFrame: false
    });

    updateModal = $('#update-dialog-modal').dialog({
        autoOpen:	false,
        width:	580,
        height:	500,
        modal: true
    });

    $( "#tabs" ).tabs();

    var colorModal2 = $('#cp2-dialog-modal').dialog({
        autoOpen:	false,
        minWidth:	500,
        modal:		true,
        buttons:	{
            'Применить': function() {
                var color = $('#cp2-dialog-modal .ui-colorpicker-hex-input').val();
                $('body').css({
                    'background-image': '',
                    'background-repeat': '',
                    'background-position': '',
                    'background-color': '#'+color
                });
                $(this).dialog('close');
            }
        }
    });
    $('.cp2-onclick').colorpicker({
        color: $('body').css('background-color'),
        inlineFrame: false
    });

    $('#changeBackgroundColorBody').click(function(){
        colorModal2.dialog('open');
    });
    $('#changeBackgroundImageBody').click(function(){
        window.open('/index.php?r=temp/elfinderBrowse&pk='+tempId+'&background=body','_blank','width='+$(top.window).width()*0.8+',height='+($(top.window).height()*0.8));
    });
});

// We need to turn off the automatic editor creation first.
//CKEDITOR.disableAutoInline = true;

CKEDITOR.on( 'instanceCreated', function( event ) {
    var editor = event.editor;
    var editorId = event.editor.name;

    editor.on( 'focus', function(event) {

        // save content
        /*if(prevList.length == 0){
            nowBack = $('#sortable').html();
        }
        nextList = [];
        if(!$('.prevBackup').hasClass('disabled')){
            $('.prevBackup').addClass('disabled');
        }
        if(!$('.nextBackup').hasClass('disabled')){
            $('.nextBackup').addClass('disabled');
        }*/

        // add nav

        $('#'+editorId).parents('.row-block').append(
            '<ul class="nav nav-pills nav-block-top" role="tablist">'+
                '<li class="nav_sortable" role="presentation"><a href="#"><span class="glyphicon glyphicon-sort"></span></a></li>'+
                '<li role="presentation"><a href="javascript:" onclick="changeBackgroundColor(this);"><span class="glyphicon glyphicon-tint"></span></a></li>'+
                '<li role="presentation"><a href="javascript:" onclick="changeBackgroundImage(this);"><span class="glyphicon glyphicon-picture"></span></a></li>'+
            '</ul>'+
            '<ul class="nav nav-pills nav-block-bottom" role="tablist">'+
                '<li role="presentation"><a class="nav_create" onclick="blockAdd(this);" href="javascript:"><span class="glyphicon glyphicon-plus"></span> '+builderMessage.addBlock+'</a></li>'+
                '<li role="presentation"><a href="javascript:" onclick="blockUpdateOpen(this);"><span class="glyphicon glyphicon-cog"></span></a></li>'+
                '<li role="presentation"><a class="nav_remove" href="javascript:" onclick="blockRemove(this);"><span class="glyphicon glyphicon-remove"></span></a></li>'+
            '</ul>'
        );

        $('#'+editorId).parents('.content-block').addClass('block-active');
    });

    editor.on( 'blur', function(event) {

        // remove nav
        $('.nav-block-top').remove();
        $('.nav-block-bottom').remove();
        $('.block-active').removeClass('block-active');

        // save content
        /*var content = $('#sortable').html();
        if(content != nowBack){
            prevList.push( nowBack );
            nowBack = content;
            navBackup();
        }*/
    });
});

/*function prevBackup()
{
    nextList.push(nowBack);

    var content = prevList.pop();
    $('#sortable').html(content);
    nowBack = content;

    closeCkeditors();
    $.each( $('#sortable .edittable'), function( i, val ) {
        var editableId = $(val).attr('id');
        CKEDITOR.inline( document.getElementById(editableId) );
    });
    navBackup();
}

function nextBackup()
{
    prevList.push(nowBack);

    var content = nextList.pop();
    $('#sortable').html(content);
    nowBack = content;

    closeCkeditors();
    $.each( $('#sortable .edittable'), function( i, val ) {
        var editableId = $(val).attr('id');
        CKEDITOR.inline( document.getElementById(editableId) );
    });
    navBackup();
}

function navBackup()
{
    if(prevList.length){
        $('.prevBackup').removeClass('disabled');
    }
    else{
        if(!$('.prevBackup').hasClass('disabled')){
            $('.prevBackup').addClass('disabled');
        }
    }
    if(nextList.length){
        $('.nextBackup').removeClass('disabled');
    }
    else{
        if(!$('.nextBackup').hasClass('disabled')){
            $('.nextBackup').addClass('disabled');
        }
    }
}*/

function closeCkeditors(){
    for(name in CKEDITOR.instances) {
        CKEDITOR.instances[name].destroy()
    }
}