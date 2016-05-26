/**
 * Plugin inserting icon font elements into CKEditor editing area.
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */

// Register the plugin with the editor.
CKEDITOR.plugins.add( 'image_editor',
{
	// The plugin initialization logic goes inside this method.
	init: function( editor )
	{
		// Define an editor command that inserts an icon.
		editor.addCommand( 'ImageEditorDialog',new CKEDITOR.dialogCommand( 'ImageEditorDialog' ) );

		// Create a toolbar button that executes the plugin command.
		editor.ui.addButton( 'ImageEditor',
		{
			// Toolbar button tooltip.
			label: 'Image Editor',
			// Reference to the plugin command name.
			command: 'ImageEditorDialog',
			// Button's icon file path.
			icon: this.path + 'images/icon.png'
		} );



        var id_frame = 1;
        var el;
		
		// Add a dialog window definition containing all UI elements and listeners.
		CKEDITOR.dialog.add( 'ImageEditorDialog', function ( editor )
		{
			var dialog;
		
			return {
				title : 'Image Editor',
				minWidth : 520,
				minHeight : 560,
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
								html:'<iframe src="#" style="width: 100%; height: 560px" hidefocus="true" frameborder="0" '+'id="image_editor_iframe_'+id_frame+'"></iframe>',
                                onHide:function(){
                                    id_frame = id_frame+1;
                                },
                                onShow:function(){
                                    var f=editor.getSelection();
                                    el = f.getSelectedElement();
                                    if(el&&(el.is("img"))){

                                        if($(el).attr('data-editor') == undefined){
                                            $(el).attr('data-editor',id_frame);
                                        }

                                        var dialogFrame = document.getElementById('image_editor_iframe_'+$(el).attr('data-editor'));
                                        dialogFrame.src = editor.plugins.image_editor.path+"dialog/iframe.php?imageLink="+$(el).attr('src');
                                    }
                                    else{
                                        alert('Image not selected');
                                        dialog.hide();
                                    }
                                }
							}
						]
					}
				],
				onLoad: function( event ) {
                    dialog = event.sender;
                },
                onOk:function(){

                    if(el){
                        var dialogFrame = document.getElementById('image_editor_iframe_'+$(el).attr('data-editor'));
                        var dataURL = dialogFrame.contentWindow.getData();

                        $.post('/index.php?r=temp/dataFileUpload&pk='+tempId,{'data':dataURL},function(imageLink){

                            //var image = '<img alt="'+$(el).attr('alt')+'" class="'+$(el).attr('class')+'" style="'+$(el).attr('style')+'" src="'+imageLink+'">';
                            //var g=CKEDITOR.dom.element.createFromHtml(image);
                            //g.replace(el);

                            $(el).attr('src',imageLink);
                            $(el).attr('data-cke-saved-src',imageLink);

                            dialog.hide();
                        });
                    }
                    return false;
                }
			};
		} );
	}
} );