
// Register the plugin with the editor.
CKEDITOR.plugins.add( 'social',
{
    requires: 'dialog',
    lang: 'en,ru',
    hidpi: true,

	// The plugin initialization logic goes inside this method.
	init: function( editor )
	{
		// Define an editor command that inserts an icon.
		editor.addCommand( 'social',new CKEDITOR.dialogCommand( 'social' ), {
            allowedContent: 'img[alt,height,!src,title,width]',
            requiredContent: 'img'
        } );

		// Create a toolbar button that executes the plugin command.
		editor.ui.addButton( 'Social',
		{
			label: editor.lang.social.toolbar,
			command: 'social',
			icon: this.path + 'images/icon.png'
		} );
        CKEDITOR.dialog.add( 'social', this.path + 'dialogs/social.js' );
	}
} );