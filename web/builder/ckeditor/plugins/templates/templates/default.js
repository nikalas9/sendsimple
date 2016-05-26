/*
 Copyright (c) 2003-2014, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.md or http://ckeditor.com/license
*/

blankLink = 'images/blank.gif';

CKEDITOR.addTemplates("default",{
	imagesPath:CKEDITOR.getUrl(
		CKEDITOR.plugins.getPath("templates")+"templates/images/"),
		templates:[
			{
				title:"Текст",
				image:"template1.gif",
				html:'<table width="100%" border="0" cellspacing="0" cellpadding="0" class="default"><tbody><tr><td height="10" class="td" border="0" colspan="3"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr><tr><td width="10" class="td" border="0"><img width="10" height="1" src="'+blankLink+'" class="img"></td><td valign="top" align="left" class="td" border="0"><div class="block-text-inner"><div class="block-content block-text text-editor default-text align-left block-text-clicked-processed">Текст блока</div></div></td><td width="10" class="td" border="0"><div style="line-height:0; width:10px; height:1px;"><img width="10" height="1" src="'+blankLink+'" class="img"></div></td></tr><tr><td height="10" class="td" border="0" colspan="3"><img width="1" height="10" src="'+blankLink+'" class="img"></td></tr></tbody></table>'
			},
			{
				title:"Картинка",
				image:"template1.gif",
				html:''
			},
			{
				title:"Разделитель",
				image:"template1.gif",
				html:''
			}
			
			
			
			
			
			
			
			
			
			
			/*{
				title:"Strange Template",
				image:"template2.gif",
				description:"A template that defines two colums, each one with a title, and some text.",
				html:'<table cellspacing="0" cellpadding="0" style="width:100%" border="0"><tr><td style="width:50%"><h3>Title 1</h3></td><td></td><td style="width:50%"><h3>Title 2</h3></td></tr><tr><td>Text 1</td><td></td><td>Text 2</td></tr></table><p>More text goes here.</p>'
			},
			{
				title:"Text and Table",image:"template3.gif",description:"A title with some text and a table.",html:'<div style="width: 80%"><h3>Title goes here</h3><table style="width:150px;float: right" cellspacing="0" cellpadding="0" border="1"><caption style="border:solid 1px black"><strong>Table title</strong></caption><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr><tr><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td></tr></table><p>Type the text here</p></div>'
			}*/
		]
	}
);