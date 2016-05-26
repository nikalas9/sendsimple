/**
 * @license Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 * For licensing, see LICENSE.md or http://ckeditor.com/license
 */

CKEDITOR.editorConfig = function( config ) {
	// Define changes to default configuration here. For example:
	config.language = builderLanguage;
	// config.uiColor = '#AADC6E';

    /*config.htmlbuttons = [
        {
            name:'ps',
            icon:'puzzle.png',
            title:'Переменные',
            items : [
                {
                    name:'button1',
                    title:'Веб-версия письма',
                    html:'{$link.web}'
                },
                {
                    name:'button2',
                    title:'Отписаться от рассылки',
                    html:'{$link.unsubscribe}'
                },
                {
                    name:'button3',
                    title:'Контакт: E-mail',
                    html:'{$contact.email}'
                }

            ]
        }
    ];*/


	config.toolbar = [
		{ name: 'document', groups: [ 'mode'], items: [ 'Sourcedialog'] },
		{ name: 'clipboard', groups: [ 'clipboard', 'undo' ], items: [ 'Undo', 'Redo' ] },
		{ name: 'paragraph', groups: [ 'list', 'indent', 'blocks' ], items: [ 'NumberedList', 'BulletedList', '-', 'Outdent', 'Indent', '-', 'Blockquote', 'CreateDiv'] },
		{ name: 'paragraph2', groups: ['align' ], items: ['JustifyLeft', 'JustifyCenter', 'JustifyRight', 'JustifyBlock' ] },
        { name: 'insert', items: [ 'Image','Table' /*'Cropper','ImageEditor'*/] },
        { name: 'links', items: [ 'Link', 'Unlink' ] },
        /*{ name: 'external', items: [ 'IconFont', 'Social',  'doksoft_button', 'HeaderFont' ] },*/
		'/',
		{ name: 'basicstyles', groups: [ 'basicstyles', 'cleanup' ], items: [ 'Bold', 'Italic', 'Underline', '-', 'RemoveFormat' ] },
		{ name: 'styles', items: [ 'Styles', 'Font', 'FontSize' ] },
		{ name: 'colors', items: [ 'TextColor', 'BGColor' ] },
        { name: 'ps', items: ['button_general','button_contact','button_action','button_if' ] }
	];
	//config.extraPlugins = 'sourcedialog,codemirror,sharedspace,social,htmlbuttons,iconfont,doksoft_button,headerfont';
    config.extraPlugins = 'sourcedialog,codemirror,sharedspace,htmlbuttons';

	config.enterMode = CKEDITOR.ENTER_BR;

    config.smiley_path = baseUrl+'/builder/images/social/';

    //config.contentsCss = '/builder/js/font-awesome/css/font-awesome.min.css';
    //config.doksoft_include_css = ['/builder/js/font-awesome/css/font-awesome.min.css'];

    config.filebrowserImageBrowseUrl = fileBrowserUrl;
    config.filebrowserWindowWidth = '80%';
    config.filebrowserWindowHeight = '80%';
    config.allowedContent = true;

	config.sharedSpaces = {
		top: 'toolbarLocation'
	}
};
