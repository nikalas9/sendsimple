(function() {
	var commandName = 'tblabel';
	
	CKEDITOR.plugins.add(commandName, {
		requires : [ 'dialog' ],

		init : function(editor) {

			editor.ui.addButton('TbLabel', {
				label : 'Переменные',
				command : commandName
			});
		}
	});

})();