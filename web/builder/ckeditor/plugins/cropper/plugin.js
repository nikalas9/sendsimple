/**
 * Plugin inserting icon font elements into CKEditor editing area.
 * @author Jesse Dobbelaere <jesse@dobbelaere-ae.be>
 */

// Register the plugin with the editor.
CKEDITOR.plugins.add( 'cropper',
{
	// The plugin initialization logic goes inside this method.
	init: function( editor )
	{
		// Define an editor command that inserts an icon.
		editor.addCommand( 'cropperDialog',new CKEDITOR.dialogCommand( 'cropperDialog' ) );

		// Create a toolbar button that executes the plugin command.
		editor.ui.addButton( 'Cropper',
		{
			// Toolbar button tooltip.
			label: 'Cropper',
			// Reference to the plugin command name.
			command: 'cropperDialog',
			// Button's icon file path.
			icon: this.path + 'images/icon.png'
		} );
		


        var id_frame = 1;
        var el;

		// Add a dialog window definition containing all UI elements and listeners.
		CKEDITOR.dialog.add( 'cropperDialog', function ( editor )
		{
			var dialog;
            /*var cropperFrame;*/

			return {
				title : 'Cropper',
				minWidth : 500,
				minHeight : 400,
				resizable:false,
				contents :
				[
					{
						id : 'tab1',
						label: "Options",
						expand:true,
						padding:0,
						elements :
						[
							{
								type:"html",
								id:"previewHtml",
								html:'<iframe src="#" style="width: 100%; height: 400px" hidefocus="true" frameborder="0" '+'id="cropper_iframe_'+id_frame+'"></iframe>',
                                onHide:function(){
                                    id_frame = id_frame+1;
                                },
                                onShow:function(){
                                    var f=editor.getSelection();
                                    el = f.getSelectedElement();
                                    if(el&&(el.is("img"))){

                                        if($(el).attr('data-cropper') == undefined){
                                            $(el).attr('data-cropper',id_frame);
                                        }

                                        var cropperFrame = document.getElementById('cropper_iframe_'+$(el).attr('data-cropper'));
                                        cropperFrame.src = editor.plugins.cropper.path+"dialog/iframe.php?imageLink="+$(el).attr('src');
                                    }
                                    else{
                                        alert('Image not selected');
                                        dialog.hide();
                                    }
                                    console.log(id_frame);
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
						var cropperFrame = document.getElementById('cropper_iframe_'+$(el).attr('data-cropper'));
						var dataURL = cropperFrame.contentWindow.getData();

                        $.post('/index.php?r=temp/dataFileUpload&pk='+tempId,{'data':dataURL},function(imageLink){

                            /*var image = '<img alt="'+$(el).attr('alt')+'" class="'+$(el).attr('class')+'" style="'+$(el).attr('style')+'" src="'+imageLink+'">';
                            var g=CKEDITOR.dom.element.createFromHtml(image);
                            g.replace(el);*/

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