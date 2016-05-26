/**
 * Plugin inserting icon font elements into CKEditor editing area.
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */

// Register the plugin with the editor.
CKEDITOR.plugins.add( 'headerfont',
{
	// The plugin initialization logic goes inside this method.
	init: function( editor )
	{
		// Define an editor command that inserts an icon.
		editor.addCommand( 'headerFontDialog',new CKEDITOR.dialogCommand( 'headerFontDialog' ) );

		// Create a toolbar button that executes the plugin command.
		editor.ui.addButton( 'HeaderFont',
		{
			// Toolbar button tooltip.
			label: 'Insert header font',
			// Reference to the plugin command name.
			command: 'headerFontDialog',
			// Button's icon file path.
			icon: this.path + 'images/icon.png'
		} );

		
		// Add a dialog window definition containing all UI elements and listeners.
		CKEDITOR.dialog.add( 'headerFontDialog', function ( editor )
		{
			var dialog;
            var frameId = 'frame_' + editor.name;
		
			return {
				title : 'Header Font',
				minWidth : 450,
				minHeight : 500,
				resizable:true,
				contents :
				[
					{
						id : 'tab1',
						label:"Options",
						expand:true,
						padding:0,
						elements :
						[
							{
								type:"html",
								id:"previewHtml",
								html:'<iframe src="'+editor.plugins.headerfont.path+"dialog/iframe.php"+'" style="width: 100%; height: 500px" hidefocus="true" frameborder="0" '+'id="'+frameId+'"></iframe>'
							}
						]
					}
				],
				onLoad: function( event ) {
                    dialog = event.sender;
                },
                onOk:function(){

                    var dialogFrame = document.getElementById(frameId);

                    var text = dialogFrame.contentWindow.getText();
                    var link = dialogFrame.contentWindow.getLink(tempId);

                    $.get('/builder/ckeditor/plugins/headerfont/dialog/'+link,function(dataURL){
                        $.post('/index.php?r=temp/dataFileUpload&pk='+tempId,{'data':dataURL},function(imageLink){
                            editor.insertHtml( '<img alt="'+text+'" src="'+imageLink+'">');
                            dialog.hide();
                        });
                    });
                    return false;
                }
			};
		} );
	}
} );